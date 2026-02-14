jQuery(document).ready(function($) {
    wp.customize('background_image', function (setting) {
        function toggleControl( value ) {
            
            wp.customize.control( 'minimalistflex_content_background_blend', function( control ) {
                if ( !value ) {
                    control.deactivate();
                } else {
                    control.activate();
                }
            });
            wp.customize.control( 'minimalistflex_sidebar_background_blend', function( control ) {
                if ( !value ) {
                    control.deactivate();
                } else {
                    control.activate();
                }
            });

        }

        // 初始执行一次
        toggleControl( setting.get() );

        // 监听变化
        setting.bind( function( newval ) {
            toggleControl( newval );
        });
    });

    wp.customize('minimalistflex_beta_feature_enabled', function (setting) {
        function toggleControl( value ) {
            let betaSettings = ['minimalistflex_layout_home_waterfall', 'minimalistflex_youtube_link', 'minimalistflex_x_link', 'minimalistflex_facebook_link', 'minimalistflex_instagram_link', 'minimalistflex_mastodon_link', 'minimalistflex_github_link', 'minimalistflex_custom_social_link', 'minimalistflex_custom_social_icon', 'minimalistflex_layout_home_excerpt_mode', 'minimalistflex_layout_home_excerpt_length'];
            betaSettings.forEach(function(settingName) {
                $("#customize-control-" + settingName).toggleClass('beta-feature', true);
                wp.customize.control( settingName, function( control ) {
                    if ( !value ) {
                        control.deactivate();
                    } else {
                        control.activate();
                    }
                });
            });
        }

        // 初始执行一次
        toggleControl( setting.get() );

        // 监听变化
        setting.bind( function( newval ) {
            toggleControl( newval );
        });
    });
});