<?php

namespace App\Http\Controllers;

use App\PhotoFact;
use App\Project;
use App\Slb;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $owner_id = "-186978175";
        $app_access = "443a9e71443a9e71443a9e71354457840f4443a443a9e7119b4943084bbaaf964138641";
        $user_access = "93606406c38d4efca6586dad5ec39fc26b034a47c8a56d59002bca6394b10cdc72472835f6987ef5af279";

//сначала получаем идентификатор альбома с названием "фотоотчет"
        $query = file_get_contents("https://api.vk.com/method/photos.getAlbums?owner_id=" . $owner_id . "&access_token=" . $app_access . "&v=5.0.1");
        $result = json_decode($query, true);

        $albumId = [];
//шаблонизируем поиск названия "фотоотчет"
        $substring = 'отч';
        $substrf = 'фото';

        foreach ($result['response'] as $objects) {
            if (is_array($objects))
                foreach ($objects as $o) {
                    //echo $o['id'].": ".$o["title"]."<br>";
                    if ((stripos($o["title"], $substring) and stripos($o["title"], $substrf)
                        || stripos($o["title"], $substring) == 0
                        || stripos($o["title"], $substrf) == 0)) {
                        $albumId[] = $o['id'];
                    };
                };
        };

//теперь забираем данные фотографий в найденном альбоме
        for ($i = 0; $i < count($albumId); $i++) {
            if(!isset(User::where('id', $albumId[$i])->get()[0])) {
                User::create([
                    'name' => 'Волонтёр ' . ($i+1),
                    'id' => $albumId[$i]
                ]);
            }
            $getPhotosUri[$i] = "https://api.vk.com/method/photos.get?owner_id=" . $owner_id . "&album_id=" . $albumId[$i] . "&count=50&access_token=" . $user_access . "&v=5.0.1";
            $photosJSON = file_get_contents($getPhotosUri[$i]);
            $parsedPhotos = json_decode($photosJSON, true);

//и отправляем в базу
            foreach ($parsedPhotos['response'] as $objects) {
                if (is_array($objects)) {
                    foreach ($objects as $photo) {
                        if(!isset(PhotoFact::where('photoId', $photo['id'])->get()[0])) {
                            if (isset($photo['lat'])) {
                                PhotoFact::create([
                                    'photoId' => $photo['id'],
                                    'album_id' => $photo['album_id'],
                                    'user_id' => $photo['user_id'],
                                    'comment' => $photo['text'],
                                    'unix_sec' => $photo['date'],
                                    'latitude' => $photo['lat'],
                                    'longitude' => $photo['long'],
                                ]);
                            } else {
                                PhotoFact::create([
                                    'photoId' => $photo['id'],
                                    'album_id' => $photo['album_id'],
                                    'user_id' => $photo['user_id'],
                                    'comment' => $photo['text'],
                                    'unix_sec' => $photo['date'],
                                ]);
                            }
                        }
                    }
                }
            };

            $photos[$i] = PhotoFact::where('album_id', $albumId[$i])
                ->select('photoId', 'latitude', 'longitude', 'album_id')
                ->orderBy('unix_sec')
                ->get()
                ->toArray();
//            dd($photos[$i]);

            $photoes = [];
            $distance = [];
            for ($j = 0; $j < count($photos[$i]); $j++) {
                if (($j > 0) && isset($photos[$i][$j]->latitude)) {
                    echo 'hello';
                    $radian = (float)(3.14 / 360);
                    $distance[$i][$j] = acos(sin($photos[$i][$j]->latitude * $radian) * sin($photos[$i][$j-1]->latitude * $radian) +
                        cos($photos[$i][$j]->latitude * $radian) * cos($photos[$i][$j]->latitude * $radian) *
                        cos($radian * ($photos[$i][$j]->longitude - $photos[$i][$j-1]->longitude))) * 6371000;
//                    dd($distance[$i][$j]);
                    PhotoFact::where('photoId', $photos[$i][$j]->photoId)
                        ->update([
                            'distance' => $distance[$i][$j]
                        ]);
                }
                $photoes[$i][$j] = PhotoFact::where('album_id', $albumId[$i])
                    ->select('distance')
                    ->get()[$j]
                    ->toArray()['distance'];
            }

            $distanceSum[$i] = array_sum($photoes[$i]);
            if ($distanceSum[$i] > 0) {
                User::where('id', $albumId[$i])
                    ->update([
                        'distance' => $distanceSum[$i]
                    ]);
            }
        }
//        dd($photoes);
        return view('user.all');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        auth()->user()->update([
            'lastSeen_at' => $request->lastSeen_at
        ]);
        return ['status' => 'lastSeen status updated!'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $this->create();
        return User::all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     */
    public function edit()
    {
        return PhotoFact::select('photoId', 'created_at', 'distance')
            ->get()
            ->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
