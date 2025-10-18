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
      console.log("data cart", data);

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
            showToast("Đã thêm vào giỏ hàng!");
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
  const badgeId = "cart-count";
  let badge = document.getElementById(badgeId);

  // Nếu badge đã có => cập nhật
  if (badge) {
    badge.textContent = total;
    badge.classList.toggle("d-none", total <= 0);
    return;
  }

  // Nếu chưa có badge => tạo mới
  const cartIcon = document.querySelector(".bi-cart, .bi-cart-plus, .bi-cart3");
  if (!cartIcon) return;

  // Tìm phần tử cha để gắn badge vào
  let parent = cartIcon.closest("a.nav-link") || cartIcon.parentElement;
  if (!parent) return;

  // Tạo badge mới
  const newBadge = document.createElement("span");
  newBadge.id = badgeId;
  newBadge.className =
    "position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger";
  newBadge.style.cssText =
    "font-size:10px; min-width:16px; height:16px; line-height:9px; top:15%";
  newBadge.textContent = total;

  // Gắn parent position-relative để định vị badge đúng
  parent.style.position = "relative";
  parent.appendChild(newBadge);
}

// 🔹 Hiển thị thông báo đơn giản (toast mini)
function showToast(msg) {
  const toast = document.createElement("div");
  toast.textContent = msg;
  toast.className =
    "position-fixed top-0 end-0 bg-dark text-white p-2 m-3 rounded shadow";
  toast.style.zIndex = 9999;
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 2000);
}
