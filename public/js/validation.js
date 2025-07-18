function validateForm(fields) {
    let isValid = true;

    fields.forEach(field => {
        const el = document.querySelector(`[name="${field.name}"]`);
        const value = el?.value?.trim();

        if (!value || (field.type === 'select' && value === '')) {
            showToast(`${field.label} is required`, "error");
            isValid = false;
        }
    });

    return isValid;
}
