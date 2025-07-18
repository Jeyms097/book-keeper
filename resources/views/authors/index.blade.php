@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h5 fw-bold text-uppercase">Authors' List</h2>
        <a href="{{ route('authors.create') }}" class="btn btn-primary">Add New</a>
    </div>

    <table id="authors-table" class="table table-hover table-striped table-bordered align-middle text-nowrap"
        style="width: 100%;">
        <thead class="table-light">
            <tr>
                <th class="fw-bold text-center">Name</th>
                <th class="fw-bold text-center">Birth Date</th>
                <th class="fw-bold text-center">Created</th>
                <th class="fw-bold text-center">Updated</th>
                <th class="fw-bold text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $author)
                <tr data-id="{{ $author->id }}">
                    <td>{{ $author->name }}</td>
                    <td>{{ $author->birth_date->format('F j, Y') }}</td>
                    <td>{{ $author->created_at?->format('F j, Y g:i A') }}</td>
                    <td>{{ $author->updated_at?->format('F j, Y g:i A') }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-info edit-author-btn" data-mdb-toggle="modal"
                            data-mdb-target="#editAuthorModal" data-id="{{ $author->id }}" data-name="{{ $author->name }}"
                            data-birth="{{ $author->birth_date->format('Y-m-d') }}">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('authors.destroy', $author->id) }}"
                            class="d-inline delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger ms-1">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <!-- Edit Author Modal -->
    <div class="modal fade" id="editAuthorModal" tabindex="-1" aria-labelledby="editAuthorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="edit-author-form" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editAuthorModalLabel">Edit Author</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal"
                        onclick="document.activeElement.blur()" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="edit-author-name" class="form-label">Name</label>
                        <input type="text" name="name" id="edit-author-name" class="form-control" required />
                    </div>

                    <div class="mb-3">
                        <label for="edit-author-birth" class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" id="edit-author-birth" class="form-control"
                            max="{{ date('Y-m-d') }}" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="document.activeElement.blur()"
                        data-mdb-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
