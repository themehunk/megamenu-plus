<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access.
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
            'dashicons-menu' => __('Menu', 'mmplus'),
            'dashicons-dashboard' => __('Dashboard', 'mmplus'),
            'dashicons-admin-site' => __('Admin Site', 'mmplus'),
            'dashicons-admin-media' => __('Admin Media', 'mmplus'),
            'dashicons-admin-page' => __('Admin Page', 'mmplus'),
            'dashicons-admin-comments' => __('Admin Comments', 'mmplus'),
            'dashicons-admin-appearance' => __('Admin Appearance', 'mmplus'),
            'dashicons-admin-plugins' => __('Admin Plugins', 'mmplus'),
            'dashicons-admin-users' => __('Admin Users', 'mmplus'),
            'dashicons-admin-tools' => __('Admin Tools', 'mmplus'),
            'dashicons-admin-settings' => __('Admin Settings', 'mmplus'),
            'dashicons-admin-network' => __('Admin Network', 'mmplus'),
            'dashicons-admin-generic' => __('Admin Generic', 'mmplus'),
            'dashicons-admin-home' => __('Admin Home', 'mmplus'),
            'dashicons-admin-collapse' => __('Admin Collapse', 'mmplus'),
            'dashicons-admin-links' => __('Admin Links', 'mmplus'),
            'dashicons-admin-post' => __('Admin Post', 'mmplus'),
            'dashicons-format-standard' => __('Admin Plugins', 'mmplus'),
            'dashicons-format-image' => __('Image Post Format', 'mmplus'),
            'dashicons-format-gallery' => __('Gallery Post Format', 'mmplus'),
            'dashicons-format-audio' => __('Audio Post Format', 'mmplus'),
            'dashicons-format-video' => __('Video Post Format', 'mmplus'),
            'dashicons-format-links' => __('Link Post Format', 'mmplus'),
            'dashicons-format-chat' => __('Chat Post Format', 'mmplus'),
            'dashicons-format-status' => __('Status Post Format', 'mmplus'),
            'dashicons-format-aside' => __('Aside Post Format', 'mmplus'),
            'dashicons-format-quote' => __('Quote Post Format', 'mmplus'),
            'dashicons-welcome-write-blog' => __('Welcome Write Blog', 'mmplus'),
            'dashicons-welcome-edit-page' => __('Welcome Edit Page', 'mmplus'),
            'dashicons-welcome-add-page' => __('Welcome Add Page', 'mmplus'),
            'dashicons-welcome-view-site' => __('Welcome View Site', 'mmplus'),
            'dashicons-welcome-widgets-menus' => __('Welcome Widget Menus', 'mmplus'),
            'dashicons-welcome-comments' => __('Welcome Comments', 'mmplus'),
            'dashicons-welcome-learn-more' => __('Welcome Learn More', 'mmplus'),
            'dashicons-image-crop' => __('Image Crop', 'mmplus'),
            'dashicons-image-rotate-left' => __('Image Rotate Left', 'mmplus'),
            'dashicons-image-rotate-right' => __('Image Rotate Right', 'mmplus'),
            'dashicons-image-flip-vertical' => __('Image Flip Vertical', 'mmplus'),
            'dashicons-image-flip-horizontal' => __('Image Flip Horizontal', 'mmplus'),
            'dashicons-undo' => __('Undo', 'mmplus'),
            'dashicons-redo' => __('Redo', 'mmplus'),
            'dashicons-editor-bold' => __('Editor Bold', 'mmplus'),
            'dashicons-editor-italic' => __('Editor Italic', 'mmplus'),
            'dashicons-editor-ul' => __('Editor UL', 'mmplus'),
            'dashicons-editor-ol' => __('Editor OL', 'mmplus'),
            'dashicons-editor-quote' => __('Editor Quote', 'mmplus'),
            'dashicons-editor-alignleft' => __('Editor Align Left', 'mmplus'),
            'dashicons-editor-aligncenter' => __('Editor Align Center', 'mmplus'),
            'dashicons-editor-alignright' => __('Editor Align Right', 'mmplus'),
            'dashicons-editor-insertmore' => __('Editor Insert More', 'mmplus'),
            'dashicons-editor-spellcheck' => __('Editor Spell Check', 'mmplus'),
            'dashicons-editor-distractionfree' => __('Editor Distraction Free', 'mmplus'),
            'dashicons-editor-expand' => __('Editor Expand', 'mmplus'),
            'dashicons-editor-contract' => __('Editor Contract', 'mmplus'),
            'dashicons-editor-kitchensink' => __('Editor Kitchen Sink', 'mmplus'),
            'dashicons-editor-underline' => __('Editor Underline', 'mmplus'),
            'dashicons-editor-justify' => __('Editor Justify', 'mmplus'),
            'dashicons-editor-textcolor' => __('Editor Text Colour', 'mmplus'),
            'dashicons-editor-paste-word' => __('Editor Paste Word', 'mmplus'),
            'dashicons-editor-paste-text' => __('Editor Paste Text', 'mmplus'),
            'dashicons-editor-removeformatting' => __('Editor Remove Formatting', 'mmplus'),
            'dashicons-editor-video' => __('Editor Video', 'mmplus'),
            'dashicons-editor-customchar' => __('Editor Custom Character', 'mmplus'),
            'dashicons-editor-outdent' => __('Editor Outdent', 'mmplus'),
            'dashicons-editor-indent' => __('Editor Indent', 'mmplus'),
            'dashicons-editor-help' => __('Editor Help', 'mmplus'),
            'dashicons-editor-strikethrough' => __('Editor Strikethrough', 'mmplus'),
            'dashicons-editor-unlink' => __('Editor Unlink', 'mmplus'),
            'dashicons-editor-rtl' => __('Editor RTL', 'mmplus'),
            'dashicons-editor-break' => __('Editor Break', 'mmplus'),
            'dashicons-editor-code' => __('Editor Code', 'mmplus'),
            'dashicons-editor-paragraph' => __('Editor Paragraph', 'mmplus'),
            'dashicons-align-left' => __('Align Left', 'mmplus'),
            'dashicons-align-right' => __('Align Right', 'mmplus'),
            'dashicons-align-center' => __('Align Center', 'mmplus'),
            'dashicons-align-none' => __('Align None', 'mmplus'),
            'dashicons-lock' => __('Lock', 'mmplus'),
            'dashicons-calendar' => __('Calendar', 'mmplus'),
            'dashicons-visibility' => __('Visibility', 'mmplus'),
            'dashicons-post-status' => __('Post Status', 'mmplus'),
            'dashicons-edit' => __('Edit', 'mmplus'),
            'dashicons-post-trash' => __('Post Trash', 'mmplus'),
            'dashicons-trash' => __('Trash', 'mmplus'),
            'dashicons-external' => __('External', 'mmplus'),
            'dashicons-arrow-up' => __('Arrow Up', 'mmplus'),
            'dashicons-arrow-down' => __('Arrow Down', 'mmplus'),
            'dashicons-arrow-left' => __('Arrow Left', 'mmplus'),
            'dashicons-arrow-right' => __('Arrow Right', 'mmplus'),
            'dashicons-arrow-up-alt' => __('Arrow Up (alt)', 'mmplus'),
            'dashicons-arrow-down-alt' => __('Arrow Down (alt)', 'mmplus'),
            'dashicons-arrow-left-alt' => __('Arrow Left (alt)', 'mmplus'),
            'dashicons-arrow-right-alt' => __('Arrow Right (alt)', 'mmplus'),
            'dashicons-arrow-up-alt2' => __('Arrow Up (alt 2)', 'mmplus'),
            'dashicons-arrow-down-alt2' => __('Arrow Down (alt 2)', 'mmplus'),
            'dashicons-arrow-left-alt2' => __('Arrow Left (alt 2)', 'mmplus'),
            'dashicons-arrow-right-alt2' => __('Arrow Right (alt 2)', 'mmplus'),
            'dashicons-leftright' => __('Arrow Left-Right', 'mmplus'),
            'dashicons-sort' => __('Sort', 'mmplus'),
            'dashicons-randomize' => __('Randomise', 'mmplus'),
            'dashicons-list-view' => __('List View', 'mmplus'),
            'dashicons-exerpt-view' => __('Excerpt View', 'mmplus'),
            'dashicons-hammer' => __('Hammer', 'mmplus'),
            'dashicons-art' => __('Art', 'mmplus'),
            'dashicons-migrate' => __('Migrate', 'mmplus'),
            'dashicons-performance' => __('Performance', 'mmplus'),
            'dashicons-universal-access' => __('Universal Access', 'mmplus'),
            'dashicons-universal-access-alt' => __('Universal Access (alt)', 'mmplus'),
            'dashicons-tickets' => __('Tickets', 'mmplus'),
            'dashicons-nametag' => __('Name Tag', 'mmplus'),
            'dashicons-clipboard' => __('Clipboard', 'mmplus'),
            'dashicons-heart' => __('Heart', 'mmplus'),
            'dashicons-megaphone' => __('Megaphone', 'mmplus'),
            'dashicons-schedule' => __('Schedule', 'mmplus'),
            'dashicons-wordpress' => __('WordPress', 'mmplus'),
            'dashicons-wordpress-alt' => __('WordPress (alt)', 'mmplus'),
            'dashicons-pressthis' => __('Press This', 'mmplus'),
            'dashicons-update' => __('Update', 'mmplus'),
            'dashicons-screenoptions' => __('Screen Options', 'mmplus'),
            'dashicons-info' => __('Info', 'mmplus'),
            'dashicons-cart' => __('Cart', 'mmplus'),
            'dashicons-feedback' => __('Feedback', 'mmplus'),
            'dashicons-cloud' => __('Cloud', 'mmplus'),
            'dashicons-translation' => __('Translation', 'mmplus'),
            'dashicons-tag' => __('Tag', 'mmplus'),
            'dashicons-category' => __('Category', 'mmplus'),
            'dashicons-archive' => __('Archive', 'mmplus'),
            'dashicons-tagcloud' => __('Tag Cloud', 'mmplus'),
            'dashicons-text' => __('Text', 'mmplus'),
            'dashicons-media-archive' => __('Media Archive', 'mmplus'),
            'dashicons-media-audio' => __('Media Audio', 'mmplus'),
            'dashicons-media-code' => __('Media Code)', 'mmplus'),
            'dashicons-media-default' => __('Media Default', 'mmplus'),
            'dashicons-media-document' => __('Media Document', 'mmplus'),
            'dashicons-media-interactive' => __('Media Interactive', 'mmplus'),
            'dashicons-media-spreadsheet' => __('Media Spreadsheet', 'mmplus'),
            'dashicons-media-text' => __('Media Text', 'mmplus'),
            'dashicons-media-video' => __('Media Video', 'mmplus'),
            'dashicons-playlist-audio' => __('Audio Playlist', 'mmplus'),
            'dashicons-playlist-video' => __('Video Playlist', 'mmplus'),
            'dashicons-yes' => __('Yes', 'mmplus'),
            'dashicons-no' => __('No', 'mmplus'),
            'dashicons-no-alt' => __('No (alt)', 'mmplus'),
            'dashicons-plus' => __('Plus', 'mmplus'),
            'dashicons-plus-alt' => __('Plus (alt)', 'mmplus'),
            'dashicons-minus' => __('Minus', 'mmplus'),
            'dashicons-dismiss' => __('Dismiss', 'mmplus'),
            'dashicons-marker' => __('Marker', 'mmplus'),
            'dashicons-star-filled' => __('Star Filled', 'mmplus'),
            'dashicons-star-half' => __('Star Half', 'mmplus'),
            'dashicons-star-empty' => __('Star Empty', 'mmplus'),
            'dashicons-flag' => __('Flag', 'mmplus'),
            'dashicons-share' => __('Share', 'mmplus'),
            'dashicons-share1' => __('Share 1', 'mmplus'),
            'dashicons-share-alt' => __('Share (alt)', 'mmplus'),
            'dashicons-share-alt2' => __('Share (alt 2)', 'mmplus'),
            'dashicons-twitter' => __('twitter', 'mmplus'),
            'dashicons-rss' => __('RSS', 'mmplus'),
            'dashicons-email' => __('Email', 'mmplus'),
            'dashicons-email-alt' => __('Email (alt)', 'mmplus'),
            'dashicons-facebook' => __('Facebook', 'mmplus'),
            'dashicons-facebook-alt' => __('Facebook (alt)', 'mmplus'),
            'dashicons-networking' => __('Networking', 'mmplus'),
            'dashicons-googleplus' => __('Google+', 'mmplus'),
            'dashicons-location' => __('Location', 'mmplus'),
            'dashicons-location-alt' => __('Location (alt)', 'mmplus'),
            'dashicons-camera' => __('Camera', 'mmplus'),
            'dashicons-images-alt' => __('Images', 'mmplus'),
            'dashicons-images-alt2' => __('Images Alt', 'mmplus'),
            'dashicons-video-alt' => __('Video (alt)', 'mmplus'),
            'dashicons-video-alt2' => __('Video (alt 2)', 'mmplus'),
            'dashicons-video-alt3' => __('Video (alt 3)', 'mmplus'),
            'dashicons-vault' => __('Vault', 'mmplus'),
            'dashicons-shield' => __('Shield', 'mmplus'),
            'dashicons-shield-alt' => __('Shield (alt)', 'mmplus'),
            'dashicons-sos' => __('SOS', 'mmplus'),
            'dashicons-search' => __('Search', 'mmplus'),
            'dashicons-slides' => __('Slides', 'mmplus'),
            'dashicons-analytics' => __('Analytics', 'mmplus'),
            'dashicons-chart-pie' => __('Pie Chart', 'mmplus'),
            'dashicons-chart-bar' => __('Bar Chart', 'mmplus'),
            'dashicons-chart-line' => __('Line Chart', 'mmplus'),
            'dashicons-chart-area' => __('Area Chart', 'mmplus'),
            'dashicons-groups' => __('Groups', 'mmplus'),
            'dashicons-businessman' => __('Businessman', 'mmplus'),
            'dashicons-id' => __('ID', 'mmplus'),
            'dashicons-id-alt' => __('ID (alt)', 'mmplus'),
            'dashicons-products' => __('Products', 'mmplus'),
            'dashicons-awards' => __('Awards', 'mmplus'),
            'dashicons-forms' => __('Forms', 'mmplus'),
            'dashicons-testimonial' => __('Testimonial', 'mmplus'),
            'dashicons-portfolio' => __('Portfolio', 'mmplus'),
            'dashicons-book' => __('Book', 'mmplus'),
            'dashicons-book-alt' => __('Book (alt)', 'mmplus'),
            'dashicons-download' => __('Download', 'mmplus'),
            'dashicons-upload' => __('Upload', 'mmplus'),
            'dashicons-backup' => __('Backup', 'mmplus'),
            'dashicons-clock' => __('Clock', 'mmplus'),
            'dashicons-lightbulb' => __('Lightbulb', 'mmplus'),
            'dashicons-microphone' => __('Microphone', 'mmplus'),
            'dashicons-desktop' => __('Desktop', 'mmplus'),
            'dashicons-tablet' => __('Tablet', 'mmplus'),
            'dashicons-smartphone' => __('Smartphone', 'mmplus'),
            'dashicons-smiley' => __('Smiley', 'mmplus')
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
