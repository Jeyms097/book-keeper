function showToast(message, type = "success") {
    Toastify({
        text: message,
        duration: 3000,
        gravity: "top",
        position: "center",
        style: {
            background: type === "success" ? "#198754" : "#dc3545",
        },
    }).showToast();
}

// Flash message from session
document.addEventListener("DOMContentLoaded", () => {
    const flashMessage = document.querySelector(
        'meta[name="success-message"]'
    )?.content;
    if (flashMessage) {
        showToast(flashMessage, "success");
    }
});
