// Delete variant confirmation and handling
function deleteVariant(variantId) {
    if(confirm('Are you sure you want to delete this variant?')) {
        window.location.href = baseUrl + 'admin/products/delete_variant/' + variantId;
    }
}

// Delete variant image
function deleteVariantImage(imageId) {
    if(confirm('Are you sure you want to delete this image?')) {
        $.ajax({
            url: baseUrl + 'admin/products/delete_variant_image',
            type: 'POST',
            data: { image_id: imageId },
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#image-' + imageId).remove();
                }
            }
        });
    }
}

// Image preview handling
$(document).ready(function() {
    $('.file-input').on('change', function(e) {
        var files = e.target.files;
        var preview = $(this).closest('.image-upload-container').find('.image-preview');
        preview.html('');
        
        for(var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = (function(file) {
                return function(e) {
                    preview.append(
                        '<div class="image-item temp-image">' +
                        '<img src="' + e.target.result + '" class="thumb">' +
                        '</div>'
                    );
                };
            })(files[i]);
            reader.readAsDataURL(files[i]);
        }
    });

    // Delete existing image (delegated)
    $(document).on('click', '.delete-image', function(e) {
        e.preventDefault();
        var imageId = $(this).data('id');
        if(!imageId) return;
        if(confirm('Are you sure you want to delete this image?')) {
            $.ajax({
                url: baseUrl + 'admin/products/delete_variant_image',
                type: 'POST',
                data: { image_id: imageId },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        // remove element from DOM
                        $('#image-' + imageId).fadeOut(200, function(){ $(this).remove(); });
                    } else {
                        // if backend indicates failure, reload to keep UI consistent
                        alert(response.message || 'Failed to delete image');
                        location.reload();
                    }
                },
                error: function() {
                    alert('Error deleting image');
                    location.reload();
                }
            });
        }
    });
});
