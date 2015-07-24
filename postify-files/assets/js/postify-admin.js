;jQuery(function($) {
    $('.postify_upload').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            console.log(uploaded_image.id);
            var image_url = uploaded_image.toJSON().url;
            $('.postify_upload_input').val(uploaded_image.id);
            $('#featured-footer-image-container img').attr('src', image_url).parent().removeClass('hidden');
        });
    });
});