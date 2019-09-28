<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use App\PhotoFact;
use App\User;
use Illuminate\Http\Request;

class ChatsController extends Controller
{

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
        $user = User::where('id', '1704')->get()['0'];
        $message = $user->messages()->create([
            'message' => $request->message
        ]);
        broadcast(new MessageSent($message->load('user')))->toOthers();
        return ['status' => 'Message Sent!'];
    }

    public function deleteMessage($id = null)
    {
        if (!\Request::ajax()) {
            return abort(404);
        } else {
            $message = Message::findOrFail($id);
            $message->delete();
            return response()->json($message, 200);
        }
    }
}