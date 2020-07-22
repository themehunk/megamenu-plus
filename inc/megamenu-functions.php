<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}
if ( ! function_exists('mmplus_get_attached_location_with_menu')){
	function mmplus_get_attached_location_with_menu( $menu_id = 0 ) {
		if ( ! $menu_id){
			return;
		}

		$locations = array();
		$nav_menu_locations = get_nav_menu_locations();
		$nav_menus = get_registered_nav_menus();

		foreach ($nav_menus  as $id => $name ) {
			if ( isset( $nav_menu_locations[ $id ] ) && $nav_menu_locations[$id] == $menu_id ){
				$locations[$id] = $name;
			}
		}
		return $locations;
	}
}

if ( ! function_exists('get_mmplus_option')){
    function get_mmplus_option( $id ) {
        $options = get_option( 'mmplus_options' );
        if ( isset( $options[$id] ) ) {
            return $options[$id];
        }
        return false;
    }
}
 
if ( ! function_exists( 'mmplus_is_enabled' ) ) {

    /**
     * Determines if Themehunk Mega Menu has been enabled for a given menu location.
     *
     * Usage:
     *
     * Mega Menu is enabled:
     * function_exists( 'mega_menu_mmplus_is_enabled' )
     *
     * Mega Menu has been enabled for a theme location:
     * function_exists( 'mega_menu_mmplus_is_enabled' ) && mega_menu_mmplus_is_enabled( $location )
     *
     * @since 1.8
     * @param string $location - theme location identifier
     */
    function mmplus_is_enabled( $location = false ) {

        if ( ! $location ) {
            return true; // the plugin is enabled
        }

        if ( ! has_nav_menu( $location ) ) {
            return false;
        }

        // if a location has been passed, check to see if MMTH has been enabled for the location
        $options = get_option( 'mmplus_options' );

        return is_array( $options ) && isset( $options[ $location ]['is_enabled'] ) && $options[ $location ]['is_enabled'] == 1;
    }
}

if ( ! function_exists( 'mmplus_mmplus_get_theme_id_for_location' ) ) {

    /**
     * @since 2.1
     * @param string $location - theme location identifier
     */
    function mmplus_mmplus_get_theme_id_for_location( $location = false ) {

        if ( ! $location ) {
            return false;
        }

        if ( ! has_nav_menu( $location ) ) {
            return false;
        }

        // if a location has been passed, check to see if MMM has been enabled for the location
        $settings = get_option( 'mmplus_options' );

        if ( is_array( $settings ) && isset( $settings[ $location ]['is_enabled'] ) && isset( $settings[ $location ]['menu_id'] ) ) {
            return $settings[ $location ]['menu_id'];
        }

        return false;
    }
}

/**
 * @param array $array
 * @return int|null|string
 */
if ( ! function_exists('mmplus_get_array_first_key')){
    function mmplus_get_array_first_key($array = array()){
        if (! empty($array)){
            foreach ($array as $key => $value){
                return $key;
            }
        }
        return null;
    }
}



add_shortcode( 'mmplus_test_shortcode', 'mmplus_test_shortcode_function' );

function mmplus_test_shortcode_function(){ 
      // $options = get_option( 'mmplus_options' );
    $updated_data = get_post_meta( 1807, 'mmplus_layout', true );

    $mmplus_nav_locations = get_nav_menu_locations();
 
    $available_menus = wp_get_nav_menus();

    return print_r($mmplus_nav_locations);
    // return '<pre>'. print_r($available_menus) . '</pre>';
}


