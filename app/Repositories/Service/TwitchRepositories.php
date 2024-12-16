<?php

namespace App\Repositories\Service;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Mail\UserClaimEmail;

use App\Models\BaseAPI;
use App\Models\User;
use App\Models\UserFeed;
use App\Models\UserLink;
use App\Models\UserLinkTracker;
use App\Repositories\Service\TwitchAPIRepositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class TwitchRepositories{
    /**
     * ----------------------------
     * Basic Function
     * ----------------------------
    **/

    // Update Twitch Bearer Token
    public static function updateBearerToken(){
        $data = BaseAPI::where([
            ['base_link_id', '=', 1],
            ['client_id', '=', '7rrc3ifer1dcw4178d5iylqt7k0yzs'],
        ])->first();

        $validate = TwitchAPIRepositories::validateToken($data->client_secret, $data->bearer);

        if($validate['status'] !== 200){
            $reauth = TwitchAPIRepositories::createToken($data->client_id, $data->client_secret);

            $data->update([
                'bearer' => $reauth['access_token'],
            ]);
        }
    }

    // User Link Tracker
    public static function userFeedLive($channelID, $userID){
        return UserFeed::where([
            ['base_link_id', '=', 1],
            ['users_link_tracker_id', '=', $channelID],
            ['base_status_id', '=', 8],
            ['users_id', '=', $userID],
        ])->get();
    }

    // User Link Tracker
    public static function userLinkTracker($channelID, $userID){
        return UserLinkTracker::where([
            ['base_link_id', '=', 1],
            ['users_id', '=', $userID],
            ['identifier', '=', $channelID],
        ])->first();
    }

    // User Link Tracker - Checker
    public static function userLinkTrackerChecker($channelID){
        return UserLinkTracker::where([
            ['base_link_id', '=', 1],
            ['identifier', '=', $channelID],
        ])->select('identifier')->get()->count();
    }

    // User Link Tracker - Counter
    public static function userLinkTrackerCounter($userID){
        return UserLinkTracker::where([
            ['base_link_id', '=', 1],
            ['users_id', '=', $userID],
        ])->select('identifier')->get()->count();
    }

    /**
     * ----------------------------
     * Verify
     * ----------------------------
    **/

    // Verify Channel
    public static function verifyChannel($channelID, $uniqueID, $id, $back = null){
        try{
            $checkViaChannel = Str::contains($channelID, "https://www.twitch.tv/");

            if($checkViaChannel){
                if($checkViaChannel == true){
                    $channelIDS = Str::of($channelID)->afterLast('/');
                }
                else{
                    $channelIDS = null;
                }

                $linkID = BaseHelper::decrypt($id);
                $userLink = UserLink::find($linkID);
                $countChannel = self::userLinkTrackerChecker($channelIDS);
                $limitChannel = self::userLinkTrackerCounter($userLink->users_id);

                if(($channelIDS !== null) && (Str::of($channelIDS)->length() <= 25)){
                    if($countChannel == 0){
                        $idLmao = (string) $channelIDS;
                        $http = TwitchAPIRepositories::fetchProfileByHandler($idLmao);

                        if(count($http['data']) >= 1){
                            $singleHttp = collect($http['data'])->first();

                            $createNew = [
                                'users_id'      => $userLink->users_id,
                                'users_link_id' => $linkID,
                                'base_link_id'  => $userLink->base_link_id,
                                'identifier'    => $singleHttp['id'],
                                'handler'       => $singleHttp['login'],
                                'playlist'      => null,
                                'name'          => $singleHttp['display_name'],
                                'description'   => $singleHttp['description'],
                                'avatar'        => self::userAvatarBanner($singleHttp['profile_image_url']),
                                'banner'        => ($singleHttp['offline_image_url'] != null) ? self::userAvatarBanner($singleHttp['offline_image_url']) : null,
                                'joined'        => Carbon::parse($singleHttp['created_at'])->timezone(config('app.timezone'))->toDateTimeString(),
                            ];

                            // Admin and Moderator can Directly Mark Link Tracker as Verified
                            if((auth()->user()->hasRole('Admin|Moderator'))){
                                $userLink->update([
                                    'base_decision_id' => 2,
                                ]);
                                
                                $userLink->hasOneUserLinkTracker()->create($createNew);

                                // Redirect
                                return RedirectHelper::routeBack($back, 'success', 'Channel Verification', 'verify');
                            }

                            // But Normal User Need to Provide Unique ID and Then It Will Be Checked
                            else{
                                $checkUnique = Str::contains($singleHttp['description'], $uniqueID);

                                if((isset($checkUnique) && $checkUnique == true)){
                                    if($limitChannel <= 1){
                                        $userLink->update([
                                            'base_decision_id' => 2,
                                        ]);

                                        $userLink->hasOneUserLinkTracker()->create($createNew);
            
                                        // Redirect
                                        return RedirectHelper::routeBack($back, 'success', 'Channel Verification', 'verify');
                                    }
                                    else{
                                        return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Because currently we only allow one YouTube tracker per creator, thus we have to cancel this verification process.', 'error');
                                    }
                                }
                                else{
                                    return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. We were able to find your channel but we did not find your unique code.', 'error');
                                }
                            }

                        }
                        else{
                            return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. And it seems we can not find your channel.', 'error');
                        }
                    }
                    else{
                        return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Because we found that this channel has been successfully verified by other users, thus we have to cancel this verification process.', 'error');
                    }
                }
                else{
                    return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. So please check again whether the link structure you submitted complies with the guidelines or not.', 'error');
                }
            }
            else{
                return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. As this link does not looks like Twitch.', 'error');
            }
        }
        catch(\Throwable $th){
            return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Because something went wrong, please try again.', 'error');
        }
    }

    // Claim Account via Channel
    public static function claimViaChannel($channelID, $uniqueID, $id, $email, $back = null){
        try{
            $idLmao = (int) $channelID;
            $http = TwitchAPIRepositories::fetchProfileByID($idLmao);

            $httpCollection = collect($http['data'])->first();

            $checkUnique = Str::contains($httpCollection['description'], $uniqueID);

            if((isset($checkUnique) && $checkUnique == true)){
                $user = UserLinkTracker::where('identifier', '=', $channelID)->select('users_id')->first();

                if($user){
                    $request = $user->hasManyThroughUserRequest()->where([
                        ['base_request_id', '=', 3],
                        ['users_id', '=', $user->users_id],
                        ['token', '!=', null],
                    ])->first();

                    if($request){
                        $mId = $request->id;
                    }
                    else{
                        $cmId = $user->hasManyThroughUserRequest()->create([
                            'base_request_id'   => 3,
                            'users_id'          => $user->users_id,
                            'token'             => BaseHelper::adler32(),
                        ]);
        
                        $mId = $cmId->id;
                    }
        
                    Mail::to($email)->send(new UserClaimEmail($mId));
        
                    return RedirectHelper::routeBack($back, 'success', 'Claim', 'claim');
                }
                else{
                    return RedirectHelper::routeBackWithErrors([
                        'email' => "Something went wrong. Please try again.",
                    ]);
                }
            }
        }
        catch(\Throwable $th){
            return RedirectHelper::routeBack(null, 'danger', 'Profile Claim. Because something went wrong, please try again.', 'error');
        }
    }

    /**
     * ----------------------------
     * Manage Data
     * ----------------------------
    **/

    // Update Profile
    public static function updateProfile(){
        try{
            UserLinkTracker::where([
                ['base_link_id', '=', 1],
                ['initialized', '=', true],
                ['archived', '=', false],
            ])->select('id', 'identifier', 'users_id')->chunkById(100, function(Collection $chunks){
                $channelID = implode(',', ($chunks)->pluck('identifier')->toArray());

                if(($chunks) && isset($chunks) && ($chunks->count() >= 1)){
                    $http = TwitchAPIRepositories::fetchProfileByID($channelID);
                    $collectionHTTP = collect($http['data']);
                    $resultHTTP = $collectionHTTP->all();

                    if(($resultHTTP) && isset($resultHTTP) && (count($resultHTTP) >= 1)){
                        foreach($resultHTTP as $channel){
                            $tracker = new UserLinkTracker();
                            
                            $tracker->timestamps = false;
                            $tracker->where([
                                ['identifier', '=', $channel['id']],
                                ['base_link_id', '=', 1]
                            ])->update([
                                'name'          => $channel['display_name'],
                                'description'   => $channel['description'],
                                'handler'       => $channel['login'],
                                'avatar'        => self::userAvatarBanner($channel['profile_image_url']),
                                'banner'        => ($channel['offline_image_url'] != null) ? self::userAvatarBanner($channel['offline_image_url']) : null,
                            ]);
                        }
                    }
                }
            });
        }
        catch(\Throwable $th){
            // throw $th;
        }
    }

    // Update Subscriber
    public static function updateSubscriber($initState){
        try{
            UserLinkTracker::where([
                ['base_link_id', '=', 1],
                ['initialized', '=', $initState],
                ['archived', '=', false],
            ])->select('id', 'initialized', 'identifier', 'users_id')->chunkById(100, function(Collection $chunks){
                foreach($chunks as $chunk){
                    $http = TwitchAPIRepositories::fetchSubscriber($chunk->identifier);

                    $update = [
                        'subscriber' => $http['total'],
                    ];

                    if(($chunk->initialized == false)){
                        $update['initialized'] = true;
                    }

                    $chunk->update($update);
                }
            });
        }
        catch(\Throwable $th){
            // return $th;
        }
    }

    // Check and Update Channel Activity
    public static function checkChannelActivity(){
        try{
            $activeFeed = UserFeed::select('reference')->whereIn('base_status_id', ['6', '8'])->get();
            $activeFeedCollection = collect($activeFeed)->pluck('reference')->all();
            
            UserLinkTracker::where([
                ['base_link_id', '=', 1],
                ['initialized', '=', true],
                ['archived', '=', false],
            ])->whereNotIn('identifier', $activeFeedCollection)->select('id', 'identifier', 'handler', 'users_id')->chunkById(100, function(Collection $chunks){
                foreach($chunks as $channel){
                    $http = Http::withOptions([
                        'proxy' => BaseHelper::baseProxy(),
                    ])->get('https://www.twitch.tv/' . $channel->handler)->body();

                    $live = Str::betweenFirst($http, ',"isLiveBroadcast":', '}}');
                    $title = Str::betweenFirst($http, '"description":"', '",');

                    if((Str::of($live)->contains(['true'])) && (Str::length($title) <= 140)){
                        $tmpID = $channel->identifier;
                        $tracker = self::userLinkTracker($channel->identifier, $channel->users_id);

                        $tracker->hasManyThroughUserFeed()->updateOrCreate(['users_feed.identifier' => $tmpID], [
                            'users_id'              => $channel->users_id,
                            'base_link_id'          => 1,
                            'users_link_tracker_id' => $channel->id,
                            'base_status_id'        => 6,
                            'base_feed_type_id'     => null,
                            'concurrent'            => 0,
                            'identifier'            => BaseHelper::adler32($tmpID),
                            'thumbnail'             => null,
                            'title'                 => $title,
                            'published'             => Carbon::now()->timezone(config('app.timezone'))->toDateTimeString(),
                            'schedule'              => null,
                            'actual_start'          => Carbon::now()->timezone(config('app.timezone'))->toDateTimeString(),
                            'actual_end'            => null,
                            'duration'              => "P0D",
                            'reference'             => $tmpID,
                        ]);
                    }
                }
            });
        }
        catch(\Throwable $th){
            // throw $th;
        }
    }

    // Update Channel Activity
    public static function updateChannelActivity(){
        try{
            UserFeed::with([
                'belongsToUserLinkTracker'
            ])->where([
                ['base_link_id', '=', 1],
                ['actual_end', '=', null],
                ['duration', '=', "P0D"],
            ])->whereIn('base_status_id', ['6', '8'])->select('id', 'identifier', 'users_id', 'base_status_id', 'users_link_tracker_id', 'reference')->chunkById(100, function(Collection $chunks) use(&$combinedData){
                foreach($chunks as $feed){
                    $combinedData[] = [
                        'status'            => $feed->base_status_id,
                        'user_id'           => $feed->users_id,
                        'user_handler'      => $feed->belongsToUserLinkTracker->handler,
                        'user_identifier'   => $feed->belongsToUserLinkTracker->identifier,
                        'videos_id'         => $feed->identifier,
                        'videos_reference'  => $feed->reference,
                    ];
                }

                // Data From Database
                $dbCollection = collect($combinedData)->pluck('videos_reference')->all();
                $channelIDFromDatabase = implode(',', $dbCollection);

                // Do an Action if Data is Present
                if(($dbCollection) && isset($dbCollection) && (count($dbCollection) >= 1)){
                    // API Call
                    $fetchStream = TwitchAPIRepositories::fetchStream($channelIDFromDatabase);
                    $fetchStreamCollection = collect($fetchStream['data'])->all();

                    // List of Twitch Streamers Who Are Currently Streaming Based On Twitch
                    $channelIsStreamingOnTwitch = collect($fetchStreamCollection)->pluck('user_id')->all();
                    $channelIsStreamingOnTwitchCollection = implode(',', ($channelIsStreamingOnTwitch));

                    // Inactive Streamer
                    $inactiveStream = array_diff(
                        $dbCollection, $channelIsStreamingOnTwitch
                    );

                    // Active Streamer
                    $activeStream = array_diff(
                        $dbCollection, $inactiveStream
                    );

                    // Processing Live Streaming
                    $activeStreamCollection = collect($fetchStreamCollection)->whereIn('user_id', $activeStream)->all();

                    if(($activeStreamCollection) && isset($activeStreamCollection) && (count($activeStreamCollection) >= 1)){
                        foreach($activeStreamCollection as $stream){
                            $userFeedStreaming = UserFeed::where([
                                ['reference', '=', $stream['user_id']],
                            ])->first();

                            $userFeedStreaming->update([
                                'base_status_id'    => 8,
                                'identifier'        => $stream['id'],
                                'concurrent'        => $stream['viewer_count'],
                                'title'             => $stream['title'],
                                'published'         => Carbon::parse($stream['started_at'])->timezone(config('app.timezone'))->toDateTimeString(),
                                'actual_start'      => Carbon::parse($stream['started_at'])->timezone(config('app.timezone'))->toDateTimeString(),
                            ]);
                        }
                    }

                    // Processing Offline Live Streaming
                    $inactiveStreamCollection = collect($combinedData)->whereIn('videos_reference', $inactiveStream)->all();

                    if(($inactiveStreamCollection) && isset($inactiveStreamCollection) && (count($inactiveStreamCollection) >= 1)){
                        foreach($inactiveStreamCollection as $archive){
                            $fetchVideo = TwitchAPIRepositories::fetchVideo($archive['user_identifier'], null, $archive['videos_id']);

                            $userFeedArchive = UserFeed::where([
                                ['reference', '=', $archive['videos_reference']],
                            ])->first();

                            if(($fetchVideo) && isset($fetchVideo) && (count($fetchVideo) >= 1)){
                                if(($userFeedArchive->base_status_id == 8)){
                                    $userFeedArchive->update([
                                        'base_status_id'    => 9,
                                        'identifier'        => $fetchVideo['id'],
                                        'concurrent'        => 0,
                                        'thumbnail'         => self::userAvatarBanner(Str::replace('%{width}x%{height}', '1280x720', $fetchVideo['thumbnail_url'])),
                                        'title'             => $fetchVideo['title'],
                                        'description'       => $fetchVideo['description'],
                                        'published'         => Carbon::parse($fetchVideo['created_at'])->timezone(config('app.timezone'))->toDateTimeString(),
                                        'actual_start'      => Carbon::parse($fetchVideo['created_at'])->timezone(config('app.timezone'))->toDateTimeString(),
                                        'duration'          => Str::of('PT')->append(Str::of($fetchVideo['duration'])->upper()),
                                        'reference'         => null,
                                    ]);
                                }
                                else{
                                    $userFeedArchive->delete();
                                }
                            }
                            else{
                                $userFeedArchive->delete();
                            }
                        }
                    }
                }
            });
        }
        catch(\Throwable $th){
            // throw $th;
        }
    }

    /**
     * ------------------------------
     * Get & process part of the data
     * ------------------------------
    **/

    // User Banner
    public static function userAvatarBanner($datas){
        return (isset($datas) && ($datas != null)) ? BaseHelper::getOnlyPath($datas, BaseHelper::analyzeDomain($datas, 'extension')) : null;
    }
}
