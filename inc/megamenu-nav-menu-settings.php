<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access.
}
class MMPlus_Nav_Menu_Settings {
	
	public function __construct() {
		add_action( 'load-nav-menus.php', array( $this, 'mmplus_add_metabox_to_nav_menu_settings' ) );
		add_action('wp_ajax_mmplus_nav_menu_save', array($this, 'mmplus_nav_menu_save'));
    }

	public function mmplus_add_metabox_to_nav_menu_settings() {
        add_meta_box( 'mmplus-nav-menu-metabox-set', __( 'Megamenu Plus Setting', 'megamenu-plus'), array( $this, 'mmplus_mmplus_themes_meta_box' ), 'nav-menus', 'side', 'high' );
    }

    public function mmplus_mmplus_themes_meta_box( ){ 
        include_once( MMPLUS_DIR . 'inc/megamenu-nav-menu-metadata.php' );
    }

    public function mmplus_nav_menu_save(){
        check_ajax_referer( 'mmplus_check_security', 'mmplus_nonce' );

        $menu_id = (int) sanitize_text_field($_POST['menu_id']);
        $mmth_settings_json_string = $_POST['mmth_settings'];
        $mmth_settings_array = json_decode( stripslashes( $mmth_settings_json_string ), true );

        $saved_settings = array();

            foreach ( $mmth_settings_array as $index => $value ) {
                $name = $value['name'];
    
            // find values between square brackets
                preg_match_all( "/\[(.*?)\]/", $name, $matches );

                if ( isset( $matches[1][0] ) && isset( $matches[1][1] ) ) {
                    $location = $matches[1][0];
                    $setting = $matches[1][1];

                    $saved_settings[$location][$setting] = $value['value'];
                    $saved_settings[$location]['menu_id'] = $menu_id;
                    
                }
            }

            if ( ! get_option( 'mmplus_options' ) ) {

                update_option( 'mmplus_options', $saved_settings );

            } else {

                
                $existing_settings = get_option( 'mmplus_options' );

                $new_settings = array_merge( $existing_settings, $saved_settings );

                update_option( 'mmplus_options', $new_settings );

            }

            
            $mmth_updated_option = get_option( 'mmplus_options' );

            
        wp_send_json_success( array( 'msg' => __( 'Settings saved.', 'megamenu-plus'), 
            'setting_data' => $mmth_settings_array,
            'mmth_updated_option' => $mmth_updated_option ) 
    );

    }
}
new MMPlus_Nav_Menu_Settings();