if ( ! function_exists('mmplus_dashicons')) {
    function mmplus_dashicons(){
        $icons = array(
            'dashicons-menu' => __('Menu', 'megamenu-plus'),
            'dashicons-dashboard' => __('Dashboard', 'megamenu-plus'),
            'dashicons-admin-site' => __('Admin Site', 'megamenu-plus'),
            'dashicons-admin-media' => __('Admin Media', 'megamenu-plus'),
            'dashicons-admin-page' => __('Admin Page', 'megamenu-plus'),
            'dashicons-admin-comments' => __('Admin Comments', 'megamenu-plus'),
            'dashicons-admin-appearance' => __('Admin Appearance', 'megamenu-plus'),
            'dashicons-admin-plugins' => __('Admin Plugins', 'megamenu-plus'),
            'dashicons-admin-users' => __('Admin Users', 'megamenu-plus'),
            'dashicons-admin-tools' => __('Admin Tools', 'megamenu-plus'),
            'dashicons-admin-settings' => __('Admin Settings', 'megamenu-plus'),
            'dashicons-admin-network' => __('Admin Network', 'megamenu-plus'),
            'dashicons-admin-generic' => __('Admin Generic', 'megamenu-plus'),
            'dashicons-admin-home' => __('Admin Home', 'megamenu-plus'),
            'dashicons-admin-collapse' => __('Admin Collapse', 'megamenu-plus'),
            'dashicons-admin-links' => __('Admin Links', 'megamenu-plus'),
            'dashicons-admin-post' => __('Admin Post', 'megamenu-plus'),
            'dashicons-format-standard' => __('Admin Plugins', 'megamenu-plus'),
            'dashicons-format-image' => __('Image Post Format', 'megamenu-plus'),
            'dashicons-format-gallery' => __('Gallery Post Format', 'megamenu-plus'),
            'dashicons-format-audio' => __('Audio Post Format', 'megamenu-plus'),
            'dashicons-format-video' => __('Video Post Format', 'megamenu-plus'),
            'dashicons-format-links' => __('Link Post Format', 'megamenu-plus'),
            'dashicons-format-chat' => __('Chat Post Format', 'megamenu-plus'),
            'dashicons-format-status' => __('Status Post Format', 'megamenu-plus'),
            'dashicons-format-aside' => __('Aside Post Format', 'megamenu-plus'),
            'dashicons-format-quote' => __('Quote Post Format', 'megamenu-plus'),
            'dashicons-welcome-write-blog' => __('Welcome Write Blog', 'megamenu-plus'),
            'dashicons-welcome-edit-page' => __('Welcome Edit Page', 'megamenu-plus'),
            'dashicons-welcome-add-page' => __('Welcome Add Page', 'megamenu-plus'),
            'dashicons-welcome-view-site' => __('Welcome View Site', 'megamenu-plus'),
            'dashicons-welcome-widgets-menus' => __('Welcome Widget Menus', 'megamenu-plus'),
            'dashicons-welcome-comments' => __('Welcome Comments', 'megamenu-plus'),
            'dashicons-welcome-learn-more' => __('Welcome Learn More', 'megamenu-plus'),
            'dashicons-image-crop' => __('Image Crop', 'megamenu-plus'),
            'dashicons-image-rotate-left' => __('Image Rotate Left', 'megamenu-plus'),
            'dashicons-image-rotate-right' => __('Image Rotate Right', 'megamenu-plus'),
            'dashicons-image-flip-vertical' => __('Image Flip Vertical', 'megamenu-plus'),
            'dashicons-image-flip-horizontal' => __('Image Flip Horizontal', 'megamenu-plus'),
            'dashicons-undo' => __('Undo', 'megamenu-plus'),
            'dashicons-redo' => __('Redo', 'megamenu-plus'),
            'dashicons-editor-bold' => __('Editor Bold', 'megamenu-plus'),
            'dashicons-editor-italic' => __('Editor Italic', 'megamenu-plus'),
            'dashicons-editor-ul' => __('Editor UL', 'megamenu-plus'),
            'dashicons-editor-ol' => __('Editor OL', 'megamenu-plus'),
            'dashicons-editor-quote' => __('Editor Quote', 'megamenu-plus'),
            'dashicons-editor-alignleft' => __('Editor Align Left', 'megamenu-plus'),
            'dashicons-editor-aligncenter' => __('Editor Align Center', 'megamenu-plus'),
            'dashicons-editor-alignright' => __('Editor Align Right', 'megamenu-plus'),
            'dashicons-editor-insertmore' => __('Editor Insert More', 'megamenu-plus'),
            'dashicons-editor-spellcheck' => __('Editor Spell Check', 'megamenu-plus'),
            'dashicons-editor-distractionfree' => __('Editor Distraction Free', 'megamenu-plus'),
            'dashicons-editor-expand' => __('Editor Expand', 'megamenu-plus'),
            'dashicons-editor-contract' => __('Editor Contract', 'megamenu-plus'),
            'dashicons-editor-kitchensink' => __('Editor Kitchen Sink', 'megamenu-plus'),
            'dashicons-editor-underline' => __('Editor Underline', 'megamenu-plus'),
            'dashicons-editor-justify' => __('Editor Justify', 'megamenu-plus'),
            'dashicons-editor-textcolor' => __('Editor Text Colour', 'megamenu-plus'),
            'dashicons-editor-paste-word' => __('Editor Paste Word', 'megamenu-plus'),
            'dashicons-editor-paste-text' => __('Editor Paste Text', 'megamenu-plus'),
            'dashicons-editor-removeformatting' => __('Editor Remove Formatting', 'megamenu-plus'),
            'dashicons-editor-video' => __('Editor Video', 'megamenu-plus'),
            'dashicons-editor-customchar' => __('Editor Custom Character', 'megamenu-plus'),
            'dashicons-editor-outdent' => __('Editor Outdent', 'megamenu-plus'),
            'dashicons-editor-indent' => __('Editor Indent', 'megamenu-plus'),
            'dashicons-editor-help' => __('Editor Help', 'megamenu-plus'),
            'dashicons-editor-strikethrough' => __('Editor Strikethrough', 'megamenu-plus'),
            'dashicons-editor-unlink' => __('Editor Unlink', 'megamenu-plus'),
            'dashicons-editor-rtl' => __('Editor RTL', 'megamenu-plus'),
            'dashicons-editor-break' => __('Editor Break', 'megamenu-plus'),
            'dashicons-editor-code' => __('Editor Code', 'megamenu-plus'),
            'dashicons-editor-paragraph' => __('Editor Paragraph', 'megamenu-plus'),
            'dashicons-align-left' => __('Align Left', 'megamenu-plus'),
            'dashicons-align-right' => __('Align Right', 'megamenu-plus'),
            'dashicons-align-center' => __('Align Center', 'megamenu-plus'),
            'dashicons-align-none' => __('Align None', 'megamenu-plus'),
            'dashicons-lock' => __('Lock', 'megamenu-plus'),
            'dashicons-calendar' => __('Calendar', 'megamenu-plus'),
            'dashicons-visibility' => __('Visibility', 'megamenu-plus'),
            'dashicons-post-status' => __('Post Status', 'megamenu-plus'),
            'dashicons-edit' => __('Edit', 'megamenu-plus'),
            'dashicons-post-trash' => __('Post Trash', 'megamenu-plus'),
            'dashicons-trash' => __('Trash', 'megamenu-plus'),
            'dashicons-external' => __('External', 'megamenu-plus'),
            'dashicons-arrow-up' => __('Arrow Up', 'megamenu-plus'),
            'dashicons-arrow-down' => __('Arrow Down', 'megamenu-plus'),
            'dashicons-arrow-left' => __('Arrow Left', 'megamenu-plus'),
            'dashicons-arrow-right' => __('Arrow Right', 'megamenu-plus'),
            'dashicons-arrow-up-alt' => __('Arrow Up (alt)', 'megamenu-plus'),
            'dashicons-arrow-down-alt' => __('Arrow Down (alt)', 'megamenu-plus'),
            'dashicons-arrow-left-alt' => __('Arrow Left (alt)', 'megamenu-plus'),
            'dashicons-arrow-right-alt' => __('Arrow Right (alt)', 'megamenu-plus'),
            'dashicons-arrow-up-alt2' => __('Arrow Up (alt 2)', 'megamenu-plus'),
            'dashicons-arrow-down-alt2' => __('Arrow Down (alt 2)', 'megamenu-plus'),
            'dashicons-arrow-left-alt2' => __('Arrow Left (alt 2)', 'megamenu-plus'),
            'dashicons-arrow-right-alt2' => __('Arrow Right (alt 2)', 'megamenu-plus'),
            'dashicons-leftright' => __('Arrow Left-Right', 'megamenu-plus'),
            'dashicons-sort' => __('Sort', 'megamenu-plus'),
            'dashicons-randomize' => __('Randomise', 'megamenu-plus'),
            'dashicons-list-view' => __('List View', 'megamenu-plus'),
            'dashicons-exerpt-view' => __('Excerpt View', 'megamenu-plus'),
            'dashicons-hammer' => __('Hammer', 'megamenu-plus'),
            'dashicons-art' => __('Art', 'megamenu-plus'),
            'dashicons-migrate' => __('Migrate', 'megamenu-plus'),
            'dashicons-performance' => __('Performance', 'megamenu-plus'),
            'dashicons-universal-access' => __('Universal Access', 'megamenu-plus'),
            'dashicons-universal-access-alt' => __('Universal Access (alt)', 'megamenu-plus'),
            'dashicons-tickets' => __('Tickets', 'megamenu-plus'),
            'dashicons-nametag' => __('Name Tag', 'megamenu-plus'),
            'dashicons-clipboard' => __('Clipboard', 'megamenu-plus'),
            'dashicons-heart' => __('Heart', 'megamenu-plus'),
            'dashicons-megaphone' => __('Megaphone', 'megamenu-plus'),
            'dashicons-schedule' => __('Schedule', 'megamenu-plus'),
            'dashicons-wordpress' => __('WordPress', 'megamenu-plus'),
            'dashicons-wordpress-alt' => __('WordPress (alt)', 'megamenu-plus'),
            'dashicons-pressthis' => __('Press This', 'megamenu-plus'),
            'dashicons-update' => __('Update', 'megamenu-plus'),
            'dashicons-screenoptions' => __('Screen Options', 'megamenu-plus'),
            'dashicons-info' => __('Info', 'megamenu-plus'),
            'dashicons-cart' => __('Cart', 'megamenu-plus'),
            'dashicons-feedback' => __('Feedback', 'megamenu-plus'),
            'dashicons-cloud' => __('Cloud', 'megamenu-plus'),
            'dashicons-translation' => __('Translation', 'megamenu-plus'),
            'dashicons-tag' => __('Tag', 'megamenu-plus'),
            'dashicons-category' => __('Category', 'megamenu-plus'),
            'dashicons-archive' => __('Archive', 'megamenu-plus'),
            'dashicons-tagcloud' => __('Tag Cloud', 'megamenu-plus'),
            'dashicons-text' => __('Text', 'megamenu-plus'),
            'dashicons-media-archive' => __('Media Archive', 'megamenu-plus'),
            'dashicons-media-audio' => __('Media Audio', 'megamenu-plus'),
            'dashicons-media-code' => __('Media Code)', 'megamenu-plus'),
            'dashicons-media-default' => __('Media Default', 'megamenu-plus'),
            'dashicons-media-document' => __('Media Document', 'megamenu-plus'),
            'dashicons-media-interactive' => __('Media Interactive', 'megamenu-plus'),
            'dashicons-media-spreadsheet' => __('Media Spreadsheet', 'megamenu-plus'),
            'dashicons-media-text' => __('Media Text', 'megamenu-plus'),
            'dashicons-media-video' => __('Media Video', 'megamenu-plus'),
            'dashicons-playlist-audio' => __('Audio Playlist', 'megamenu-plus'),
            'dashicons-playlist-video' => __('Video Playlist', 'megamenu-plus'),
            'dashicons-yes' => __('Yes', 'megamenu-plus'),
            'dashicons-no' => __('No', 'megamenu-plus'),
            'dashicons-no-alt' => __('No (alt)', 'megamenu-plus'),
            'dashicons-plus' => __('Plus', 'megamenu-plus'),
            'dashicons-plus-alt' => __('Plus (alt)', 'megamenu-plus'),
            'dashicons-minus' => __('Minus', 'megamenu-plus'),
            'dashicons-dismiss' => __('Dismiss', 'megamenu-plus'),
            'dashicons-marker' => __('Marker', 'megamenu-plus'),
            'dashicons-star-filled' => __('Star Filled', 'megamenu-plus'),
            'dashicons-star-half' => __('Star Half', 'megamenu-plus'),
            'dashicons-star-empty' => __('Star Empty', 'megamenu-plus'),
            'dashicons-flag' => __('Flag', 'megamenu-plus'),
            'dashicons-share' => __('Share', 'megamenu-plus'),
            'dashicons-share1' => __('Share 1', 'megamenu-plus'),
            'dashicons-share-alt' => __('Share (alt)', 'megamenu-plus'),
            'dashicons-share-alt2' => __('Share (alt 2)', 'megamenu-plus'),
            'dashicons-twitter' => __('twitter', 'megamenu-plus'),
            'dashicons-rss' => __('RSS', 'megamenu-plus'),
            'dashicons-email' => __('Email', 'megamenu-plus'),
            'dashicons-email-alt' => __('Email (alt)', 'megamenu-plus'),
            'dashicons-facebook' => __('Facebook', 'megamenu-plus'),
            'dashicons-facebook-alt' => __('Facebook (alt)', 'megamenu-plus'),
            'dashicons-networking' => __('Networking', 'megamenu-plus'),
            'dashicons-googleplus' => __('Google+', 'megamenu-plus'),
            'dashicons-location' => __('Location', 'megamenu-plus'),
            'dashicons-location-alt' => __('Location (alt)', 'megamenu-plus'),
            'dashicons-camera' => __('Camera', 'megamenu-plus'),
            'dashicons-images-alt' => __('Images', 'megamenu-plus'),
            'dashicons-images-alt2' => __('Images Alt', 'megamenu-plus'),
            'dashicons-video-alt' => __('Video (alt)', 'megamenu-plus'),
            'dashicons-video-alt2' => __('Video (alt 2)', 'megamenu-plus'),
            'dashicons-video-alt3' => __('Video (alt 3)', 'megamenu-plus'),
            'dashicons-vault' => __('Vault', 'megamenu-plus'),
            'dashicons-shield' => __('Shield', 'megamenu-plus'),
            'dashicons-shield-alt' => __('Shield (alt)', 'megamenu-plus'),
            'dashicons-sos' => __('SOS', 'megamenu-plus'),
            'dashicons-search' => __('Search', 'megamenu-plus'),
            'dashicons-slides' => __('Slides', 'megamenu-plus'),
            'dashicons-analytics' => __('Analytics', 'megamenu-plus'),
            'dashicons-chart-pie' => __('Pie Chart', 'megamenu-plus'),
            'dashicons-chart-bar' => __('Bar Chart', 'megamenu-plus'),
            'dashicons-chart-line' => __('Line Chart', 'megamenu-plus'),
            'dashicons-chart-area' => __('Area Chart', 'megamenu-plus'),
            'dashicons-groups' => __('Groups', 'megamenu-plus'),
            'dashicons-businessman' => __('Businessman', 'megamenu-plus'),
            'dashicons-id' => __('ID', 'megamenu-plus'),
            'dashicons-id-alt' => __('ID (alt)', 'megamenu-plus'),
            'dashicons-products' => __('Products', 'megamenu-plus'),
            'dashicons-awards' => __('Awards', 'megamenu-plus'),
            'dashicons-forms' => __('Forms', 'megamenu-plus'),
            'dashicons-testimonial' => __('Testimonial', 'megamenu-plus'),
            'dashicons-portfolio' => __('Portfolio', 'megamenu-plus'),
            'dashicons-book' => __('Book', 'megamenu-plus'),
            'dashicons-book-alt' => __('Book (alt)', 'megamenu-plus'),
            'dashicons-download' => __('Download', 'megamenu-plus'),
            'dashicons-upload' => __('Upload', 'megamenu-plus'),
            'dashicons-backup' => __('Backup', 'megamenu-plus'),
            'dashicons-clock' => __('Clock', 'megamenu-plus'),
            'dashicons-lightbulb' => __('Lightbulb', 'megamenu-plus'),
            'dashicons-microphone' => __('Microphone', 'megamenu-plus'),
            'dashicons-desktop' => __('Desktop', 'megamenu-plus'),
            'dashicons-tablet' => __('Tablet', 'megamenu-plus'),
            'dashicons-smartphone' => __('Smartphone', 'megamenu-plus'),
            'dashicons-smiley' => __('Smiley', 'megamenu-plus')
        );

        return $icons;
    }
}


