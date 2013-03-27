jQuery(document).ready(function() {
    jQuery('#upload-favicon-button').click(function() {
        uploadfield = '#upload-favicon';
		formfield = jQuery(uploadfield).attr('name');
		tbframe_interval = setInterval(function() {jQuery('#TB_iframeContent').contents().find('.savesend .button').val(picolight_localizing_upload_js.use_this_image);}, 2000);
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');

        return false;
    });

    window.send_to_editor = function(html) {
        imgurl = jQuery('img', html).attr('src');
        jQuery(uploadfield).val(imgurl);
        tb_remove();
    }
});
