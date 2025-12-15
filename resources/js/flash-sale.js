// Flash Sale Modal & Countdown Timer
import CartUtils from "./utils/cart-utils";

class FlashSaleCountdown {
    constructor() {
        this.intervals = new Map();
        this.currentFlashSales = [];
        this.init();
    }

    async init() {
        await this.loadFlashSales();
        this.renderCarousel();
        this.setupEventListeners();
        this.startCountdowns();
    }

    async loadFlashSales() {
        try {
            const baseUrl = CartUtils.getBaseUrl();
            const response = await fetch(baseUrl + "api/flash-sales/modal");
            const data = await response.json();

            if (data.success && data.has_flash_sales) {
                this.currentFlashSales = data.data;
                this.showNotificationBadge();
            }
        } catch (error) {
            console.error("Error loading flash sales:", error);
        }
    }

    renderCarousel() {
        if (this.currentFlashSales.length === 0) {
            document.getElementById("flashSaleCarousel").innerHTML = `
                <div class="alert alert-info m-4">
                    <i class="bi bi-info-circle me-2"></i>Hiện không có Flash Sale nào
                </div>
            `;
            return;
        }

        const template = document.getElementById("flashSaleCarouselTemplate");
        const clone = template.content.cloneNode(true);

        const indicatorsContainer = clone.getElementById("flashSaleIndicators");
        const itemsContainer = clone.getElementById("flashSaleCarouselItems");
        const itemTemplate = document.getElementById("flashSaleItemTemplate");

        // Generate indicators and items
        this.currentFlashSales.forEach((sale, index) => {
            // Indicator
            const indicator = document.createElement("button");
            indicator.type = "button";
            indicator.setAttribute("data-bs-target", "#flashSaleCarouselInner");
            indicator.setAttribute("data-bs-slide-to", index);
            indicator.setAttribute("aria-label", `Slide ${index + 1}`);
            if (index === 0) {
                indicator.classList.add("active");
                indicator.setAttribute("aria-current", "true");
            }
            indicator.style.width = "12px";
            indicator.style.height = "12px";
            indicator.style.borderRadius = "50%";
            indicator.style.backgroundColor =
                index === 0 ? "#FF6B6B" : "rgba(255, 107, 107, 0.5)";
            indicator.style.border = "none";
            indicator.style.margin = "0 6px";
            indicatorsContainer.appendChild(indicator);

            // Item
            const itemClone = itemTemplate.content.cloneNode(true);
            const item = itemClone.querySelector(".carousel-item");
            if (index !== 0) {
                item.classList.remove("active");
            }

            // Fill content
            itemClone.querySelector(".flash-sale-image").src =
                sale.image || "/images/placeholder.jpg";
            itemClone.querySelector(".flash-sale-title").textContent =
                sale.title;
            itemClone.querySelector(".flash-sale-description").textContent =
                sale.description || "";
            itemClone.querySelector(".discount-percent").textContent =
                sale.discount_percentage
                    ? `-${sale.discount_percentage}%`
                    : "HOT";
            itemClone.querySelector(".flash-sale-price").textContent =
                this.formatPrice(sale.sale_price);
            itemClone.querySelector(".flash-sale-original-price").textContent =
                this.formatPrice(sale.original_price);

            // Stock progress
            itemClone.querySelector(
                ".flash-sale-remaining-stock"
            ).textContent = `${sale.remaining_stock} sản phẩm`;
            itemClone.querySelector(".flash-sale-progress-bar").style.width =
                sale.sold_percentage + "%";
            itemClone.querySelector(
                ".flash-sale-stock-sold"
            ).textContent = `Đã bán: ${sale.sold_percentage}%`;

            // Add to cart button
            const addBtn = itemClone.querySelector(".flash-sale-add-btn");
            addBtn.setAttribute("data-flash-sale-id", sale.id);
            addBtn.addEventListener("click", () =>
                this.addToCart(sale.id, sale.title)
            );

            // Set countdown data
            const countdownElement = itemClone.querySelector(
                ".flash-sale-countdown"
            );
            countdownElement.setAttribute("data-end-time", sale.ends_at);

            itemsContainer.appendChild(itemClone);
        });

        document.getElementById("flashSaleCarousel").innerHTML = "";
        document.getElementById("flashSaleCarousel").appendChild(clone);

        // Initialize Bootstrap carousel
        const carousel = new bootstrap.Carousel(
            document.getElementById("flashSaleCarouselInner"),
            {
                interval: false,
                wrap: true,
            }
        );

        // Start countdown timers
        this.startCountdowns();
    }

