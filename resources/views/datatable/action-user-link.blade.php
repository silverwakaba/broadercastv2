<div class="btn-group btn-block" role="group">
    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action</button>
    <div class="dropdown-menu">
        @if($protected)
            @if($decision == '1')
                <a href="{{ route($route . '.edit', ['did' => $did, 'uid' => $uid]) }}" @class(["dropdown-item"])><i class="fas fa-edit"></i> Edit</a>
                <a href="{{ route($route . '.delete', ['did' => $did, 'uid' => $uid]) }}" @class(["dropdown-item"])><i class="fas fa-trash"></i> Delete</a>
                <a href="{{ route($route . '.verify', ['did' => $did, 'uid' => $uid]) }}" @class(["dropdown-item"])><i class="fas fa-user-check"></i> Verify Link</a>
            @elseif($decision == '2')
                <a href="{{ route($route . '.delete.confirm', ['did' => $did, 'uid' => $uid]) }}" @class(["dropdown-item"])><i class="fas fa-trash"></i> Confirm Delete</a>
            @endif
        @else
            <a href="{{ route($route . '.edit', ['did' => $did, 'uid' => $uid]) }}" @class(["dropdown-item"])><i class="fas fa-edit"></i> Edit</a>
            <a href="{{ route($route . '.delete', ['did' => $did, 'uid' => $uid]) }}" @class(["dropdown-item"])><i class="fas fa-trash"></i> Delete</a>
        @endif
    </div>
</div>