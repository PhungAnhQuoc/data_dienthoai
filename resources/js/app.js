import "./bootstrap";
import "toastr/build/toastr.css";
import { showSessionMessages } from "./toast";

// Handle promotion badge click to copy code
document.addEventListener("DOMContentLoaded", function () {
    const promotionBadges = document.querySelectorAll(".promotion-badge");

    promotionBadges.forEach((badge) => {
        badge.style.cursor = "pointer";
        badge.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            const codeElement = this.querySelector("strong");
            if (codeElement) {
                const code = codeElement.textContent.trim();

                // Copy to clipboard
                navigator.clipboard
                    .writeText(code)
                    .then(() => {
                        // Add click animation
                        const icon = this.querySelector(".bi-clipboard");
                        if (icon) {
                            icon.style.animation = "none";
                            setTimeout(() => {
                                icon.style.animation =
                                    "badgeIconPulse 0.6s ease";
                            }, 10);
                        }

                        // Show toast notification
                        if (typeof toastr !== "undefined") {
                            toastr.success(
                                `Đã copy mã: <strong>${code}</strong>`,
                                "Thành công!",
                                {
                                    timeOut: 2000,
                                    positionClass: "toast-top-right",
                                }
                            );
                        }
                    })
                    .catch((err) => {
                        console.error("Failed to copy:", err);
                        if (typeof toastr !== "undefined") {
                            toastr.error("Không thể copy mã", "Lỗi!");
                        }
                    });
            }
        });
    });
});
