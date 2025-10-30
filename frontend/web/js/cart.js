document.addEventListener("DOMContentLoaded", function () {
  // URL API thêm vào giỏ (nếu app nằm trong subfolder, sửa lại đường dẫn này tương ứng)
  var addToCartUrl = "/site/add-to-cart";

  // Lấy csrf token từ meta (Yii đã đăng ký CSRF meta tag)
  var csrf = document.querySelector('meta[name="csrf-token"]');
  var csrfToken = csrf ? csrf.getAttribute("content") : "";

  function updateCartBadge(count) {
    count = parseInt(count) || 0;
    var $badge = document.getElementById("cart-count");
    if ($badge) {
      $badge.textContent = count;
      if (count <= 0) $badge.remove();
      return;
    }
    // nếu chưa có badge, tìm link giỏ hàng và thêm
    var cartLink = document.querySelector(
      'a[href*="cart"], a[title="Giỏ hàng"]'
    );
    if (cartLink && count > 0) {
      var span = document.createElement("span");
      span.id = "cart-count";
      span.className =
        "position-absolute start-100 translate-middle badge rounded-circle bg-danger";
      span.style.cssText =
        "font-size:10px; min-width:16px; height:16px; line-height:9px; top:15%";
      span.textContent = count;
      cartLink.style.position = "relative";
      cartLink.appendChild(span);
    }
  }

  // Click handler cho nút thêm vào giỏ
  document.body.addEventListener("click", function (e) {
    var btn = e.target.closest(".add-to-cart-btn");
    if (!btn) return;
    e.preventDefault();

    // Lấy dữ liệu từ data- attributes
    var id = btn.getAttribute("data-id");
    var name = btn.getAttribute("data-name") || "";
    var price = btn.getAttribute("data-price") || 0;
    var image = btn.getAttribute("data-image") || "";

    if (!id) return;

    // Cảnh báo / disable tạm thời
    var originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-cart-check"></i> Đang thêm...';

    fetch(addToCartUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-Token": csrfToken,
      },
      body: JSON.stringify({
        id: id,
        name: name,
        price: parseFloat(price) || 0,
        image: image,
      }),
    })
      .then(function (r) {
        return r.json();
      })
      .then(function (res) {
        if (res && res.success) {
          updateCartBadge(res.cartCount || res.total || 0);
          // thông báo ngắn
          var notice = document.createElement("div");
          notice.className = "alert alert-success position-fixed";
          notice.style.cssText = "right:20px; bottom:20px; z-index:1050;";
          notice.textContent = "Đã thêm vào giỏ hàng";
          document.body.appendChild(notice);
          setTimeout(function () {
            notice.remove();
          }, 1800);
        } else {
          // lỗi
          var msg =
            res && res.message ? res.message : "Không thể thêm vào giỏ hàng";
          var noticeErr = document.createElement("div");
          noticeErr.className = "alert alert-danger position-fixed";
          noticeErr.style.cssText = "right:20px; bottom:20px; z-index:1050;";
          noticeErr.textContent = msg;
          document.body.appendChild(noticeErr);
          setTimeout(function () {
            noticeErr.remove();
          }, 2500);
        }
      })
      .catch(function () {
        var noticeErr = document.createElement("div");
        noticeErr.className = "alert alert-danger position-fixed";
        noticeErr.style.cssText = "right:20px; bottom:20px; z-index:1050;";
        noticeErr.textContent = "Lỗi kết nối";
        document.body.appendChild(noticeErr);
        setTimeout(function () {
          noticeErr.remove();
        }, 2500);
      })
      .finally(function () {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
      });
  });
});

//Cập nhật số lượng badge trên icon giỏ hàng
function updateCartBadge(count) {
  var $badge = $("#cart-count");
  var $li = $('a.nav-link.position-relative[title="Giỏ hàng"]').closest("li");
  if (count > 0) {
    if ($badge.length) {
      $badge.text(count);
    } else {
      $li.append(
        '<span id="cart-count" class="position-absolute start-100 translate-middle badge rounded-circle bg-danger" style="font-size:10px; min-width:16px; height:16px; line-height:9px; top:15%">' +
          count +
          "</span>"
      );
    }
  } else {
    $badge.remove();
  }
}

// $.post(addToCartUrl, JSON.stringify(data), function(response) { ... })
$.ajaxSetup({
  headers: {
    "X-CSRF-Token": window.csrfToken,
  },
});

// Nếu bạn dùng fetch / $.ajax khi bấm Add to cart:
// fetch(addToCartUrl, {method:'POST', body: JSON.stringify(payload), headers:{'Content-Type':'application/json'}})
// .then(r=>r.json()).then(res=>{ if(res.success) updateCartBadge(res.cartCount || res.total); });

// Và khi update-quantity AJAX trả về:
function handleUpdateQuantityResponse(res, $row) {
  if (!res.success) return;
  // cập nhật quantity hiển thị
  if (typeof res.quantity !== "undefined") {
    $row.find(".quantity-input").text(res.quantity); // tuỳ selector
  }
  // cập nhật subtotal/tổng nếu cần
  if (res.subtotal) {
    $row.find(".subtotal").text(res.subtotal);
  }
  if (res.total) {
    $(".cart-total-display").text(res.total);
  }
  // cập nhật badge bằng cartCount (distinct)
  updateCartBadge(res.cartCount || 0);
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
