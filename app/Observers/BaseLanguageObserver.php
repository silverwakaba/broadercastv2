<?php

namespace App\Observers;

use App\Models\BaseLanguage;
use App\Events\BaseLanguageCreated;
use App\Events\BaseLanguageModified;

class BaseLanguageObserver{
    /**
     * Handle the BaseLanguage "created" event.
     */
    public function created(BaseLanguage $baseLanguage) : void{
        BaseLanguageCreated::dispatch($baseLanguage);
    }

    /**
     * Handle the BaseLanguage "updated" event.
     */
    public function updated(BaseLanguage $baseLanguage) : void{
        BaseLanguageModified::dispatch($baseLanguage);
    }

    /**
     * Handle the BaseLanguage "deleted" event.
     */
    public function deleted(BaseLanguage $baseLanguage) : void{
        BaseLanguageModified::dispatch($baseLanguage);
    }

    /**
     * Handle the BaseLanguage "restored" event.
     */
    public function restored(BaseLanguage $baseLanguage) : void{
        BaseLanguageModified::dispatch($baseLanguage);
    }

    /**
     * Handle the BaseLanguage "force deleted" event.
     */
    public function forceDeleted(BaseLanguage $baseLanguage) : void{
        BaseLanguageModified::dispatch($baseLanguage);
    }
}
