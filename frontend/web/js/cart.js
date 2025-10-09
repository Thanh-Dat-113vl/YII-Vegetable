document.addEventListener("DOMContentLoaded", function () {
  // Gắn sự kiện click cho tất cả nút có class .add-to-cart-btn
  document.querySelectorAll(".add-to-cart-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const data = {
        id: this.dataset.id,
        name: this.dataset.name,
        price: this.dataset.price,
        image: this.dataset.image,
      };

      fetch(window.addToCartUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-Token": window.csrfToken,
        },
        body: JSON.stringify(data),
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success) {
            updateCartBadge(res.total);
            showToast("✅ Đã thêm vào giỏ hàng!");
          } else {
            showToast("❌ Lỗi thêm giỏ hàng!");
          }
        })
        .catch((err) => {
          console.error("Fetch error:", err);
          showToast("⚠️ Kết nối thất bại!");
        });
    });
  });
});

// 🔹 Cập nhật số lượng badge trên icon giỏ hàng
function updateCartBadge(total) {
  let badge = document.getElementById("cart-count");
  if (badge) {
    badge.textContent = total;
    badge.classList.remove("d-none");
  } else {
    // Nếu badge chưa có, tạo mới
    const cartIcon = document.querySelector(".bi-cart");
    if (cartIcon) {
      const parent = cartIcon.closest(".nav-item");
      const newBadge = document.createElement("span");
      newBadge.id = "cart-count";
      newBadge.className =
        "position-absolute start-100 translate-middle badge rounded-circle bg-danger";
      newBadge.style =
        "font-size:10px; min-width:16px; height:16px; line-height:14px; top:15%";
      newBadge.textContent = total;
      parent.appendChild(newBadge);
    }
  }
}

// 🔹 Hiển thị thông báo đơn giản (toast mini)
function showToast(msg) {
  const toast = document.createElement("div");
  toast.textContent = msg;
  toast.className =
    "position-fixed bottom-0 end-0 bg-dark text-white p-2 m-3 rounded shadow";
  toast.style.zIndex = 9999;
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 2000);
}
