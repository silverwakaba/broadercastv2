<?php

namespace App\Observers;

use App\Models\BaseRace;
use App\Events\BaseRaceCreated;
use App\Events\BaseRaceModified;

class BaseRaceObserver{
    /**
     * Handle the BaseRace "created" event.
     */
    public function created(BaseRace $baseRace) : void{
        BaseRaceCreated::dispatch($baseRace);
    }

    /**
     * Handle the BaseRace "updated" event.
     */
    public function updated(BaseRace $baseRace) : void{
        BaseRaceModified::dispatch($baseRace);
    }

    /**
     * Handle the BaseRace "deleted" event.
     */
    public function deleted(BaseRace $baseRace) : void{
        BaseRaceModified::dispatch($baseRace);
    }

    /**
     * Handle the BaseRace "restored" event.
     */
    public function restored(BaseRace $baseRace) : void{
        BaseRaceModified::dispatch($baseRace);
    }

    /**
     * Handle the BaseRace "force deleted" event.
     */
    public function forceDeleted(BaseRace $baseRace) : void{
        BaseRaceModified::dispatch($baseRace);
    }
}
