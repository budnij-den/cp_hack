<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slb;
use App\User;

class MysqlRequests extends Controller
{
    public static function programm() {

        $row1 = User::whereNotIn('users.right', ['adm', 'out'])
            ->select('name','sname','id','right')
            ->orderBy( 'users.id', 'asc')
            ->get();

        for ($j = 0; $j < count($row1); $j++)
        {
            if ($row1[$j]->sname !== NULL)
                $row1[$j]->name = $row1[$j]->sname;
            unset($row1[$j]->sname);
        }

        $alrt = Slb::where('data', (new \DateTime)->format('Y-m-d'))
            ->where('user_id', auth()->id())
            ->select('user_id')
            ->get();

        return compact('row1', 'alrt');
    }
}