if( ! function_exists('mmplus_share_themes_across_multisite') ) {
    /*
     * In the first version of MMM, themes were (incorrectly) shared between all sites in a multi site network.
     * Themes will not be shared across sites for new users installing v2.4.3 onwards, but they will be shared for existing (older) users.
     *
     * @since 2.3.7
     */
    function mmplus_share_themes_across_multisite(){

        if ( defined('MMPLUS_SHARE_THEMES_MULTISITE') && MMPLUS_SHARE_THEMES_MULTISITE === false ) {
            return false;
        }

        if ( defined('MMPLUS_SHARE_THEMES_MULTISITE') && MMPLUS_SHARE_THEMES_MULTISITE === true ) {
            return true;
        }

        if ( get_option('mmplus_multisite_share_themes') === 'false' ) { // only exists if initially installed version is 2.4.3+
            return false;
        }

        return apply_filters( 'mmplus_share_themes_across_multisite', true );
        
    }
}

if ( ! function_exists('mmplus_menu_get_last_updated_theme') ) {
    /*
     * Return last updated theme
     *
     * @since 2.3.7
     */
    function mmplus_menu_get_last_updated_theme() {

        if ( ! mmplus_share_themes_across_multisite() ) {
            return get_option( "mmplus_themes_last_updated" );
        }

        return get_site_option( "mmplus_themes_last_updated" );
        
    }
}

    if ( ! function_exists('mmplus_menu_get_themes') ) {
    /*
     * Return saved themes
     *
     * @since 2.3.7
     */
    function mmplus_menu_get_themes() {

        if ( ! mmplus_share_themes_across_multisite() ) {
            return get_option( "mmplus_themes" );
        }

        return get_site_option( "mmplus_themes" );      

    }
}
if ( ! function_exists('mmplus_menu_save_themes') ) {
    /*
     * Save menu theme
     *
     * @since 2.3.7
     */
    function mmplus_menu_save_themes( $themes ) {

        if ( ! mmplus_share_themes_across_multisite() ) {
            return update_option( "mmplus_themes", $themes );
        }

        return update_site_option( "mmplus_themes", $themes );
        
    }
}
if ( ! function_exists('mmplus_menu_save_last_updated_theme') ) {
    /*
     * Save last updated theme
     *
     * @since 2.3.7
     */
    function mmplus_menu_save_last_updated_theme( $theme ) {

        if ( ! mmplus_share_themes_across_multisite() ) {
            return update_option( "mmplus_themes_last_updated", $theme );
        }

        return update_site_option( "mmplus_themes_last_updated", $theme );
        
    }
}

