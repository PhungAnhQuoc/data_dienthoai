/**
 * Cart and Wishlist Utilities
 * Centralized functions for cart/wishlist operations
 */

export const CartUtils = {
    /**
     * Get CSRF token from meta tag
     */
    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || "";
    },

    /**
     * Get base URL from meta tag
     */
    getBaseUrl() {
        return document.querySelector('meta[name="base-url"]')?.content || "/";
    },

    /**
     * Format price in Vietnamese Dong
     */
    formatPrice(price) {
        return new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
            maximumFractionDigits: 0,
        }).format(price);
    },

    /**
     * Show toast notification
     */
    showToast(type, message, title = "") {
        if (typeof toastr !== "undefined") {
            toastr[type](message, title, { timeOut: 2000 });
        }
    },

    /**
     * Add product to cart via AJAX
     */
    async addToCart(productId, quantity = 1) {
        const csrfToken = this.getCsrfToken();
        
        try {
            const response = await fetch(`/cart/add/${productId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({ quantity }),
            });

            const data = await response.json();

            if (data.success) {
                this.showToast("success", "Thêm vào giỏ hàng thành công!", "Thành công!");
                this.updateCartCount();
                return true;
            } else {
                this.showToast("error", data.message || "Không thể thêm sản phẩm", "Lỗi!");
                return false;
            }
        } catch (error) {
            console.error("Error adding to cart:", error);
            this.showToast("error", "Lỗi khi thêm sản phẩm", "Lỗi!");
            return false;
        }
    },

    /**
     * Add flash sale to cart via AJAX
     */
    async addFlashSaleToCart(flashSaleId, quantity = 1) {
        const csrfToken = this.getCsrfToken();
        const baseUrl = this.getBaseUrl();
        const url = baseUrl.replace(/\/$/, "") + "/gio-hang/them";

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
                credentials: "same-origin",
                body: JSON.stringify({
                    flash_sale_id: parseInt(flashSaleId),
                    quantity: parseInt(quantity),
                }),
            });

            const data = await response.json();

            if (response.ok && data.success) {
                this.showToast("success", data.message || "Đã thêm vào giỏ hàng!", "Thành công");
                this.updateCartCount();
                return true;
            } else {
                this.showToast("error", data.message || "Lỗi khi thêm vào giỏ hàng", "Lỗi");
                return false;
            }
        } catch (error) {
            console.error("Error adding flash sale to cart:", error);
            this.showToast("error", "Có lỗi xảy ra khi thêm vào giỏ hàng", "Lỗi");
            return false;
        }
    },

    /**
     * Toggle wishlist for product
     */
    async toggleWishlist(productId) {
        const csrfToken = this.getCsrfToken();

        try {
            const response = await fetch(`/wishlist/toggle/${productId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
            });

            const data = await response.json();

            if (data.success) {
                this.updateWishlistCount();
                return data.added;
            }
            return false;
        } catch (error) {
            console.error("Error toggling wishlist:", error);
            this.showToast("error", "Lỗi khi cập nhật yêu thích", "Lỗi!");
            return false;
        }
    },

    /**
     * Update cart badge count
     */
    updateCartCount() {
        fetch("/cart/count")
            .then((response) => response.json())
            .then((data) => {
                const cartBadge = document.querySelector("[data-cart-count]");
                if (cartBadge) {
                    if (data.count > 0) {
                        cartBadge.textContent = data.count;
                        cartBadge.style.display = "flex";
                    } else {
                        cartBadge.style.display = "none";
                    }
                }
            })
            .catch((err) => console.error("Error updating cart count:", err));
    },

    /**
     * Update wishlist badge count
     */
    updateWishlistCount() {
        fetch("/wishlist/count")
            .then((response) => response.json())
            .then((data) => {
                const wishlistBadge = document.querySelector("[data-wishlist-count]");
                if (wishlistBadge) {
                    if (data.count > 0) {
                        wishlistBadge.textContent = data.count;
                        wishlistBadge.style.display = "flex";
                    } else {
                        wishlistBadge.style.display = "none";
                    }
                }
            })
            .catch((err) => console.error("Error updating wishlist count:", err));
    },
};

export default CartUtils;
