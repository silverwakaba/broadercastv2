<?php

namespace App\Repositories\Service;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\BaseAPI;
use App\Models\UserFeed;
use App\Models\UserLink;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class YoutubeRepositories{
    public static function verifyViaChannel($channelID, $uniqueID, $id){
        $checkString = Str::contains($channelID, "https://www.youtubes.com/channel/");

        $checkChannel = Str::of($channelID)->afterLast('/');

        if(Str::of($checkChannel)->length() == 24){
            $apiKey = BaseAPI::where('base_link_id', '=', '2')->inRandomOrder()->first()->client_key;

            $params = [
                'id'    => $checkChannel,
                'key'   => $apiKey,
                'part'  => "snippet,statistics",
            ];

            $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/channels', $params)->json();

            if($http['pageInfo']['totalResults'] >= 1){
                foreach($http['items'] AS $data);

                $checkUnique = Str::contains($data['snippet']['description'], $uniqueID);

                if($checkUnique == true){
                    $linkID = BaseHelper::decrypt($id);

                    $userLink = UserLink::find($linkID);

                    $userLink->update([
                        'base_decision_id' => 2,
                    ]);

                    $userLink->hasOneUserLinkTracker()->create([
                        'users_id'      => auth()->user()->id,
                        'users_link_id' => $linkID,
                        'base_link_id'  => $userLink->base_link_id,
                        'identifier'    => $data['id'],
                        'name'          => $data['snippet']['title'],
                        'avatar'        => $data['snippet']['thumbnails']['medium']['url'],
                        'view'          => $data['statistics']['viewCount'] ? $data['statistics']['viewCount'] : 0,
                        'subscriber'    => $data['statistics']['hiddenSubscriberCount'] == false ? $data['statistics']['subscriberCount'] : 0,
                        'joined'        => Carbon::parse($data['snippet']['publishedAt'])->toIso8601String(),
                    ]);

                    return RedirectHelper::routeBack('apps.manager.link', 'success', 'Channel Verification', 'verify');
                }
                else{
                    return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. We were able to find your channel but we did not find your unique code.', 'error');
                }
            }
            else{
                return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. It seems we can not find your channel.', 'error');
            }
        }
        else{
            return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Please check whether the link structure you submitted complies with the guidelines.', 'error');
        }
    }

    public static function fetchArchive($channelID, $userID){
        // Cara pakai: return YoutubeRepositories::fetchArchive("channel", auth()->user()->id);
        try{
            $http = Http::get('https://www.toptal.com/developers/feed2json/convert', [
                'url' => "https://www.youtube.com/feeds/videos.xml?channel_id=" . $channelID,
            ]);

            $httpJSON = $http->json();

            if(isset($httpJSON['items'])){
                foreach($httpJSON['items'] AS $data){
                    UserFeed::insertOrIgnore([
                        'users_id'      => $userID,
                        'base_link_id'  => 2,
                        'identifier'    => Str::afterLast($data['guid'], ':'),
                        'title'         => $data['title'],
                        'published'     => Carbon::parse($data['date_published'])->toIso8601String(),
                    ]);
                }
            }
        }
        catch(\Throwable $th){
            $apiKey = BaseAPI::where('base_link_id', '=', '2')->inRandomOrder()->first()->client_key;

            $params = [
                'key'           => $apiKey,
                'part'          => "snippet,contentDetails",
                'channelId'     => $channelID,
                'maxResults'    => 256,
            ];

            $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/activities', $params);

            $httpJSON = $http->json();

            if(isset($httpJSON['items'])){
                foreach($httpJSON['items'] AS $data){
                    if(isset($data['contentDetails']['upload']['videoId'])){
                        UserFeed::insertOrIgnore([
                            'users_id'      => $userID,
                            'base_link_id'  => '2',
                            'identifier'    => $data['contentDetails']['upload']['videoId'],
                            'title'         => $data['snippet']['title'],
                            'published'     => Carbon::parse($data['snippet']['publishedAt'])->toIso8601String(),
                        ]);
                    }
                }
            }
        }
    }
}
