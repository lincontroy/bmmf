@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session()->has('exception'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('exception') }}
        <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </span>
        <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
