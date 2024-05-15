<?php

namespace App\Repositories\Base;

use App\Models\BaseAPI;

use Illuminate\Support\Facades\Http;

class BaseAPIRepositories{
    
    public static function twitchBearer(){
        $datas = BaseAPI::where([
            ['base_link_id', '=', '1']
        ])->get();

        foreach($datas AS $data){
            $tokenStatus = Http::acceptJson()->withHeaders([
                'Authorization' => 'Bearer ' . $data->bearer,
                'Client-Id'     => $data->client_id,
            ])->get('https://id.twitch.tv/oauth2/validate')->status();

            if($tokenStatus !== 200){
                $tokenOauth = Http::post('https://id.twitch.tv/oauth2/token', [
                    'client_id'     => $data->client_id,
                    'client_secret' => $data->client_secret,
                    'grant_type'    => 'client_credentials',
                ])->json();

                BaseAPI::where([
                    ['base_link_id', '=', '1'],
                    ['client_id', '=', $data->client_id],
                    ['client_secret', '=', $data->client_secret],
                ])->update([
                    'bearer' => $tokenOauth['access_token'],
                ]);
            }
        }
    }

    public static function youtubeArchive(){
        // $apiKey = BaseAPI::where('base_link_id', '=', '2')->inRandomOrder()->first()->client_key;

        // $params = array(
        //     'part'          => "snippet,contentDetails",
        //     'channelId'     => "UC9Mfuai-qdXnTTFN0Z3hkAA",
        //     'maxResults'    => "256",
        //     'key'           => $apiKey,
        // );

        // $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/activities', $params);

        // return $http->json();

        // Shinon
        $http = Http::get('https://www.youtube.com/channel/UC-ruxaqjQ5fP7q3UTWi4lWw/live');

        // Waka
        // $http = Http::get('https://www.youtube.com/channel/UCIRQxP7jORi6jsLt0HmUmqQ/live');

        // return $http->body();

        return strpos($http->body(), '"isLive":true');

        // if(strpos($http->body(), '{"text":" Streaming"}') !== false){
        //     return "A";
        // }
        // else{
        //     return "B";
        // }
    }

}
