<?php

namespace App\Observers;

use App\Mail\UserVerifyEmail;

use App\Models\User;
use App\Events\UserCreated;

use Illuminate\Support\Facades\Mail;

class UserObserver{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user) : void{
        // $user->hasOneUserAvatar()->create([
        //     'users_id' => $user->id,
        // ]);

        // $user->hasOneUserBiodata()->create([
        //     'users_id' => $user->id,
        // ]);

        // Mail::to($user->email)->send(new UserVerifyEmail($user->id));

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
