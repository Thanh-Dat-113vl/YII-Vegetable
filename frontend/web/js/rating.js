$(document).ready(function () {

    // ⭐ Xử lý chọn sao
    $('#star-wrapper .star').on('click', function () {
        const value = $(this).data('value');
        const level = {
            1: 'Rất tệ',
            2: 'Tệ',
            3: 'Bình thường',
            4: 'Tốt',
            5: 'Rất tốt'
        }

        $('#review-rating').val(value);
        $('#star-wrapper .star').css('color', '#e4e4e4');
        for (let i = 1; i <= value; i++) {
            $('#star-wrapper .star[data-value="' + i + '"]').css('color', '#ffc107');
        }
        $('#star-label').text(`${level[value]}`);
        checkSubmitEnable();
    });

    // Kích hoạt nút Gửi nếu hợp lệ
    $('#review-modal-form input, #review-modal-form textarea').on('input change', function () {
        checkSubmitEnable();
    });

    function checkSubmitEnable() {
        let rating = $('#review-rating').val();
        let name = $('input[name="Review[review_name]"]').val().trim();
        let phone = $('input[name="Review[review_phone]"]').val().trim();
        let agree = $('#policyCheck').is(':checked');
        if (rating && name && phone && agree) {
            $('#submit-review-btn').prop('disabled', false);
        } else {
            $('#submit-review-btn').prop('disabled', true);
        }
    }

    // 🚀 Gửi form bằng AJAX
    $('#review-modal-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let formData = form.serialize();

        $('#submit-review-btn').prop('disabled', true).text('Đang gửi...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    showToast('Cảm ơn bạn đã đánh giá sản phẩm!', 'success');
                    form[0].reset();
                    $('#review-rating').val('');
                    $('#star-wrapper .star').css('color', '#e4e4e4');
                    $('#star-label').text('Chọn đánh giá');
                    $('#review-modal-form').find('#submit-review-btn').prop('disabled', true).text('Gửi đánh giá');
                    $('#reviewModal').modal('hide');
                } else {
                    showToast('Gửi thất bại, vui lòng thử lại.', 'danger');
                    $('#submit-review-btn').prop('disabled', false).text('Gửi đánh giá');
                }
            },
            error: function () {
                showToast('Lỗi máy chủ, vui lòng thử lại!', 'danger');
                $('#submit-review-btn').prop('disabled', false).text('Gửi đánh giá');
            }
        });
    });


    function showToast(msg, type = 'success') {
        const toast = $('<div>')
            .text(msg)
            .addClass(`toast-msg bg-${type} text-white rounded shadow p-2 position-fixed end-0 top-0 m-3`)
            .css({ zIndex: 9999 });
        $('body').append(toast);
        setTimeout(() => toast.fadeOut(500, () => toast.remove()), 3000);
    }
});