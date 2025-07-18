@extends('main')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 fw-bold">Add New Author</h2>
        </div>

        <form id="create-author-form" action="{{ route('authors.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" id="author-name" class="form-control" />
            </div>

            <div class="mb-3">
                <label class="form-label">Birth Date</label>
                <input type="date" name="birth_date" id="author-birth" class="form-control" max="{{ date('Y-m-d') }}" />
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('authors.index') }}" class="btn btn-secondary me-2">Back</a>
                <button type="submit" class="btn btn-success">Create Author</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/authors.js') }}"></script>
    <script src="{{ asset('js/validation.js') }}"></script>
@endsection
