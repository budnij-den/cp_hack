<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyFunctions extends Controller
{

    public static function destroySession() {

         $_SESSION = [];
         if (session_id() != "" || isset($_COOKIE[session_name()]))
             setcookie(session_name(), '', time() + 60*60*24*3, '/');
         session_destroy();
     }

    public static function search($var1, Request $request) {

        $arraySearch = explode (",", $var1);
        switch ($request->srch) {
            case 'name':
                foreach ($arraySearch as $key => $value) {
                    $res = DB::table('brahs')
                        ->where('name', 'like', $value)
                        ->select('name', 'tel', 'city')
                        ->get();
                }
              break;
            case 'sign':
                foreach($arraySearch as $key => $value) {
                     $res = DB::table('slbs')
                         ->where('stts', 'like', $value)
                         ->select('user_id', 'slba', 'data')
                         ->get();
                }
              break;
            default:
                 $res = 'Выберите тип поиска';
              break;
         }
         if (!$res)
             return false;
         return $res;
    }

    public static function updateOrInsert($var1, $var2, $var3, $var4)
    {        // Функция создания новой записи в таблице
        if (is_array($var1)) {                                                    //создание администратором
            for ($i = 0; $i < count($var1); $i++) {                                    //множества записей
                if (is_array($var3)) {
                    for ($j = 0; $j < count($var3); $j++) {
                        DB::table('slbs')
                            ->updateOrInsert(
                                ['user_id' => $var1[$i], 'data' => $var2, 'slba' => $var3[$j]],
                                ['stts' => $var4]
                            );
                    }
                }
            }
        } else {
            DB::table('slbs')
                ->updateOrInsert(
                    ['user_id' => $var1, 'data' => $var2, 'slba' => $var3],
                    ['stts' => $var4]
                );
        }
     }

        public static function delete($var1, $var2, $var3) {							// Функция удаления данных

         if (is_array($var1)) {													//удаление администратором
             for ($i = 0; $i < count($var1); $i++) {								//множества записей
                 if (is_array($var3)) {
                     for ($j = 0; $j < count($var3); $j++) {
                         DB::table('slbs')
                             ->where('user_id', $var1[$i])
                             ->where('data', $var2)
                             ->where('slba', $var3[$j])
                             ->delete();
                     }
                 }
             }
         }
         else {
             DB::table('slbs')
                 ->where('user_id', $var1)
                 ->where('data', $var2)
                 ->where('slba', $var3)
                 ->delete();
         }
     }
}
