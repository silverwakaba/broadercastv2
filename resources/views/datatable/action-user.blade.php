<div class="btn-group btn-block" role="group">
    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action</button>
    <div class="dropdown-menu">
        @if(Route::has($route . '.view'))
            <a href="{{ route($route . '.view', ['id' => $id]) }}" @class(["dropdown-item"])><i class="fas fa-edit"></i> View</a>
        @endif
        @if(Route::has($route . '.edit'))
            <a href="{{ route($route . '.edit', ['id' => $id]) }}" @class(["dropdown-item"])><i class="fas fa-edit"></i> Edit</a>
        @endif
        @if(Route::has($route . '.delete'))
            <div class="dropdown-divider"></div>
            <a href="{{ route($route . '.delete', ['id' => $id]) }}" @class(["dropdown-item"])><i class="fas fa-trash"></i> Delete</a>
        @endif
    </div>
</div>