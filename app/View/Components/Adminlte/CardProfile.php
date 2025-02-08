<?php

namespace App\View\Components\Adminlte;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Helpers\BaseHelper;

class CardProfile extends Component{
    public $profile;
    public $links;
    public $channels;

    /**
     * Create a new component instance.
     */
    public function __construct($profile, $links = '', $channels = ''){
        $this->profile = $profile;
        $this->links = $links;
        $this->channels = $channels;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.adminlte.card-profile', [
            'claim' => route('creator.claim', ['id' => $this->profile->identifier]),
            'edit'  => route('apps.master.user.manage.index', ['uid' => BaseHelper::encrypt($this->profile->id)]),
        ]);
    }
}
