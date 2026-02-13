jQuery(document).ready(function($) {
    wp.customize('background_image', function(value) {
        console.log(value);
        value.bind(function(newval) {
            console.log(newval);
            if (newval) {
                wp.customize('minimalistflex_content_background_blend').activate();
                wp.customize('minimalistflex_sidebar_background_blend').activate();
            } else {
                wp.customize('minimalistflex_content_background_blend').deactivate();
                wp.customize('minimalistflex_sidebar_background_blend').deactivate();
            }
        });
    });
});