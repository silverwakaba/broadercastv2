<div class="btn-group btn-block" role="group">
    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action</button>
    <div class="dropdown-menu">
        @if($protected)
            @if($decision == '1')
                <a href="{{ route($route . '.edit', ['id' => $id]) }}" @class(["dropdown-item"])><i class="fas fa-edit"></i> Edit</a>
                <a href="{{ route($route . '.delete', ['id' => $id]) }}" @class(["dropdown-item"])><i class="fas fa-trash"></i> Delete</a>
                <a href="{{ route($route . '.verify', ['id' => $id]) }}" @class(["dropdown-item"])><i class="fas fa-user-check"></i> Verify Link</a>
            @elseif($decision == '2')
                <a href="{{ route($route . '.delete.confirm', ['id' => $id]) }}" @class(["dropdown-item"])><i class="fas fa-trash"></i> Confirm Delete</a>
            @endif
        @else
            <a href="{{ route($route . '.edit', ['id' => $id]) }}" @class(["dropdown-item"])><i class="fas fa-edit"></i> Edit</a>
            <a href="{{ route($route . '.delete', ['id' => $id]) }}" @class(["dropdown-item"])><i class="fas fa-trash"></i> Delete</a>
        @endif
    </div>
</div>