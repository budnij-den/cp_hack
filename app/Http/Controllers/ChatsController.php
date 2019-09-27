<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chat');
    }

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
         $message = auth()->user()->messages()->create([
            'message' => $request->message
        ]);
         broadcast(new MessageSent($message->load('user')))->toOthers();
         return ['status' => 'Message Sent!'];
    }

    public function deleteMessage($id = null)
    {
        if(!\Request::ajax()) {
            return abort(404);
        }
        else {
            $message = Message::findOrFail($id);
            $message->delete();
            return response()->json($message, 200);
        }
    }
}