if ( ! function_exists('mmplus_get_active_caching_plugins') ) {

    /**
     * Return list of active caching/CDN/minification plugins
     *
     * @since 2.4
     * @return array
     */
    function mmplus_get_active_caching_plugins() {

        $caching_plugins = apply_filters("mmplus_caching_plugins", array(
            'litespeed-cache/litespeed-cache.php',
            'js-css-script-optimizer/js-css-script-optimizer.php',
            'merge-minify-refresh/merge-minify-refresh.php',
            'minify-html-markup/minify-html.php',
            'simple-cache/simple-cache.php',
            'w3-total-cache/w3-total-cache.php',
            'wp-fastest-cache/wpFastestCache.php',
            'wp-speed-of-light/wp-speed-of-light.php',
            'wp-super-cache/wp-cache.php',
            'wp-super-minify/wp-super-minify.php',
            'autoptimize/autoptimize.php',
            'bwp-minify/bwp-minify.php',
            'cache-enabler/cache-enabler.php',
            'cloudflare/cloudflare.php',
            'comet-cache/comet-cache.php',
            'css-optimizer/bpminifycss.php',
            'fast-velocity-minify/fvm.php',
            'hyper-cache/plugin.php',
            'remove-query-strings-littlebizzy/remove-query-strings.php',
            'remove-query-strings-from-static-resources/remove-query-strings.php',
            'query-strings-remover/query-strings-remover.php',
            'wp-rocket/wp-rocket.php',
            'hummingbird-performance/wp-hummingbird.php',
            'breeze/breeze.php'
        ));

        $active_plugins = array();

        foreach ( $caching_plugins as $plugin_path ) {
            if ( is_plugin_active( $plugin_path ) ) {
                $plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin_path );
                $active_plugins[] = $plugin_data['Name'];
            }
        }

        return $active_plugins;
    }
}
