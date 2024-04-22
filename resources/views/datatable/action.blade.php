<div class="btn-group btn-block" role="group">
    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action</button>
    <div class="dropdown-menu">
        @if($mode == 'crud')
            ???
        @elseif($mode == 'approval')
            <a href="{{ $action . '?action=accept' }}" @class(["dropdown-item", "disabled" => $decision == '2'])><i class="fas fa-check-circle"></i> Accept</a>
            <a href="{{ $action . '?action=decline' }}" @class(["dropdown-item"])><i class="fas fa-times-circle"></i> Decline</a>
        @endif
    </div>
</div>