<?php

namespace App\Repositories\Front\Creator;

use App\Helpers\BaseHelper;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserChannelActivityResource;
use App\Http\Resources\UserLinkTrackerResource;

use App\Models\User;
use App\Models\UserFeed;
use App\Models\UserLinkTracker;

class UserProfileRepositories{
    public static function getProfile(array $data){
        $user = User::with(isset($data['with']) ? $data['with'] : [])->where([
            ['identifier', '=', $data['identifier']],
        ])->firstOrFail();

        $users = BaseHelper::resourceToJson(new UserResource($user));

        $tracker = UserLinkTracker::with([
            'belongsToBaseLink',
            'belongsToUserLink',
            'belongsToActiveStream',
        ])->where([
            ['users_id', '=', $user->id],
        ])->get();

        $trackers = BaseHelper::resourceToJson(UserLinkTrackerResource::collection($tracker));

        $feed = UserFeed::where([
            ['users_id', '=', $user->id],
        ])->get();

        return $feed = BaseHelper::resourceToJson(UserChannelActivityResource::collection($feed));
    }
}
