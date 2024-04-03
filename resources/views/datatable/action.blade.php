<div class="btn-group btn-block" role="group">
    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action</button>
    <div class="dropdown-menu">
        <a href="{{ url()->current() . '/edit/' . $id }}" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ url()->current() . '/delete/' . $id }}" class="dropdown-item"><i class="fas fa-trash"></i> Delete</a>
    </div>
</div>