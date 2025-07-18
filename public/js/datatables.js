$(document).ready(function () {
    if ($("#authors-table").length) {
        window.authorsTable = $("#authors-table").DataTable({
            responsive: true,
        });
    }

    if ($("#books-table").length) {
        window.booksTable = $("#books-table").DataTable({
            responsive: true,
        });
    }
});
