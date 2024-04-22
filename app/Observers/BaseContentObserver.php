<?php

namespace App\Observers;

use App\Models\BaseContent;
use App\Events\BaseContentCreated;
use App\Events\BaseContentModified;

class BaseContentObserver{
    /**
     * Handle the BaseContent "created" event.
     */
    public function created(BaseContent $baseContent) : void{
        BaseContentCreated::dispatch($baseContent);
    }

    /**
     * Handle the BaseContent "updated" event.
     */
    public function updated(BaseContent $baseContent) : void{
        BaseContentModified::dispatch($baseContent);
    }

    /**
     * Handle the BaseContent "deleted" event.
     */
    public function deleted(BaseContent $baseContent) : void{
        BaseContentModified::dispatch($baseContent);
    }

    /**
     * Handle the BaseContent "restored" event.
     */
    public function restored(BaseContent $baseContent) : void{
        BaseContentModified::dispatch($baseContent);
    }

    /**
     * Handle the BaseContent "force deleted" event.
     */
    public function forceDeleted(BaseContent $baseContent) : void{
        BaseContentModified::dispatch($baseContent);
    }
}
