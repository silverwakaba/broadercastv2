<?php

namespace App\View\Components\Adminlte;

use Closure;

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
        $datas = User::with([
            'hasOneUserAvatar', 'hasOneUserBiodata'
        ])->where([
            ['id', '=', auth()->user()->id],
        ])->first();

        $user = (new UserResource($datas))->resolve();

        return view('components.adminlte.navigation', [
            'user'      => $user,
            'avatar'    => ($user['avatar'])->resolve(),
            'biodata'   => ($user['biodata'])->resolve(),
        ]);
    }
}
