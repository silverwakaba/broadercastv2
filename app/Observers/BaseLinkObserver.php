<?php

namespace App\Observers;

use App\Models\BaseLink;
use App\Events\BaseLinkCreated;
use App\Events\BaseLinkModified;

class BaseLinkObserver{
    /**
     * Handle the BaseLink "created" event.
     */
    public function created(BaseLink $baseLink) : void{
        BaseLinkCreated::dispatch($baseLink);
    }

    /**
     * Handle the BaseLink "updated" event.
     */
    public function updated(BaseLink $baseLink) : void{
        BaseLinkModified::dispatch($baseLink);
    }

    /**
     * Handle the BaseLink "deleted" event.
     */
    public function deleted(BaseLink $baseLink) : void{
        BaseLinkModified::dispatch($baseLink);
    }

    /**
     * Handle the BaseLink "restored" event.
     */
    public function restored(BaseLink $baseLink) : void{
        BaseLinkModified::dispatch($baseLink);
    }

    /**
     * Handle the BaseLink "force deleted" event.
     */
    public function forceDeleted(BaseLink $baseLink) : void{
        BaseLinkModified::dispatch($baseLink);
    }
}
