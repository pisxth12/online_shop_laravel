@if (Session::has('success'))
    <div class="bg-success alert d-flex justify-content-between align-items-center" role="alert">
        <div>
            <strong class="text-success">Success:</strong>
            <small>{{ Session::get('success') }}</small>
        </div>
        <button type="button" class="btn-close btn" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif (Session::has('error'))
    <div class="bg-danger alert d-flex justify-content-between align-items-center" role="alert">
        <div>
            <strong class="text-danger">Error:</strong>
            <small>{{ Session::get('error') }}</small>
        </div>
        <button type="button" class="btn-close btn" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
