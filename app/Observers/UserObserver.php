<?php

namespace App\Observers;

use App\Helpers\BaseHelper;
use App\Mail\UserVerifyEmail;

use App\Models\User;
use App\Events\UserCreated;

use Illuminate\Support\Facades\Mail;

class UserObserver{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user) : void{
        // Avatar
        $user->hasOneUserAvatar()->create([
            'users_id' => $user->id,
        ]);

        // Biodata
        $user->hasOneUserBiodata()->create([
            'users_id' => $user->id,
        ]);

        // Some action, like when adding a SGU account, don't need to trigger this action. So it's not mandatory action and could be bypassed by utilizing try-catch block.
        try{
            // Request
            $request = $user->hasOneUserRequest()->where([
                ['base_request_id', '=', 1],
                ['users_id', '=', $user->id],
                ['token', '!=', null],
            ])->first();

            if($request){
                $mId = $request->id;
            }
            else{
                $cmId = $user->hasOneUserRequest()->create([
                    'base_request_id'   => 1,
                    'users_id'          => $user->id,
                    'token'             => BaseHelper::adler32(),
                ]);

                $mId = $cmId->id;
            }

            if($mId){
                try{
                    Mail::to($user->email)->send(new UserVerifyEmail($mId));
                }
                catch(\Throwable $th){
                    // throw $th;
                }
            }
        }
        catch(\Throwable $th){
            // throw $th;
        }

        // UserCreated::dispatch($user);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user) : void{
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user) : void{
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user) : void{
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user) : void{
        //
    }
}
