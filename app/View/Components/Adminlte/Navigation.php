<?php

namespace App\View\Components\Adminlte;

use Closure;

use App\Helpers\BaseHelper;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navigation extends Component{
    /**
     * Create a new component instance.
     */
    public function __construct(){
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        $array = [];

        // $uid = auth()->user() ? auth()->user()->id : '0';

        // $datas = User::with([
        //     'hasOneUserAvatar', 'hasOneUserBiodata'
        // ])->where([
        //     ['id', '=', $uid],
        // ])->first();

        // if($datas){
        //     $user = (new UserResource($datas));

        //     $array = [
        //         'user' => BaseHelper::resourceToJson($user),
        //     ];
        // }

        return view('components.adminlte.navigation', $array);
    }
}
