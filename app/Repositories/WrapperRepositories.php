<?php

namespace App\Repositories;

use Closure;
use App\Helpers\RedirectHelper;

class WrapperRepositories{
    public static function tryCatch(Closure $closure){
        try{
            return $closure();
        }
        catch(\Throwable $th){
            return abort(500);
        }
    }
}
