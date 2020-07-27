<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access.
}
/**
 * 
 */
class MMPLUS
{
	
	public function __construct(){
		add_filter( 'wp_nav_menu_args', array( $this, 'mmplus_modify_nav_menu_args' ), 99999 );
        add_filter( 'mmplus_nav_menu_css_class', array( $this, 'mmplus_prefix_menu_classes' ) );
        add_action( 'admin_footer', array( $this, 'mmplus_add_menu_settings_wrap_admin_footer' ) );
        add_filter( 'wp_nav_menu', array( $this, 'mmplus_add_responsive_toggle' ), 10, 2 );
	}
	   
    /**
     * Appends "mmplus-" to all menu classes.
     * This is to help avoid theme CSS conflicts.
     *
     * @since 1.0
     * @param array $classes
     * @return array
     */
    public function mmplus_prefix_menu_classes( $classes ) {
        $return = array();

        foreach ( $classes as $class ) {
            $return[] = 'mmplus-' . $class;
        }

        return $return;
    }

    /**
     * Use the Mega Menu walker to output the menu
     * Resets all parameters used in the wp_nav_menu call
     * Wraps the menu in mmth-mega-menu IDs and classes
     *
     * @since 1.0
     * @param $args array
     * @return array
     */
    public function mmplus_modify_nav_menu_args( $args ) {
       if ( ! isset( $args['theme_location'] ) ) {
            return $args;
        } 
        $menu_id      = '';
        $mmplus_options = get_option( 'mmplus_options' );
        $menu_id      = empty(  $mmplus_options[ $args['theme_location'] ]['menu_id'] ) ? '' :  $mmplus_options[ $args['theme_location'] ]['menu_id'];

        $current_theme_location = $args['theme_location'];
       if(isset($mmplus_options[ $current_theme_location ])){
           $menu_settings = $mmplus_options[ $current_theme_location ];
           
        }else{
           $menu_settings =''; 
        }
        if ( empty( $mmplus_options[ $args['theme_location'] ]['is_enabled'] ) || $mmplus_options[ $args['theme_location'] ]['is_enabled'] != '1' ) {
            return $args; 
        }  
        //Menu Option 
            $style_manager = new MMPlus_Menu_Style_Manager();
            $settings = $style_manager->get_themes();

            $last_updated = mmplus_menu_get_last_updated_theme();

            $preselected_theme = isset( $this->themes[ $last_updated ] ) ? $last_updated : 'default';

            $theme_id = isset( $_GET['theme'] ) ? sanitize_text_field( $_GET['theme'] ) : $preselected_theme;

            $responsive_breakpoint = $settings[ $theme_id ]['responsive_breakpoint'];
            $mobile_menu_item_align = $settings[ $theme_id ]['mobile_menu_item_align'];
            if($mobile_menu_item_align=='left'){
            $mobilepanalign='slide_left';
            }if($mobile_menu_item_align=='center'){
             $mobilepanalign='slide_center';   
            }if($mobile_menu_item_align=='right'){
             $mobilepanalign='slide_right';   
            }
            $mobile_sub_menu_hide = $settings[ $theme_id ]['mobile_sub_menu_hide'];

            $wrap_attributes = apply_filters("mmplus_wrap_attributes", array(
                "id" => '%1$s',
                "class" => '%2$s mega-no-js',
                "data-event" => 'hover_intent',
                "data-effect" => '',
                "data-effect-speed" => '',
                "data-effect-mobile" => $mobilepanalign,
                "data-effect-speed-mobile" =>'',
                "data-panel-width" => '',
                "data-panel-inner-width" => '',
                "data-mobile-force-width" => '',
                "data-second-click" => '',
                "data-document-click" => 'accordion',
                "data-mobile-hide-submenu" => $mobile_sub_menu_hide,
                "data-vertical-behaviour" => '',
                "data-breakpoint" => absint($responsive_breakpoint),
                "data-unbind" => '',
            ), $menu_id, $menu_settings, $mmplus_options, $current_theme_location );

         $attributes = "";

            foreach( $wrap_attributes as $attribute => $value ) {
                if ( strlen( $value ) ) {
                    $attributes .= " " . $attribute . '="' . esc_attr( $value ) . '"';
                }
            }
            $defaults = array(
                'menu'            => wp_get_nav_menu_object( $menu_id ),
                'theme_location'  => $args['theme_location'],
                'container'       => 'div',
                'container_class' => 'mmplus-megamenu-wrap',
                'container_id'    => 'mmplus-wrap-' . $args['theme_location'],
                'menu_class'      => 'mmplus-megamenu megamenu-plus megamenu-horizontal',
                'menu_id'         => 'mmplus-megamenu-' . $args['theme_location'],
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul id="%1$s" class="%2$s" ' . $attributes . '>%3$s</ul>',
                'depth'           => 0,
                'walker'          => new MMPlus_Walker()
            );

            $args = array_merge( $args, apply_filters( "mmplus_nav_menu_args", $defaults, $args['menu'], $args['theme_location'] ) );

        return $args;
    }    

    public function mmplus_add_menu_settings_wrap_admin_footer() {
        $current_screen = get_current_screen();
        if (property_exists($current_screen,'base')){
            if ($current_screen->base === 'nav-menus'){
                $html =  '<div id="mmplusSettingOverlay" style="display: none;"></div>         
                            <div class="megamenu-plus-item-settins-wrap" style="display: none;">
                                <input type="hidden" class="mmplus-megamenu-status-hidden" value="">
                                <div class="mmplus-item-settings-content">
                                </div>
                            </div>';
                echo $html;
            }
        }
    }



    /**
     * Add the html for the responsive toggle box to the menu
     *
     * @param string $nav_menu
     * @param object $args
     * @return string
     * @since 1.3
     */
 public function mmplus_add_responsive_toggle( $nav_menu, $args ) {

        $args = (object) $args;
        
        // make sure we're working with a Mega Menu
        if ( ! $args->walker || ! is_a( $args->walker, 'MMPlus_Walker' ) ) {
            return $nav_menu;
        }

       $find = 'class="' . $args->container_class . '">';

       $theme_id = mmplus_mmplus_get_theme_id_for_location( $args->theme_location );

       $content = "";

       $content = apply_filters( "mmplus_toggle_bar_content", $content, $nav_menu, $args, $theme_id );
       
       $replace = $find . '<div class="mega-menu-mmplus-toggle">'.$content .'</div>';

        return str_replace( $find, $replace, $nav_menu );
    }
    
}
new MMPLUS();