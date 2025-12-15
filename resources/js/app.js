import "./bootstrap";
import "toastr/build/toastr.css";
import { showSessionMessages } from "./toast";
import "./flash-sale";
import CartUtils from "./utils/cart-utils";

// ===========================
// EVENT DELEGATION FOR PRODUCTS
// ===========================

document.addEventListener("click", async (e) => {
    // Add to Cart Button
    if (e.target.closest(".add-to-cart-btn")) {
        e.preventDefault();
        e.stopPropagation();

        const btn = e.target.closest(".add-to-cart-btn");
        const productId = btn.getAttribute("data-product-id");
        if (!productId) return;

        const originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Đang thêm...';

        const success = await CartUtils.addToCart(productId, 1);

        if (success) {
            btn.innerHTML = '<i class="bi bi-check me-1"></i>Đã thêm';
        }

        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
        }, 2000);
    }

    // Wishlist Button
    if (e.target.closest(".wishlist-btn")) {
        e.preventDefault();
        e.stopPropagation();

        const btn = e.target.closest(".wishlist-btn");
        const productId = btn.getAttribute("data-product-id");
        if (!productId) return;

        btn.classList.add("animate-scale-in");

        const added = await CartUtils.toggleWishlist(productId);
        const icon = btn.querySelector("i");

        if (added) {
            icon.classList.remove("bi-heart");
            icon.classList.add("bi-heart-fill");
            btn.classList.add("active");
            CartUtils.showToast("success", "Thêm vào yêu thích", "Thành công!");
        } else {
            icon.classList.remove("bi-heart-fill");
            icon.classList.add("bi-heart");
            btn.classList.remove("active");
            CartUtils.showToast("info", "Xóa khỏi yêu thích", "Thông báo");
        }
    }
});
// ===========================
// NAVIGATION SCROLL EFFECT
// ===========================

let lastScrollTop = 0;
const navbar = document.querySelector(".navbar");

window.addEventListener("scroll", () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > 50) {
        navbar?.classList.add("scrolled");
    } else {
        navbar?.classList.remove("scrolled");
    }

    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
});

// ===========================
// PROMOTION CODE COPY (EVENT DELEGATION)
// ===========================

document.addEventListener("click", (e) => {
    const promotionBadge = e.target.closest(".promotion-badge");
    if (!promotionBadge) return;

    e.preventDefault();
    e.stopPropagation();

    const codeElement = promotionBadge.querySelector("strong");
    if (!codeElement) return;

    const code = codeElement.textContent.trim();

    navigator.clipboard
        .writeText(code)
        .then(() => {
            const icon = promotionBadge.querySelector(".bi-clipboard");
            if (icon) {
                icon.style.animation = "none";
                setTimeout(() => {
                    icon.style.animation = "badgeIconPulse 0.6s ease";
                }, 10);
            }

            CartUtils.showToast("success", `Đã copy mã: <strong>${code}</strong>`, "Thành công!");
        })
        .catch((err) => {
            console.error("Failed to copy:", err);
            CartUtils.showToast("error", "Không thể copy mã", "Lỗi!");
        });
});

// ===========================
// END OF APP
// ===========================
