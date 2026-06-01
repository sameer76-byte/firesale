$(document).ready(function() {
    // Update cart count dynamically
    function updateCartCount() {
        $.ajax({
            url: 'includes/cart_functions.php',
            method: 'GET',
            data: { action: 'get_count' },
            success: function(response) {
                $('.cart-count').text(response);
            }
        });
    }
    
    // Add to cart with AJAX
    $('.add-to-cart-form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: 'add_to_cart.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    updateCartCount();
                    showToast('Success!', result.message, 'success');
                } else {
                    showToast('Error!', result.message, 'error');
                }
            }
        });
    });
    
    // Toast notification
    function showToast(title, message, type) {
        var toastHtml = `
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <strong>${title}</strong><br>${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
        `;
        $('body').append(toastHtml);
        var toast = new bootstrap.Toast($('.toast').last());
        toast.show();
        setTimeout(function() {
            $('.toast').last().remove();
        }, 3000);
    }
    
    // Image zoom functionality
    $('.zoom-container').on('mousemove', function(e) {
        var zoomer = $(this);
        var offset = zoomer.offset();
        var x = (e.pageX - offset.left) / zoomer.width() * 100;
        var y = (e.pageY - offset.top) / zoomer.height() * 100;
        zoomer.find('.zoom-img').css({
            'transform-origin': x + '% ' + y + '%',
            'transform': 'scale(1.5)'
        });
    }).on('mouseleave', function() {
        $(this).find('.zoom-img').css('transform', 'scale(1)');
    });
    
    // Price filter slider
    $('#priceRange').on('input', function() {
        $('#priceValue').text('$' + $(this).val());
    });
    
    // Search suggestions
    $('#searchInput').on('keyup', function() {
        var query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: 'catalog.php',
                method: 'GET',
                data: { search: query, ajax: 1 },
                success: function(data) {
                    $('#productGrid').html(data);
                }
            });
        }
    });
});

// Star rating system
function setRating(rating) {
    $('.star-rating i').each(function(index) {
        if (index < rating) {
            $(this).removeClass('far').addClass('fas').css('color', '#fcbf49');
        } else {
            $(this).removeClass('fas').addClass('far').css('color', '#ddd');
        }
    });
    $('#rating').val(rating);
}