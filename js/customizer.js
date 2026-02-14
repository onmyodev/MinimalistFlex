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
            let betaSettings = ['minimalistflex_layout_home_waterfall'];
            betaSettings.forEach(function(settingName) {
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