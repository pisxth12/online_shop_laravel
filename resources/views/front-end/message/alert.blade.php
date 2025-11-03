
@if (Session::has('success'))
    <div class="bg-primary alert" role="alert">
        <strong class="text-success">Success</strong> 
        <small>{{ Session::get('success') }} </small>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif (Session::has('error'))
    <div class="bg-danger alert" role="alert">
        <strong class="text-danger">Error</strong> 
        <small>{{ Session::get('error') }} </small>
    </div>
@endif