$(document).ready(function () {
    $(".select2").each(function () {
        const modalParent = $(this).closest(".modal");
        $(this).select2({
            width: "100%",
            dropdownParent: modalParent.length ? modalParent : $("body"),
        });
    });

    $("#createBookModal, #editBookModal").on("shown.bs.modal", function () {
        $(this)
            .find(".select2")
            .select2({
                width: "100%",
                dropdownParent: $(this),
            });
    });
});
