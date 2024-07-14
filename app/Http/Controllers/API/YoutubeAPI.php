<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Repositories\Service\YoutubeAPIRepositories;

use Illuminate\Http\Request;

class YoutubeAPI extends Controller{
    /*
    |--------------------------------------------------------------------------
    | Scraper Block
    |--------------------------------------------------------------------------
    */

    // Scrape Channel Data
    public function scrapeChannel(Request $request){
        return YoutubeAPIRepositories::scrapeChannel($request->id);
    }

    // Scrape Video Data
    public function scrapeVideo(Request $request){
        return YoutubeAPIRepositories::scrapeVideo($request->id);
    }

    /*
    |--------------------------------------------------------------------------
    | API Block
    |--------------------------------------------------------------------------
    */

    // Fetch Channel Data
    public function fetchChannels(Request $request){
        return YoutubeAPIRepositories::fetchChannels($request->id);
    }

    // Fetch Feed Data
    public function fetchFeeds(Request $request){
        return YoutubeAPIRepositories::fetchFeeds($request->id);
    }

    // Fetch Playlist Data
    public function fetchPlaylistItems(Request $request){
        return YoutubeAPIRepositories::fetchPlaylistItems($request->id, $request->token);
    }

    // Fetch Video Data
    public function fetchVideos(Request $request){
        return YoutubeAPIRepositories::fetchVideos($request->id);
    }
}
