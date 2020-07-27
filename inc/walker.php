<?php
    /**
     * @package WordPress
     * @since 1.0.0
     * @uses Walker
     */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access.
}
class MMPlus_Walker extends Walker_Nav_Menu
{

    public $item_ID;
    public $isMegaMenu;
    /**
    * MMPlus_Style constructor.
   */
    

    public function MMPlus_Walker_option(){

         $mmplus_builder_options  = get_post_meta( $this->item_ID, 'mmplus_builder_options', true );
         return $mmplus_builder_options;        

    }
        /**)
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu() */

    public function start_lvl( &$output, $depth = 0, $args = array() ){
        $style = '';
        $data_alignment = '';
        $mmplus_endtoend = '';
        $stylemegamenu = '';
        $st_megamenu ='';
  
        if ( $this->isMegaMenu == 'active' && $depth == 0 ) {
            $mmplus_builder_options  = get_post_meta( $this->item_ID, 'mmplus_builder_options', true );
         
            $mmplus_width = isset($mmplus_builder_options['mmplus_width']) ? "width:{$mmplus_builder_options['mmplus_width']};" : '';
            $mmplus_bg_color = isset($mmplus_builder_options['mmplus_bg_color']) ? $mmplus_builder_options['mmplus_bg_color'] : '';
         
            $mmplus_bg_image = isset($mmplus_builder_options['mmplus_bg_image']) ? "background-image:url({$mmplus_builder_options['mmplus_bg_image']});" : '';
            // mega-menu-option
            $mmth_pannel_alignment = isset($mmplus_builder_options['mmth_pannel_alignment']) ? $mmplus_builder_options['mmth_pannel_alignment']: '';
            //pan padding
            $mmplus_mega_pannel_padding_top = isset($mmplus_builder_options['mmplus_mega_pannel_padding_top']) ? "padding-top:{$mmplus_builder_options['mmplus_mega_pannel_padding_top']}px;":'';
            $mmplus_mega_pannel_padding_right = isset($mmplus_builder_options['mmplus_mega_pannel_padding_right']) ? "padding-right:{$mmplus_builder_options['mmplus_mega_pannel_padding_right']}px;":'';
            $mmplus_mega_pannel_padding_bottom = isset($mmplus_builder_options['mmplus_mega_pannel_padding_bottom']) ? "padding-bottom:{$mmplus_builder_options['mmplus_mega_pannel_padding_bottom']}px;":'';
            $mmplus_mega_pannel_padding_left = isset($mmplus_builder_options['mmplus_mega_pannel_padding_left']) ? "padding-left:{$mmplus_builder_options['mmplus_mega_pannel_padding_left']}px;":'';
            //border-color
            $mmplus_border_color = isset($mmplus_builder_options['mmplus_border_color']) ? "border-color:{$mmplus_builder_options['mmplus_border_color']};" : '';
            $mmplus_mega_pannel_border_top = isset($mmplus_builder_options['mmplus_mega_pannel_border_top']) ? "border-top-width:{$mmplus_builder_options['mmplus_mega_pannel_border_top']}px;":'';
            $mmplus_mega_pannel_border_right = isset($mmplus_builder_options['mmplus_mega_pannel_border_right']) ? "border-right-width:{$mmplus_builder_options['mmplus_mega_pannel_border_right']}px;":'';
            $mmplus_mega_pannel_border_bottom = isset($mmplus_builder_options['mmplus_mega_pannel_border_bottom']) ? "border-bottom-width:{$mmplus_builder_options['mmplus_mega_pannel_border_bottom']}px;":'';
            $mmplus_mega_pannel_border_left = isset($mmplus_builder_options['mmplus_mega_pannel_border_left']) ? "border-left-width:{$mmplus_builder_options['mmplus_mega_pannel_border_left']}px;":'';
            // border-radius
            $mmplus_mega_pannel_raidus_top_left = isset($mmplus_builder_options['mmplus_mega_pannel_raidus_top_left']) ? "border-top-left-radius:{$mmplus_builder_options['mmplus_mega_pannel_raidus_top_left']}px;" : '';
            $mmplus_mega_pannel_raidus_top_right = isset($mmplus_builder_options['mmplus_mega_pannel_raidus_top_right']) ? "border-top-right-radius:{$mmplus_builder_options['mmplus_mega_pannel_raidus_top_right']}px;" : '';
            $mmplus_mega_pannel_raidus_bottom_right = isset($mmplus_builder_options['mmplus_mega_pannel_raidus_bottom_right']) ? "border-bottom-right-radius:{$mmplus_builder_options['mmplus_mega_pannel_raidus_bottom_right']}px;" : '';
            $mmplus_mega_pannel_raidus_bottom_left = isset($mmplus_builder_options['mmplus_mega_pannel_raidus_bottom_left']) ? "border-bottom-left-radius:{$mmplus_builder_options['mmplus_mega_pannel_raidus_bottom_left']}px;" : '';
            // color
            $mmplus_mmplus_widget_title_color = isset($mmplus_builder_options['mmplus_mmplus_widget_title_color']) ? $mmplus_builder_options['mmplus_mmplus_widget_title_color'] : '';
            $mmplus_megamenu_widget_text_color = isset($mmplus_builder_options['mmplus_megamenu_widget_text_color']) ? $mmplus_builder_options['mmplus_megamenu_widget_text_color'] : '';
            $mmplus_megamenu_widget_link_color = isset($mmplus_builder_options['mmplus_megamenu_widget_link_color']) ? $mmplus_builder_options['mmplus_megamenu_widget_link_color']: '';
            $mmplus_megamenu_widget_linkhvr_color = isset($mmplus_builder_options['mmplus_megamenu_widget_linkhvr_color']) ? $mmplus_builder_options['mmplus_megamenu_widget_linkhvr_color'] : '';
            $mmplus_widget_content_alignment = isset($mmplus_builder_options['mmplus_widget_content_alignment']) ? $mmplus_builder_options['mmplus_widget_content_alignment'] : 'left';
            // coloum
            $mmplus_mega_column_padding_top = isset($mmplus_builder_options['mmplus_mega_column_padding_top']) ? $mmplus_builder_options['mmplus_mega_column_padding_top'] : '';
            $mmplus_mega_column_padding_right = isset($mmplus_builder_options['mmplus_mega_column_padding_right']) ? $mmplus_builder_options['mmplus_mega_column_padding_right'] : '';
            $mmplus_mega_column_padding_left = isset($mmplus_builder_options['mmplus_mega_column_padding_left']) ? $mmplus_builder_options['mmplus_mega_column_padding_left'] : '';
            $mmplus_mega_column_padding_bottom = isset($mmplus_builder_options['mmplus_mega_column_padding_bottom']) ? $mmplus_builder_options['mmplus_mega_column_padding_bottom'] : '';

            $mmplus_mmplus_widget_title_color = isset($mmplus_builder_options['mmplus_mmplus_widget_title_color']) ? $mmplus_builder_options['mmplus_mmplus_widget_title_color'] : '';

            $data_alignment = $mmth_pannel_alignment;

            $mmplus_endtoend1= isset($mmplus_builder_options['mmplus_endtoend']) ? $mmplus_builder_options['mmplus_endtoend']: '';
            $mmplus_endtoend = $mmplus_endtoend1;

            $style = 'style="'. $mmplus_width . esc_attr($mmplus_bg_image) . esc_attr( $mmplus_mega_pannel_padding_top) . esc_attr( $mmplus_mega_pannel_padding_right) . esc_attr( $mmplus_mega_pannel_padding_bottom) . esc_attr( $mmplus_mega_pannel_padding_left) . esc_attr($mmplus_border_color) . esc_attr($mmplus_mega_pannel_border_top) . esc_attr($mmplus_mega_pannel_border_right) . esc_attr($mmplus_mega_pannel_border_bottom) . esc_attr($mmplus_mega_pannel_border_left) . esc_attr($mmplus_mega_pannel_raidus_top_left) . esc_attr($mmplus_mega_pannel_raidus_top_right) . esc_attr($mmplus_mega_pannel_raidus_bottom_right) . esc_attr($mmplus_mega_pannel_raidus_bottom_left) .'"';

            $st_megamenu.="#mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mega-sub-menu-mmplus.depth-0:before{
                content:'';
                position:absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background:{$mmplus_bg_color};
            }
            #mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmplus-col{
               padding-top:{$mmplus_mega_column_padding_top}px;
               padding-bottom:{$mmplus_mega_column_padding_bottom}px;
               padding-left:{$mmplus_mega_column_padding_left}px;
               padding-right:{$mmplus_mega_column_padding_right}px;
            }
            #mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget .mmplus-item-title{
               color:{$mmplus_mmplus_widget_title_color}!important;
            }
            #mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget,#mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget p,#mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget h1,#mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget h2,#mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget h3,#mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget h4,#mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget h5, #mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget h6, #mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget span{
               color:{$mmplus_megamenu_widget_text_color}!important;
           }
           #mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget a{
               color:{$mmplus_megamenu_widget_link_color}!important;
           }
           #mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget a:hover{
               color:{$mmplus_megamenu_widget_linkhvr_color}!important;
           }
        ";

        if( $mmplus_widget_content_alignment=='left'){
        $st_megamenu.="#mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget{text-align:left!important}";
        }elseif( $mmplus_widget_content_alignment=='center'){
        $st_megamenu.="#mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget{text-align:center!important}";
        }elseif( $mmplus_widget_content_alignment=='right'){
        $st_megamenu.="#mmplus-menu-item-$this->item_ID.mmplus-is-megamenu .mmplus-mmth-type-widget{text-align:right!important}";
        }
        $stylemegamenu.="<style type='text/css'>";
        $stylemegamenu.= $st_megamenu;
        $stylemegamenu.="</style>";
        echo $stylemegamenu;

        }
        // $this->mmplus_megamenu_render_css($stylemegamenu);  
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"mega-sub-menu-mmplus depth-$depth  $data_alignment $mmplus_endtoend \" $style  >\n";    
        
        
    }
    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * Custom walker. Add the widgets into the menu.
     *
     * @see Walker::start_el()
     *
     * @since 1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $this->item_ID = $item->ID;

        $this->item_layout  = get_post_meta( $item->ID, 'mmplus_layout', true );

        $this->isMegaMenu   = get_post_meta( $item->ID, 'mmplus_item_megamenu_status', true );


        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $li_attributes = '';
        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;

        if ( $this->isMegaMenu == 'active' && $depth == 0 ) {
            array_push( $classes, 'is-megamenu' );
            array_push( $classes, 'menu-item-has-children' );
        }

        $class_names = implode(' ', apply_filters('mmplus_nav_menu_css_class', array_filter($classes), $item, $args));
        // these classes are prepended with 'mega-'
        $mega_classes = explode( ' ',$class_names);


        $class_names = ' class="'.esc_attr($class_names).'"';
         
        $id = apply_filters('nav_menu_item_id', 'mmplus-menu-item-'.$item->ID, $item, $args);
        $id = strlen($id) ? ' id="'.esc_attr($id).'"' : '';

        $output .= $indent.'<li'.$id.$value.$class_names.$li_attributes.'>';

        $attributes  = !empty($item->attr_title) ? ' title="'.esc_attr($item->attr_title).'"' : '';
        $attributes .= !empty($item->target) ? ' target="'.esc_attr($item->target).'"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="'.esc_attr($item->xfn).'"' : '';
        $attributes .= !empty($item->url) ? ' href="'.esc_attr($item->url).'"' : '';
        $attributes .= ($args->has_children) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

       
        $item_output = $args->before;
        
        $item_output = '';
        if ( $item->type == 'widget'){
            $item_output = $item->output;
        }


        if ( $item->type != 'widget'){

            $mmth_icon = '';
            if (  ( $depth == 0 ) && $args->has_children ) {
                $mmplus_builder_options  = get_post_meta( $item->ID, 'mmplus_builder_options', true );
                $mmth_icon .= isset( $mmplus_builder_options['icon'] ) ? "<span class='mmth-selected-icon'><i class='{$mmplus_builder_options['icon']}'></i></span>" : '';
            }
            if ( isset( $atts['class'] ) && strlen( $atts['class'] ) ){
                $atts['class'] = $atts['class'] . 'mmplus-menu-link';
            } else {
                $atts['class'] = 'mmplus-menu-link';
            } 
            $atts['href'] = ! empty( $item->url ) ? $item->url : '';

              if ( is_array( $classes ) && in_array( 'menu-item-has-children', $classes )) {

                $atts['aria-haspopup'] = "true"; // required for Surface/Win10/Edge
                $atts['aria-expanded'] = "false";

                if ( is_array( $mega_classes ) && in_array( 'mega-toggle-on', $mega_classes ) ) {
                    $atts['aria-expanded'] = "true";
                }

                
            }
           if ( $depth == 0 ) {
                $atts['tabindex'] = "0";
            }

            
            if ( isset( $settings['hide_text'] ) && $settings['hide_text'] == 'true' ) {
                $atts['aria-label'] = $item->title;
            } 
            
            $attributes = '';

            foreach ( $atts as $attr => $value ) {
                if ( strlen( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }
            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= ( ( $depth == 0 ) && $args->has_children) ? $mmth_icon : '';
            if ( is_array( $classes ) && in_array('icon-top', $classes ) ) {
               $item_output .= "<span class='mega-title-below'>";
            }

            if ( isset( $settings['hide_text'] ) && $settings['hide_text'] == 'true' ) {
                /** This filter is documented in wp-includes/post-template.php */
            } else if ( property_exists( $item, 'mega_description' ) && strlen( $item->mega_description ) ) {
                $item_output .= '<span class="mega-description-group"><span class="mega-menu-title">' . $args->link_before . apply_filters( 'mmplus_the_title', $item->title, $item->ID ) . $args->link_after . '</span><span class="mega-menu-description">' . $item->description . '</span></span>';
            } else {
                $item_output .= $args->link_before . apply_filters( 'mmplus_the_title', $item->title, $item->ID ) . $args->link_after;
            }

            if ( is_array( $classes ) && in_array( 'icon-top', $classes ) ) {
                $item_output .= "</span>";
            }

            if ( is_array( $classes ) && in_array( 'menu-item-has-children', $classes ) ) {
                $item_output .= '<span class="mega-indicator"></span>';
            }
            
            $item_output .= '</a>';
            $item_output .= $args->after;

            if ( is_array( $classes ) && ( in_array( "menu-column", $classes ) || in_array( "menu-row", $classes ) ) ) {
                
                $item_output = "";
            }
        }
        $item_output .= $args->after;
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @since 1.7
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>"; // remove new line to remove the 4px gap between menu items
    }

    /**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max
     * depth and no ignore elements under that depth. It is possible to set the
     * max depth to include all depths, see walk() method.
     *
     * This method should not be called directly, use the walk() method instead.
     *
     * @since 2.5.0
     *
     * @param object $element           Data object.
     * @param array  $children_elements List of elements to continue traversing (passed by reference).
     * @param int    $max_depth         Max depth to traverse.
     * @param int    $depth             Depth of current element.
     * @param array  $args              An array of arguments.
     * @param string $output            Used to append additional content (passed by reference).
     */

    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if (!$element) {
            return;
        }

        $id_field = $this->db_fields['id'];
        $id = $element->$id_field;

        //display this element
        if (is_array($args[0])) {
            $args[0]['has_children'] = !empty($children_elements[$id]);
        } elseif (is_object($args[0])) {
            $args[0]->has_children = !empty($children_elements[$id]);
        }

        $cb_args = array_merge(array(&$output, $element, $depth), $args);

        call_user_func_array(array(&$this, 'start_el'), $cb_args);

        // descend only when the depth is right and there are childrens for this element
        if (($max_depth == 0 || $max_depth > $depth + 1) && isset($children_elements[$id])) {
            foreach ($children_elements[ $id ] as $child) {
                if (!isset($newlevel)) {
                    $newlevel = true;
              //start the child delimiter
              $cb_args = array_merge(array(&$output, $depth), $args);
                    call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                }
                $this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
            }
            unset($children_elements[ $id ]);
        }

        if (isset($newlevel) && $newlevel) {
            //end the child delimiter
          $cb_args = array_merge(array(&$output, $depth), $args);
            call_user_func_array(array(&$this, 'end_lvl'), $cb_args);

        }

        //end this element
        $cb_args = array_merge(array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'end_el'), $cb_args);
    }
}
