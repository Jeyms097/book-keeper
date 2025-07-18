@extends('main')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 fw-bold">Add New Book</h2>
        </div>

        <form id="create-book-form" action="{{ route('books.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" id="book-title" class="form-control" />
            </div>

            <div class="mb-3">
                <label class="form-label">Author</label>
                <select name="author_id" id="book-author" class="form-select select2">
                    <option value="">-- Select Author --</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Published Date</label>
                <input type="date" name="published_date" id="book-date" class="form-control" max="{{ date('Y-m-d') }}" />
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('books.index') }}" class="btn btn-secondary me-2">Back</a>
                <button type="submit" class="btn btn-success">Create Book</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/books.js') }}"></script>
    <script src="{{ asset('js/validation.js') }}"></script>
@endsection