    setupEventListeners() {
        // Modal open event
        const modal = document.getElementById("flashSaleModal");
        if (modal) {
            modal.addEventListener("show.bs.modal", () => {
                this.startCountdowns();
            });
        }

        // Notification badge click
        const notificationBadge = document.getElementById(
            "flashSaleNotification"
        );
        if (notificationBadge) {
            notificationBadge.addEventListener("click", () => {
                const modal = new bootstrap.Modal(
                    document.getElementById("flashSaleModal")
                );
                modal.show();
            });
        }
    }

    startCountdowns() {
        // Clear existing intervals
        this.intervals.forEach((interval) => clearInterval(interval));
        this.intervals.clear();

        const countdownElements = document.querySelectorAll(
            ".flash-sale-countdown"
        );
        countdownElements.forEach((element, index) => {
            const endTime = element.getAttribute("data-end-time");
            if (endTime) {
                this.updateCountdown(element, endTime);

                const intervalId = setInterval(() => {
                    this.updateCountdown(element, endTime);
                }, 1000);

                this.intervals.set(index, intervalId);
            }
        });

        // Update notification badge countdown
        this.updateNotificationCountdown();
    }

    updateCountdown(element, endTime) {
        const now = new Date().getTime();
        const end = new Date(endTime).getTime();
        const distance = end - now;

        if (distance < 0) {
            element.querySelector(".countdown-hours").textContent = "00";
            element.querySelector(".countdown-minutes").textContent = "00";
            element.querySelector(".countdown-seconds").textContent = "00";

            element
                .closest(".carousel-item")
                ?.querySelector(".flash-sale-add-btn")
                ?.setAttribute("disabled", "disabled");
            return;
        }

        const hours = Math.floor(
            (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        element.querySelector(".countdown-hours").textContent = String(
            hours
        ).padStart(2, "0");
        element.querySelector(".countdown-minutes").textContent = String(
            minutes
        ).padStart(2, "0");
        element.querySelector(".countdown-seconds").textContent = String(
            seconds
        ).padStart(2, "0");
    }

    updateNotificationCountdown() {
        if (this.currentFlashSales.length === 0) return;

        const firstSale = this.currentFlashSales[0];
        const notificationCountdown = document.querySelector(
            ".flash-sale-notify-countdown"
        );

        if (notificationCountdown) {
            const now = new Date().getTime();
            const end = new Date(firstSale.ends_at).getTime();
            const distance = end - now;

            if (distance > 0) {
                const minutes = Math.floor(
                    (distance % (1000 * 60 * 60)) / (1000 * 60)
                );
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                notificationCountdown.textContent = `${String(minutes).padStart(
                    2,
                    "0"
                )}:${String(seconds).padStart(2, "0")}`;
            }
        }
    }

    showNotificationBadge() {
        const notification = document.getElementById("flashSaleNotification");
        if (notification && this.currentFlashSales.length > 0) {
            notification.classList.remove("d-none");
        }
    }

    async addToCart(flashSaleId, title) {
        const quantity = prompt("Nhập số lượng:", "1");
        if (!quantity || isNaN(quantity) || parseInt(quantity) < 1) {
            CartUtils.showToast("error", "Vui lòng nhập số lượng hợp lệ", "Lỗi");
            return;
        }
        await CartUtils.addFlashSaleToCart(flashSaleId, parseInt(quantity));
    }

    formatPrice(price) {
        return CartUtils.formatPrice(price);
    }
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", () => {
    window.flashSaleInstance = new FlashSaleCountdown();
});

// Refresh flash sales every 5 minutes
setInterval(() => {
    if (window.flashSaleInstance) {
        window.flashSaleInstance.loadFlashSales();
    }
}, 5 * 60 * 1000);
