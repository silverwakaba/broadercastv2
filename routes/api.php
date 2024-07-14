<?php

use Illuminate\Support\Facades\Route;

// Youtube
use App\Http\Controllers\API\YoutubeAPI;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// 

Route::group(['prefix' => 'youtube'], function(){
    // Via Scraper
    Route::get('scrape-channel', [YoutubeAPI::class, 'scrapeChannel'])->name('api.yt.channel.scraper');
    Route::get('scrape-video', [YoutubeAPI::class, 'scrapeVideo'])->name('api.yt.video.scraper');

    // Via API
    Route::get('fetch-channel', [YoutubeAPI::class, 'fetchChannels'])->name('api.yt.channel.fetch');
    Route::get('fetch-feed', [YoutubeAPI::class, 'fetchFeeds'])->name('api.yt.feed.fetch');
    Route::get('fetch-playlist', [YoutubeAPI::class, 'fetchPlaylistItems'])->name('api.yt.playlist.fetch');
    Route::get('fetch-video', [YoutubeAPI::class, 'fetchVideos'])->name('api.yt.video.fetch');
});