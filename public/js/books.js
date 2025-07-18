$(document).ready(function () {
    // Create Book
    $("#create-book-form").submit(function (e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop("disabled", true);

        const isValid = validateForm([
            { name: "title", label: "Title" },
            { name: "author_id", label: "Author" },
            { name: "published_date", label: "Published Date" },
        ]);

        if (!isValid) {
            submitBtn.prop("disabled", false);
            return;
        }

        $.ajax({
            url: form.attr("action"),
            method: "POST",
            data: form.serialize(),
            success: function (res) {
                showToast(res.message, "success");
                form[0].reset();
                $(".select2").val(null).trigger("change");
                submitBtn.prop("disabled", false);
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(([msg]) =>
                        showToast(msg, "error")
                    );
                } else {
                    showToast("Something went wrong.", "error");
                }
                submitBtn.prop("disabled", false);
            },
        });
    });

    // Book Edit - Modal Setup
    $(document).on("click", ".edit-book-btn", function () {
        const btn = $(this);
        const modal = $("#editBookModal");
        const authorSelect = modal.find("#edit-book-author");

        if (!authorSelect.hasClass("select2-hidden-accessible")) {
            authorSelect.select2({
                dropdownParent: modal,
            });
        }

        modal.find("#edit-book-title").val(btn.data("title"));
        authorSelect.val(btn.data("author_id")).trigger("change");
        modal.find("#edit-book-date").val(btn.data("published_date"));
        modal
            .find("#edit-book-form")
            .attr("action", `/books/${btn.data("id")}`);
        modal.find("#edit-book-form").data("id", btn.data("id"));
    });

    // Book Edit - AJAX
    $("#edit-book-form").submit(function (e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const bookId = form.data("id");

        submitBtn.prop("disabled", true);

        $.ajax({
            url: form.attr("action"),
            method: "POST",
            data: form.serialize(),
            success: function (res) {
                document.activeElement.blur();
                $("#editBookModal").modal("hide");
                showToast("Book updated successfully", "success");

                const row = $(`#books-table tbody tr[data-id="${bookId}"]`);
                const pubFormatted = new Date(
                    res.data.published_date
                ).toLocaleDateString(undefined, {
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                });
                const authorName = $(
                    `select[name="author_id"] option[value="${res.data.author_id}"]`
                ).text();
                const createdAt = new Date(
                    res.data.created_at
                ).toLocaleString();
                const updatedAt = new Date(
                    res.data.updated_at
                ).toLocaleString();

                booksTable
                    .row(row)
                    .data([
                        res.data.title,
                        authorName,
                        pubFormatted,
                        createdAt,
                        updatedAt,
                        getBookActionButtons(res.data),
                    ])
                    .draw(false);

                submitBtn.prop("disabled", false);
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(([msg]) =>
                        showToast(msg, "error")
                    );
                } else {
                    showToast("Failed to update book.", "error");
                }

                submitBtn.prop("disabled", false);
            },
        });
    });

    function getBookActionButtons(data) {
        return `<button type="button" class="btn btn-sm btn-info edit-book-btn"
            data-mdb-toggle="modal"
            data-mdb-target="#editBookModal"
            data-id="${data.id}"
            data-title="${data.title}"
            data-author_id="${data.author_id}"
            data-published_date="${data.published_date}">Edit</button>
        <form method="POST" action="/books/${
            data.id
        }" class="d-inline delete-form">
            <input type="hidden" name="_token" value="${$(
                'meta[name="csrf-token"]'
            ).attr("content")}">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-sm btn-danger ms-1">Delete</button>
        </form>`;
    }
});
