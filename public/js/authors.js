$(document).ready(function () {
    // Create Author
    $("#create-author-form").submit(function (e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop("disabled", true);

        const isValid = validateForm([
            { name: "name", label: "Name" },
            { name: "birth_date", label: "Birth Date" },
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

    // Edit Author - Modal Setup
    $(document).on("click", ".edit-author-btn", function () {
        const btn = $(this);
        const modal = $("#editAuthorModal");

        modal.find("#edit-author-name").val(btn.data("name"));
        modal.find("#edit-author-birth").val(btn.data("birth"));
        modal
            .find("#edit-author-form")
            .attr("action", `/authors/${btn.data("id")}`);
        modal.find("#edit-author-form").data("id", btn.data("id"));
    });

    // Edit Author - AJAX
    $("#edit-author-form").submit(function (e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const authorId = form.data("id");
        submitBtn.prop("disabled", true);

        $.ajax({
            url: form.attr("action"),
            method: "POST",
            data: form.serialize(),
            success: function (res) {
                document.activeElement.blur();
                $("#editAuthorModal").modal("hide");
                showToast("Author updated successfully", "success");

                const row = $(`#authors-table tbody tr[data-id="${authorId}"]`);
                const birthFormatted = new Date(
                    res.data.birth_date
                ).toLocaleDateString(undefined, {
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                });
                const createdAt = new Date(
                    res.data.created_at
                ).toLocaleString();
                const updatedAt = new Date(
                    res.data.updated_at
                ).toLocaleString();

                authorsTable
                    .row(row)
                    .data([
                        res.data.name,
                        birthFormatted,
                        createdAt,
                        updatedAt,
                        getAuthorActionButtons(res.data),
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
                    showToast("Failed to update author.", "error");
                }

                submitBtn.prop("disabled", false);
            },
        });
    });

    function getAuthorActionButtons(data) {
        return `<button type="button" class="btn btn-sm btn-info edit-author-btn"
            data-mdb-toggle="modal"
            data-mdb-target="#editAuthorModal"
            data-id="${data.id}"
            data-name="${data.name}"
            data-birth="${data.birth_date}">Edit</button>
        <form method="POST" action="/authors/${
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
