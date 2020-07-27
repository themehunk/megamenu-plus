<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access.
}

if ( ! class_exists( 'MMPlus_Menu_Style_Manager' ) ) :

/**
 *
 */
final class MMPlus_Menu_Style_Manager {

    /**
     *
     */
    var $settings = array();


    /**
     * Constructor
     *
     * @since 1.0
     */
    public function __construct() {
        $this->settings = get_option( "mmplus_settings" );
    }

     /**
     * Return the default menu theme
     */
    public function mmplus_get_default_theme(){
        return apply_filters("mmplus_default_theme", array(
            'title'  => __("Default", "megamenu-plus"),
            'menu_item_link_height'  => '40',
            'menu_item_align'        => 'left',
            'menu_bg_color'          => '#fff',
            'menu_link_color'        => '#000',
            'menu_hvr_color'         => '#fff',
            'menu_link_bg_color'     => '#fff',
            'menu_link_hvr_bg_color' => 'rgba(24, 153, 255, 1)',
            'sub_menu_bg_color'      => 'rgba(235, 246, 255, 1)',
            'sub_menu_link_color'    => '#000',
            'sub_menu_hvr_color'     => '#fff',
            'sub_menu_hvr_bg_color'  => 'rgba(24, 153, 255, 1)',
            'menu_padding_left'      => '15',
            'menu_padding_right'     => '15',
            'menu_padding_top'       => '10',
            'menu_margin_left'      => '0',
            'menu_margin_right'     => '0',
            'menu_padding_bottom'                => '10',
            'menu_border_radius_top_left'        => '0',
            'menu_border_radius_top_right'       => '0',
            'menu_border_radius_bottom_right'    => '0',
            'menu_border_radius_bottom_left'     => '0',
            'responsive_breakpoint'              => '1024',
            'mobile_menu_item_align' => 'left',
            'toggle_text' => 'Menu',
            'toggle_text_clr' => '#fff',
            'toggle_bg_color' => 'rgba(24, 153, 255, 1)',
            'toggle_icon_clr' => '#fff',
            'toggle_bar_height' => '40',

            'mobile_menu_bg_color' => 'rgba(235, 246, 255, 1)',
            'mobile_menu_link_bg_color' => 'rgba(235, 246, 255, 1)',
            'mobile_menu_hvr_bg_color' => 'rgba(24, 153, 255, 1)',

            'mobile_menu_link_color' => '#000',
            'mobile_menu_hvr_link_color' => '#fff',

            'mobile_sub_menu_bg_link_color' => 'rgba(24, 153, 255, 1)',
            'mobile_sub_menu_bg_link_hvr_color' => 'rgba(24, 153, 255, 1)',
             'mobile_sub_menu_hide' => 'off',
            'mobile_sub_menu_link_color' => '#fff',
            'mobile_sub_menu_link_hvr_color' => '#000',

            'menu-dropdown-arrow' => 'f140',
            'sub-menu-dropdown-arrow' => 'f139',
            'mobile-menu-dropdown-arrow' => 'f140',
            'mobile-sub-menu-dropdown-arrow' => 'f142',

            'mobile-open-toggle-icon' => 'f333',
            'mobile-close-toggle-icon' => 'f153',

            'custom_css'=> '',
            
        ) );
    }

   /**
     *
     * @since 1.0
     */
    public function mmplus_default_themes() {

        $themes['default'] = $this->mmplus_get_default_theme();

        return apply_filters( "mmplus_themes", $themes );
    }



   /**
     * Merge the saved themes (from options table) into array of complete themes
     *
     * @since 2.1
     */
    private function mmplus_merge_in_saved_themes( $all_themes ) {

        if ( $saved_themes = mmplus_menu_get_themes() ) {

            foreach ( $saved_themes as $key => $settings ) {

                if ( isset( $all_themes[ $key ] ) ) {
                    // merge modifications to default themes
                    $all_themes[ $key ] = array_merge( $all_themes[ $key ], $saved_themes[ $key ] );
                } else {
                    // add in new themes
                    $all_themes[ $key ] = $settings;
                }

            }
        }

        return $all_themes;

    }
     /**
     * Populate all themes with all keys from the default theme
     *
     * @since 2.1
     */
    private function mmplus_ensure_all_themes_have_all_default_theme_settings( $all_themes ) {

        $default_theme = $this->mmplus_get_default_theme();

        $themes = array();

        foreach ( $all_themes as $theme_id => $theme ) {
            $themes[ $theme_id ] = array_merge( $default_theme, $theme );
        }

        return $themes;
    }

    /**
     * For backwards compatibility, copy old settings into new values
     *
     * @since 2.1
     */
    private function mmplus_process_theme_replacements( $all_themes ) {

        foreach ( $all_themes as $key => $settings ) {

            // process replacements
            foreach ( $settings as $var => $val ) {

                if ( ! is_array( $val ) && isset( $all_themes[$key][$val] ) ) {

                    $all_themes[$key][$var] = $all_themes[$key][$val];

                }

            }

        }

        return $all_themes;
    }
        /**
     * Returns the theme ID for a specified menu location, defaults to 'default'
     *
     * @since 2.1
     */
    private function mmplus_get_theme_id_for_location( $location ) {

        $settings = $this->settings;

        $theme_id = isset( $settings[ $location ]['theme'] ) ? $settings[ $location ]['theme'] : 'default';

        return $theme_id;

    }
   /**
     * Return a filtered list of themes
     *
     * @since 1.0
     * @return array
     */
    public function get_themes() {

        $mmplus_default_themes = $this->mmplus_default_themes();

        $all_themes = $this->mmplus_merge_in_saved_themes( $mmplus_default_themes );

        $all_themes = $this->mmplus_ensure_all_themes_have_all_default_theme_settings( $all_themes );

        $all_themes = $this->mmplus_process_theme_replacements( $all_themes );

        uasort( $all_themes, array( $this, 'mmplus_sort_by_title' ) );

        return $all_themes;

    }
    /**
     * Sorts a 2d array by the 'title' key
     *
     * @since 1.0
     * @param array $a
     * @param array $b
     */
    private function mmplus_sort_by_title( $a, $b ) {

        return strcmp( $a['title'], $b['title'] );

    }

   /**
     * Returns the theme settings for a specified location. Defaults to the default theme.
     *
     * @since 1.3
     */
    private function mmplus_get_theme_settings_for_location( $location ) {

        $theme_id = $this->mmplus_get_theme_id_for_location( $location );

        $all_themes = $this->get_themes();

        $theme_settings = isset( $all_themes[ $theme_id ] ) ? $all_themes[ $theme_id ] : $all_themes[ 'default' ];

        return $theme_settings;

    }


}

endif;