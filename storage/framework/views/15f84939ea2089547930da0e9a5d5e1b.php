<!-- Toast Container -->
<div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
</div>

<style>
    /* Toast Notifications Styling */
    .toast {
        background: white;
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        min-width: 320px;
        animation: slideInRight 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .toast.hide {
        animation: slideOutRight 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100px);
        }
    }

    .toast-header {
        background: transparent;
        border: none;
        padding: 12px 16px 8px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .toast-header .toast-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .toast-header .toast-icon.success {
        background: #d4edda;
        color: #155724;
    }

    .toast-header .toast-icon.error {
        background: #f8d7da;
        color: #721c24;
    }

    .toast-header .toast-icon.warning {
        background: #fff3cd;
        color: #856404;
    }

    .toast-header .toast-icon.info {
        background: #d1ecf1;
        color: #0c5460;
    }

    .toast-title {
        font-weight: 600;
        color: #333;
        margin: 0;
        flex-grow: 1;
    }

    .btn-close {
        opacity: 0.5;
        transition: opacity 0.3s ease;
    }

    .btn-close:hover {
        opacity: 0.8;
    }

    .toast-body {
        padding: 0 16px 12px 52px;
        color: #666;
        font-size: 14px;
        line-height: 1.5;
    }

    .toast-progress {
        height: 3px;
        background: linear-gradient(90deg, currentColor 0%, currentColor 100%);
        border-radius: 0 0 8px 8px;
        animation: progress 5s linear forwards;
    }

    .toast-progress.success {
        background: linear-gradient(90deg, #28a745 0%, #28a745 100%);
    }

    .toast-progress.error {
        background: linear-gradient(90deg, #dc3545 0%, #dc3545 100%);
    }

    .toast-progress.warning {
        background: linear-gradient(90deg, #ffc107 0%, #ffc107 100%);
    }

    .toast-progress.info {
        background: linear-gradient(90deg, #17a2b8 0%, #17a2b8 100%);
    }

    @keyframes progress {
        from {
            width: 100%;
        }
        to {
            width: 0%;
        }
    }

    @media (max-width: 576px) {
        .toast {
            min-width: calc(100vw - 24px);
            max-width: calc(100vw - 24px);
        }

        #toast-container {
            width: 100%;
            left: 12px;
            right: 12px;
        }
    }
</style>

<script>
    // Toast Notification System
    const ToastNotification = {
        container: document.getElementById('toast-container'),

        show: function(message, type = 'info', title = null) {
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            const icons = {
                success: '✓',
                error: '✕',
                warning: '⚠',
                info: 'ℹ'
            };

            const titles = {
                success: title || 'Thành công',
                error: title || 'Lỗi',
                warning: title || 'Cảnh báo',
                info: title || 'Thông tin'
            };

            toast.innerHTML = `
                <div class="toast-header">
                    <div class="toast-icon ${type}">
                        ${icons[type] || icons.info}
                    </div>
                    <h6 class="toast-title">${titles[type]}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
                <div class="toast-progress ${type}"></div>
            `;

            this.container.appendChild(toast);

            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => toast.remove(), 400);
            }, 5000);

            // Remove on close button click
            toast.querySelector('.btn-close').addEventListener('click', () => {
                toast.classList.add('hide');
                setTimeout(() => toast.remove(), 400);
            });
        },

        success: function(message, title = null) {
            this.show(message, 'success', title);
        },

        error: function(message, title = null) {
            this.show(message, 'error', title);
        },

        warning: function(message, title = null) {
            this.show(message, 'warning', title);
        },

        info: function(message, title = null) {
            this.show(message, 'info', title);
        }
    };

    // Make it globally accessible
    window.Toast = ToastNotification;
</script>
<?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/partials/toast-container.blade.php ENDPATH**/ ?>