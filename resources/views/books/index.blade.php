@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h5 fw-bold text-uppercase">Books' List</h2>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
    </div>

    <table id="books-table" class="table table-hover table-striped table-bordered align-middle text-nowrap"
        style="width: 100%;">
        <thead class="table-light">
            <tr>
                <th class="fw-bold text-center">Title</th>
                <th class="fw-bold text-center">Author</th>
                <th class="fw-bold text-center">Published Date</th>
                <th class="fw-bold text-center">Created</th>
                <th class="fw-bold text-center">Updated</th>
                <th class="fw-bold text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr data-id="{{ $book->id }}">
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->name }}</td>
                    <td>{{ $book->published_date->format('F j, Y') }}</td>
                    <td>{{ $book->created_at?->format('F j, Y g:i A') }}</td>
                    <td>{{ $book->updated_at?->format('F j, Y g:i A') }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-info edit-book-btn" data-mdb-toggle="modal"
                            data-mdb-target="#editBookModal" data-id="{{ $book->id }}" data-title="{{ $book->title }}"
                            data-author_id="{{ $book->author_id }}"
                            data-published_date="{{ $book->published_date->format('Y-m-d') }}">
                            Edit
                        </button>

                        <form method="POST" action="{{ route('books.destroy', $book) }}" class="d-inline delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger ms-1">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Edit Book Modal -->
    <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="edit-book-form" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookModalLabel">Edit Book</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal"
                        onclick="document.activeElement.blur()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-book-title" class="form-label">Title</label>
                        <input type="text" name="title" id="edit-book-title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-book-author" class="form-label">Author</label>
                        <select name="author_id" id="edit-book-author" class="form-select select2" required>
                            <option value="">-- Select Author --</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-book-date" class="form-label">Published Date</label>
                        <input type="date" name="published_date" id="edit-book-date" class="form-control"
                            max="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="document.activeElement.blur()"
                        data-mdb-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
