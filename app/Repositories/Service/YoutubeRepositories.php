<?php

namespace App\Repositories\Service;

use App\Models\BaseAPI;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class YoutubeRepositories{
    public static function verifyViaChannel($channelID, $uniqueID){
        // return $channelID;

        $abc = "https://www.youtubes.com/channel/UCIRQxP7jORi6jsLt0HmUmqQ";

        $checkString = Str::contains($abc, "https://www.youtubes.com/channel/");

        if($checkString == true){
            $checkChannel = Str::of($abc)->afterLast('/');

            if(Str::of($checkChannel)->length() == 24){
                $apiKey = BaseAPI::where('base_link_id', '=', '2')->inRandomOrder()->first()->client_key;

                $params = [
                    'id'    => "UCIRQxP7jORi6jsLt0HmUmqQ",
                    'key'   => $apiKey,
                    'part'  => "snippet,statistics",
                ];

                $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/channels', $params)->json();

                if($http['pageInfo']['totalResults'] >= 1){
                    foreach($http['items'] AS $data);

                    $checkUnique = Str::contains($data['snippet']['description'], $uniqueID);

                    if($checkUnique == true){
                        return "Insert";
                    }
                    else{
                        return "Code not found";
                    }
                }
                else{
                    return "Channel not found";
                }
            }
            else{
                return "String channel error";
            }
        }
        else{
            return "Channel error";
        }

        // return Str::of($abc)->afterLast('/');

        // return $http['pageInfo']['totalResults']; // Ok

        // foreach($http['items'] AS $data);

        // $check = Str::contains($data['snippet']['description'], $uniqueID);

        // if($check == true){
        //     return "Insert";
        // }
        // else{
        //     return "Error";
        // }

        // if($http->ok()){
        //     foreach($http['items'] AS $data){
        //         UserLinkTracker::where([
        //             ['users_id', '=', $userId],
        //             ['identifier', '=', $channelId],
        //         ])->update([
        //             'name'          => $data['snippet']['title'],
        //             'avatar'        => $data['snippet']['thumbnails']['medium']['url'],
        //             'subscriber'    => $data['statistics']['hiddenSubscriberCount'] == false ? $data['statistics']['subscriberCount'] : '0',
        //         ]);
        //     }
        // }
    }
}
