jQuery(document).ready(function($){
    let colors = ['default', 'level3-dark', 'link', 'link-hover', 'header-bg', 'header-text', 'header-menu', 'header-sidebar', 'level1', 'level2', 'tint', 'tint-dark', 'tint-alt', 'tint-contrast', 'contrast', 'contrast-dark', 'footer-text', 'footer-bg', 'secondary-menu-bg', 'secondary-menu-text'];
    wp.customize('header_textcolor', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--minimalistflex-header', newval.startsWith('#') ? newval : '#' + newval);
        });
    });
    for (let i = 0; i < colors.length; i++) {
        let color = colors[i];
        wp.customize('minimalistflex_color_' + color, function(value) {
            value.bind(function(newval) {
                document.documentElement.style.setProperty('--minimalistflex-' + color, newval);
            });
        });
    };
    wp.customize('minimalistflex_color_disable_shadow', function(value) {
        value.bind(function(newval) {
            if (newval === 'yes') {
                document.documentElement.style.setProperty('--minimalistflex-shadow', 'transparent');
                document.documentElement.style.setProperty('--minimalistflex-shadow-light', 'transparent');
            } else {
                document.documentElement.style.setProperty('--minimalistflex-shadow', 'rgba(0, 0, 0, 0.19)');
                document.documentElement.style.setProperty('--minimalistflex-shadow-light', 'rgba(0, 0, 0, 0.05)');
            }
        });
    });
    let sidebars = ['home', 'front', 'archive', 'search', 'author', 'singular', 'page', 'error', 'default'];
    for (let i = 0; i < sidebars.length; i++) {
        let sidebar = sidebars[i];
        wp.customize('minimalistflex_layout_' + sidebar + '_sidebar', function(value) {
            value.bind(function(newval) {
                $('.minimalistflex-master-' + sidebar).removeClass('minimalistflex-sidebar-layout-no minimalistflex-sidebar-layout-left minimalistflex-sidebar-layout-right').addClass('minimalistflex-sidebar-layout-' + newval);
            });
        });
    };

    wp.customize( 'minimalistflex_layout_error_title', function(value) {
        value.bind(function(newval) {
            $('.minimalistflex-404-message h1').text(newval);
        });
    });
    wp.customize( 'minimalistflex_layout_error_message', function(value) {
        value.bind(function(newval) {
            $('.minimalistflex-404-message p').first().text(newval);
        });
    });

    wp.customize('minimalistflex_content_background_blend', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--minimalistflex-content-blend', (100 - newval) + '%');
        });
    });
    wp.customize('minimalistflex_sidebar_background_blend', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--minimalistflex-sidebar-blend', (100 - newval) + '%');
        });
    });

    wp.customize('minimalistflex_interface_thumbnail_height', function(value) {
        value.bind(function(newval) {
            if (newval === 'auto') {
                document.documentElement.style.setProperty('--minimalistflex-max-height', 'auto');
            } else {
                let height = wp.customize('minimalistflex_interface_thumbnail_height_px').get();
                document.documentElement.style.setProperty('--minimalistflex-max-height', height + 'px');
            }
        });
    });

    wp.customize('minimalistflex_interface_thumbnail_height_px', function(value) {
        let thumbnailHeightSetting = wp.customize('minimalistflex_interface_thumbnail_height').get();
        if (thumbnailHeightSetting === 'fixed') {
            value.bind(function(newval) {
                document.documentElement.style.setProperty('--minimalistflex-max-height', newval + 'px');
            });
        }
    });

    wp.customize('minimalistflex_layout_home_waterfall', function(value) {
        value.bind(function(newval) {
            if (newval === 'yes') {
                $('.minimalistflex-home').addClass('waterfall');
            } else {
                $('.minimalistflex-home').removeClass('waterfall');
            }
        });
    });
});