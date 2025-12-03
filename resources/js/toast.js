// Toast Notification Helper
export function showToast(message, type = "info", title = null) {
    if (window.Toast) {
        if (type === "success") {
            window.Toast.success(message, title || "Thành công");
        } else if (type === "error") {
            window.Toast.error(message, title || "Lỗi");
        } else if (type === "warning") {
            window.Toast.warning(message, title || "Cảnh báo");
        } else if (type === "info") {
            window.Toast.info(message, title || "Thông tin");
        }
    }
}

export function showSuccess(message, title = "Thành công") {
    showToast(message, "success", title);
}

export function showError(message, title = "Lỗi") {
    showToast(message, "error", title);
}

export function showWarning(message, title = "Cảnh báo") {
    showToast(message, "warning", title);
}

export function showInfo(message, title = "Thông tin") {
    showToast(message, "info", title);
}

// Handle form submissions with toast notifications
export function setupFormToasts() {
    const forms = document.querySelectorAll("form");
    forms.forEach((form) => {
        const originalSubmit = form.onsubmit;
        form.onsubmit = function (e) {
            if (originalSubmit && typeof originalSubmit === "function") {
                return originalSubmit.call(this, e);
            }
        };
    });
}

// Auto-show Laravel session messages as toasts
export function showSessionMessages() {
    const successElements = document.querySelectorAll("[data-toast-success]");
    const errorElements = document.querySelectorAll("[data-toast-error]");
    const warningElements = document.querySelectorAll("[data-toast-warning]");
    const infoElements = document.querySelectorAll("[data-toast-info]");

    successElements.forEach((el) => {
        showSuccess(el.getAttribute("data-toast-success"));
    });

    errorElements.forEach((el) => {
        showError(el.getAttribute("data-toast-error"));
    });

    warningElements.forEach((el) => {
        showWarning(el.getAttribute("data-toast-warning"));
    });

    infoElements.forEach((el) => {
        showInfo(el.getAttribute("data-toast-info"));
    });
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", () => {
    showSessionMessages();
});
