$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(document).on("submit", ".delete-form", function (e) {
    e.preventDefault();
    const form = this;

    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: $(form).attr("action"),
                method: "POST",
                data: $(form).serialize(),
                success: function () {
                    showToast("Deleted successfully!");

                    const $row = $(form).closest("tr");
                    let dtRow;

                    if (typeof booksTable !== "undefined") {
                        if ($row.hasClass("child")) {
                            const parentRow = $row.prev();
                            dtRow = booksTable.row(parentRow);
                        } else {
                            dtRow = booksTable.row($row);
                        }

                        if (dtRow) {
                            dtRow.remove().draw(false);
                        }
                    }

                    if (typeof authorsTable !== "undefined") {
                        if ($row.hasClass("child")) {
                            const parentRow = $row.prev();
                            dtRow = authorsTable.row(parentRow);
                        } else {
                            dtRow = authorsTable.row($row);
                        }

                        if (dtRow) {
                            dtRow.remove().draw(false);
                        }
                    }
                },
                error: function () {
                    showToast("Failed to delete.", "error");
                },
            });
        }
    });
});
