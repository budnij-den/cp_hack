<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DateTime;

class VariablesController extends Controller
{
    static
        $months = [
            '','Января', 'Февраля', 'Марта',
            'Апреля', 'Мая', 'Июня',
            'Июля', 'Августа', 'Сентября',
            'Октября', 'Ноября', 'Декабря'
        ],

        $days = [
            '','Пн', 'Вт', 'Ср',
            'Чт', 'Пт', 'Сб', 'Вс'
        ],

        $slba = [
            'МА', 'ДЖ', 'ЙГ', 'ПБ', 'ГП', 'ШБ', 'ГА'
        ],

        $stts = [
            '+' => 1, 'o' => 0.5, 'c' => 1, 'n' => 0, '-' => 1, 'b' => 1, '/' => 1
        ],

        $dzhapaStatuses = [
            'c' => 16, 'n' => 0, '-' => 16, 'b' => 16, '/' => 16
        ];

    public static function timeSet()
    {
        $now = new DateTime();
        $mangalarati = new DateTime('4:30:00');
        $dzapa = new DateTime('6:00:00');
        $meetDeity = new DateTime('7:45:00');
        $gauraArati = new DateTime('18:00:00');
        $diff0 = $now->getTimestamp() - $mangalarati->getTimestamp();
        $diff1 = $now->getTimestamp() - $dzapa->getTimestamp();
        $diff2 = $now->getTimestamp() - $meetDeity->getTimestamp();
        $diff3 = $now->getTimestamp() - $gauraArati->getTimestamp();
        if (($diff0 < 300) && (-$diff0 < 1200))
            $slb = 'МА';
        elseif (abs($diff1) < 3900)
            $slb = 'ДЖ';
        elseif (($diff2 < 300) && (-$diff2 < 1200))
            $slb = 'ПБ';
        elseif (($diff3 < 300) && (-$diff3 < 1200))
            $slb = 'ГА';
        else $slb = null;

        return compact('now', 'slb');
    }
}