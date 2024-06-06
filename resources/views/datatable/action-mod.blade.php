<div class="btn-group btn-block" role="group">
    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action</button>
    <div class="dropdown-menu">
        @if(Route::has($route . '.edit'))
            <a href="{{ route($route . '.edit', ['id' => $id]) }}" @class(["dropdown-item"])><i class="fas fa-edit"></i> Edit</a>
        @endif
        @if(Route::has($route . '.decision'))
            <a href="{{ route($route . '.decision', ['id' => $id, 'action' => 'accept']) }}" @class(["dropdown-item", "disabled" => $decision == '2'])><i class="fas fa-check-circle"></i> Accept</a>
            <a href="{{ route($route . '.decision', ['id' => $id, 'action' => 'decline']) }}" @class(["dropdown-item", "disabled" => $decision == '3'])><i class="fas fa-times-circle"></i> Decline</a>
        @endif
        @if(Route::has($route . '.delete'))
            <a href="{{ route($route . '.delete', ['id' => $id]) }}" @class(["dropdown-item"])><i class="fas fa-trash"></i> Delete</a>
        @endif
    </div>
</div>