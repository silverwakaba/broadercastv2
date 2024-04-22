<?php

namespace App\Observers;

use App\Models\BaseGender;
use App\Events\BaseGenderCreated;
use App\Events\BaseGenderModified;

class BaseGenderObserver{
    /**
     * Handle the BaseGender "created" event.
     */
    public function created(BaseGender $baseGender) : void{
        BaseGenderCreated::dispatch($baseGender);
    }

    /**
     * Handle the BaseGender "updated" event.
     */
    public function updated(BaseGender $baseGender) : void{
        BaseGenderModified::dispatch($baseGender);
    }

    /**
     * Handle the BaseGender "deleted" event.
     */
    public function deleted(BaseGender $baseGender) : void{
        BaseGenderModified::dispatch($baseGender);
    }

    /**
     * Handle the BaseGender "restored" event.
     */
    public function restored(BaseGender $baseGender) : void{
        BaseGenderModified::dispatch($baseGender);
    }

    /**
     * Handle the BaseGender "force deleted" event.
     */
    public function forceDeleted(BaseGender $baseGender) : void{
        BaseGenderModified::dispatch($baseGender);
    }
}
