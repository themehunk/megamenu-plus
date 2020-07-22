<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}
/**
 * Class MMPlus_Style
 */
if ( ! class_exists('MMPlus_Style')) {

    class MMPlus_Style{

        public $mmplus_nav_wrapper_class;
        public $mmplus_nav_wrapper_id;
        public $mmplus_nav_menu_id;
       /**
         * MMPlus_Style constructor.
         */
        public function __construct(){
            $this->mmplus_nav_wrapper_class = '.mmplus-megamenu-wrap';
            $this->mmplus_nav_wrapper_id = '#mmplus-wrap';
            $this->mmplus_nav_menu_id = '#mmplus-megamenu';

            add_action( 'wp_head', array( $this, 'render_css' ) );
        }    

        public function css(){
            $nav_class = $this->mmplus_nav_wrapper_class;
            $navbar_id = $this->mmplus_nav_wrapper_id;

            //Get all integrated Nav
            $mmplus_nav_locations = get_nav_menu_locations();

	        $mmplus_options = get_option('mmplus_options');
               
            $style = "";

            if (is_array($mmplus_nav_locations) && count($mmplus_nav_locations)) {
                foreach ( $mmplus_nav_locations as $nav_location => $nav_id ) {

	                	if ( !empty( $mmplus_options[ $nav_location ]['is_enabled'] ) && $mmplus_options[ $nav_location ]['is_enabled'] == '1' ) {
                      		$style .= $this->mmplus_generateCss( $nav_location );				            
				        }                
                }
            }

            return $style;
        }   
       /**
         * @param $nav_location
         *
         * @return string
         *
         * Main CSS Generate Method
         */
        public function mmplus_generateCss( $nav_location ){

            $nav_wrapper_id = $this->mmplus_nav_wrapper_id;

            $style = '';
      
          	$nav_wrapper_id = $nav_wrapper_id . '-' . $nav_location;
          	$mmplus_nav_menu_id = $this->mmplus_nav_menu_id . '-' . $nav_location;
            //Menu Option 
             $style_manager = new MMPlus_Menu_Style_Manager();

             
             $settings = $style_manager->get_themes();

             $last_updated = mmplus_menu_get_last_updated_theme();

             $preselected_theme = isset( $this->themes[ $last_updated ] ) ? $last_updated : 'default';

             $theme_id = isset( $_GET['theme'] ) ? sanitize_text_field( $_GET['theme'] ) : $preselected_theme;

            $menu_item_link_height = $settings[ $theme_id ]['menu_item_link_height'].'px';
            $menu_item_align       = $settings[ $theme_id ]['menu_item_align'];
            $menu_bg_color         = $settings[ $theme_id ]['menu_bg_color'];
            $menu_link_color       = $settings[ $theme_id ]['menu_link_color'];
            $menu_hvr_color        = $settings[ $theme_id ]['menu_hvr_color'];
            $menu_link_bg_color    = $settings[ $theme_id ]['menu_link_bg_color'];
            $menu_link_hvr_bg_color= $settings[ $theme_id ]['menu_link_hvr_bg_color'];
 
            //sub menu
            $sub_menu_bg_color         = $settings[ $theme_id ]['sub_menu_bg_color'];
            $sub_menu_link_color       = $settings[ $theme_id ]['sub_menu_link_color'];
            $sub_menu_hvr_color        = $settings[ $theme_id ]['sub_menu_hvr_color'];
            $sub_menu_hvr_bg_color     = $settings[ $theme_id ]['sub_menu_hvr_bg_color'];

            //menu padding
            $menu_padding_top      = $settings[ $theme_id ]['menu_padding_top'].'px';
            $menu_padding_right    = $settings[ $theme_id ]['menu_padding_right'].'px';
            $menu_padding_bottom   = $settings[ $theme_id ]['menu_padding_bottom'].'px';
            $menu_padding_left     = $settings[ $theme_id ]['menu_padding_left'].'px';

            //menu right
            $menu_margin_left      = $settings[ $theme_id ]['menu_margin_left'].'px';
            $menu_margin_right     = $settings[ $theme_id ]['menu_margin_right'].'px';

            //border radius
            $menu_border_radius_top_left       = $settings[ $theme_id ]['menu_border_radius_top_left'].'px';
            $menu_border_radius_top_right      = $settings[ $theme_id ]['menu_border_radius_top_right'].'px';
            $menu_border_radius_bottom_right   = $settings[ $theme_id ]['menu_border_radius_bottom_right'].'px';
            $menu_border_radius_bottom_left    = $settings[ $theme_id ]['menu_border_radius_bottom_left'].'px';

            // mobile menu
            
            $responsive_breakpoint     = $settings[ $theme_id ]['responsive_breakpoint'].'px';
            $mobile_menu_bg_color      = $settings[ $theme_id ]['mobile_menu_bg_color'];
            $mobile_menu_link_bg_color = $settings[ $theme_id ]['mobile_menu_link_bg_color'];
            $mobile_menu_hvr_bg_color  = $settings[ $theme_id ]['mobile_menu_hvr_bg_color'];

            $mobile_menu_link_color    = $settings[ $theme_id ]['mobile_menu_link_color'];
            $mobile_menu_hvr_link_color= $settings[ $theme_id ]['mobile_menu_hvr_link_color'];

            $menu_dropdown_arrow1 = $settings[ $theme_id ]['menu-dropdown-arrow'];
            if($menu_dropdown_arrow1=='disabled'){
               $menu_dropdown_arrow = "";
            }else{
               $menu_dropdown_arrow = "'\\" .  $menu_dropdown_arrow1 . "'";
            }

            $sub_menu_dropdown_arrow1 = $settings[ $theme_id ]['sub-menu-dropdown-arrow'];

            if( $sub_menu_dropdown_arrow1=='disabled'){
               $sub_menu_dropdown_arrow = "";
            }else{
              $sub_menu_dropdown_arrow = "'\\" . $sub_menu_dropdown_arrow1 . "'";
            }

            // mobile
            $mobile_menu_dropdown_arrow1 = $settings[ $theme_id ]['mobile-menu-dropdown-arrow'];
            if( $mobile_menu_dropdown_arrow1=='disabled'){
               $mobile_menu_dropdown_arrow = "";
            }else{
              $mobile_menu_dropdown_arrow = "'\\" . $mobile_menu_dropdown_arrow1 . "'";
            }

            $mobile_sub_menu_dropdown_arrow1 = $settings[ $theme_id ]['mobile-sub-menu-dropdown-arrow'];
             if( $mobile_sub_menu_dropdown_arrow1=='disabled'){
               $mobile_sub_menu_dropdown_arrow = "";
            }else{
              $mobile_sub_menu_dropdown_arrow = "'\\" . $mobile_sub_menu_dropdown_arrow1 . "'";
            }

            // mobile sub menu
             $mobile_sub_menu_bg_link_color     = $settings[ $theme_id ]['mobile_sub_menu_bg_link_color'];
             $mobile_sub_menu_bg_link_hvr_color = $settings[ $theme_id ]['mobile_sub_menu_bg_link_hvr_color'];

             $mobile_sub_menu_link_color     = $settings[ $theme_id ]['mobile_sub_menu_link_color'];
             $mobile_sub_menu_link_hvr_color = $settings[ $theme_id ]['mobile_sub_menu_link_hvr_color'];
             
             $toggle_bar_height  = $settings[ $theme_id ]['toggle_bar_height'].'px';
             $toggle_bg_color    = $settings[ $theme_id ]['toggle_bg_color'];

             $toggle_icon_clr  = $settings[ $theme_id ]['toggle_icon_clr'];
             $toggle_text_clr  = $settings[ $theme_id ]['toggle_text_clr'];

             $mobile_open_toggle_icon1 = $settings[ $theme_id ]['mobile-open-toggle-icon'];
             $mobile_open_toggle_icon  = "'\\" . $mobile_open_toggle_icon1 . "'";

             $mobile_close_toggle_icon1 = $settings[ $theme_id ]['mobile-close-toggle-icon'];
             $mobile_close_toggle_icon  = "'\\" . $mobile_close_toggle_icon1 . "'";

             $custom_css_  = $settings[ $theme_id ]['custom_css'];
             $custom_css = stripslashes( html_entity_decode( $custom_css_, ENT_QUOTES ) );
            
			 $style = <<<EOT

		     @media only screen and (min-width:$responsive_breakpoint ){
              $nav_wrapper_id  {
                            clear: both;
                        }
                        $nav_wrapper_id {
                            background: #222;
                        }
                        $nav_wrapper_id {
                            border-radius: 0;
                        }
                        
                        $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-menu-item{
                            transition: none;
                            border-radius: 0;
                            box-shadow: none;
                            background: none;
                            border: 0;
                            bottom: auto;
                            box-sizing: border-box;
                            clip: auto;
                            color: #666;
                            display: block;
                            float: none;
                            font-family: inherit;
                            font-size: 16px;
                            height: auto;
                            left: auto;
                            line-height: 1.7;
                            list-style-type: none;
                            margin: 0;
                            min-height: auto;
                            max-height: none;
                            opacity: 1;
                            outline: none;
                            overflow: visible;
                            padding: 0;
                            pointer-events: auto;
                            right: auto;
                            text-align: left;
                            text-decoration: none;
                            text-indent: 0;
                            text-transform: none;
                            transform: none;
                            top: auto;
                            vertical-align: baseline;
                            visibility: inherit;
                            width: auto;
                            word-wrap: break-word;
                            white-space: normal;
                            position: relative;
                        }
                        $nav_wrapper_id  $mmplus_nav_menu_id{
                            visibility: visible;
                            text-align: left;
                            padding: 0px 0px 0px 0px;
                        }
                        $nav_wrapper_id  $mmplus_nav_menu_id > li.mmplus-menu-item {
                            margin: 0 0px 0 0;
                            display: inline-block;
                            height: auto;
                            vertical-align: middle;
                        }

                       $nav_wrapper_id  $mmplus_nav_menu_id > li.mmplus-menu-item > a.mmplus-menu-link{
                            line-height: 40px;
                            height: 40px;
                            padding: 0px 10px 0px 10px;
                            vertical-align: baseline;
                            width: auto;
                            display: block;
                            color: #333;
                            text-transform: none;
                            text-decoration: none;
                            text-align: left;
                            text-decoration: none;
                            background: rgba(0, 0, 0, 0);
                            border: 0;
                            border-radius: 0;
                            font-family: inherit;
                            font-size: 16px;
                            font-weight: normal;
                            outline: none;
                        }

                       $nav_wrapper_id  $mmplus_nav_menu_id > li.mmplus-menu-item > a.mmplus-menu-link:hover {
                            background: #0073aa;
                            color: #fff;
                            font-weight: normal;
                            text-decoration: none;
                            border-color: #fff;
                        }
                       $nav_wrapper_id  $mmplus_nav_menu_id a.mmplus-menu-link{
                            cursor: pointer;
                            padding-top:0;
                            padding-bottom:0;
                        }

                      $nav_wrapper_id  $mmplus_nav_menu_id li.mmplus-is-megamenu{
                            position: static;
                        }
                      $nav_wrapper_id  $mmplus_nav_menu_id li.mmplus-is-megamenu .mmplus-menu-item.mmplus-mmth-type-widget{
                        padding:10px;
                        }
                      $nav_wrapper_id  $mmplus_nav_menu_id li.mmplus-is-megamenu .mmplus-menu-item.mmplus-mmth-type-widget h4.mmplus-item-title{
                        font-weight:500;
                        margin-bottom:10px;
                        margin-top:0;
                        }
                       $nav_wrapper_id  $mmplus_nav_menu_id .mmplus-is-megamenu p {
                            margin-bottom: 10px;
                        }
                       $nav_wrapper_id  $mmplus_nav_menu_id ul ul {
                            list-style-type: none;
                            margin: 0;
                            padding: 0;
                       }


            $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item > a.mmplus-menu-link{
              height:$menu_item_link_height;
              line-height:$menu_item_link_height;
            }
            $nav_wrapper_id $mmplus_nav_menu_id{
               text-align:$menu_item_align;
            }
            $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item > a.mmplus-menu-link{
               color: $menu_link_color;
            }
             $nav_wrapper_id, $nav_wrapper_id $mmplus_nav_menu_id{
                background:$menu_bg_color;
            }
            $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item > a.mmplus-menu-link{
               color: $menu_link_color;
            }
            $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item > a.mmplus-menu-link:hover{
               color:$menu_hvr_color;
            }
             $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item > a.mmplus-menu-link{
                background:$menu_link_bg_color;
            }
            $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item > a.mmplus-menu-link:hover{
                background:$menu_link_hvr_bg_color;
            }  
            $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-menu-item > ul.mega-sub-menu-mmplus,
            $nav_wrapper_id $mmplus_nav_menu_id ul.mega-sub-menu-mmplus li.mmplus-menu-item a.mmplus-menu-link{
                background:$sub_menu_bg_color;
            }
            $nav_wrapper_id $mmplus_nav_menu_id .mega-sub-menu-mmplus > li.mmplus-menu-item a.mmplus-menu-link:hover{
                background:$sub_menu_hvr_bg_color;
            }
            $nav_wrapper_id $mmplus_nav_menu_id ul.mega-sub-menu-mmplus li.mmplus-menu-item a.mmplus-menu-link{
                color:$sub_menu_link_color;
            }
            $nav_wrapper_id $mmplus_nav_menu_id ul.mega-sub-menu-mmplus li.mmplus-menu-item a.mmplus-menu-link:hover{
                color:$sub_menu_hvr_color;
            }

            $nav_wrapper_id $mmplus_nav_menu_id{
             padding-top:$menu_padding_top;
             padding-left:$menu_padding_left;
             padding-right:$menu_padding_right;
             padding-bottom:$menu_padding_bottom;
             border-top-left-radius:$menu_border_radius_top_left;    
             border-top-right-radius:$menu_border_radius_top_right;   
             border-bottom-right-radius:$menu_border_radius_bottom_right;
             border-bottom-left-radius:$menu_border_radius_bottom_left;

           }
           $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item > a.mmplus-menu-link{
            margin-left:$menu_margin_left;
            margin-right:$menu_margin_right;
           }
           

           $nav_wrapper_id $mmplus_nav_menu_id .mmplus-menu-item-has-children .mmplus-menu-link > span.mega-indicator:after{
              content:$menu_dropdown_arrow;
           }
           $nav_wrapper_id $mmplus_nav_menu_id ul.mega-sub-menu-mmplus .mmplus-menu-link > span.mega-indicator:after{
              content:$sub_menu_dropdown_arrow;
           }
           $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-is-megamenu .mmplus-menu-item.mmplus-mmth-type-widget{
            font-size:14px;
            font-weight:normal;
            }

            $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-is-megamenu .mmplus-menu-item.mmplus-mmth-type-widget h4.mmplus-item-title{
            font-size:16px;
            }
            $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-is-megamenu .mmplus-menu-item.mmplus-mmth-type-widget ul{
            list-style-type: circle;
            padding-left: 1rem;
            }
            $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-is-megamenu .mmplus-menu-item.mmplus-mmth-type-widget ul li{
                list-style-type: circle;
                }

            .mmplus-menu .navigation.mobile-menu-wrapper ul ul{
                    display:block;
                }
            $nav_wrapper_id $mmplus_nav_menu_id li a{
                border:none;
                width:100%;
            }    
                           
        }   
            @media only screen and (max-width:$responsive_breakpoint ){
                 $nav_wrapper_id  $mmplus_nav_menu_id .mmplus-mmplus-col-6, 
                 $nav_wrapper_id  $mmplus_nav_menu_id.mmplus-mmplus-col-4,
                 $nav_wrapper_id  $mmplus_nav_menu_id.mmplus-mmplus-col-3,
                 $nav_wrapper_id  $mmplus_nav_menu_id .mmplus-mmplus-col-5,
                 $nav_wrapper_id  $mmplus_nav_menu_id .mmplus-mmplus-col-2{
                 width:100%;
            }
           $nav_wrapper_id  $mmplus_nav_menu_id li.mmplus-menu-item.mmplus-is-megamenu > ul.mega-sub-menu-mmplus{
                width:100%!important;
           }
           $nav_wrapper_id  .mega-menu-mmplus-toggle .mega-toggle-blocks-right .mega-toggle-block-1:after,ul[data-effect-mobile=slide_center] .mega-toggle-label-mmplus-closed:after{
                color: $toggle_icon_clr;
           }
           $nav_wrapper_id .mega-menu-mmplus-toggle .mega-toggle-mmplus-label{
                color: $toggle_text_clr;
           }
             .mega-menu-mmplus-toggle{
                display: -webkit-box;
                display: -ms-flexbox;
                display: -webkit-flex;
                display: flex;
            }
            $nav_wrapper_id  $mmplus_nav_menu_id{
                position: fixed;
                display: block;
                width: 300px;
                max-width: 90%;
                height: 100vh;
                max-height: 100vh;
                top: 0;
                box-sizing: border-box;
                transition: left 200ms ease-in-out, right 200ms ease-in-out;
                overflow:auto;
                z-index: 9999999999;
            }
            $nav_wrapper_id .mega-menu-mmplus-toggle + $mmplus_nav_menu_id{
                background:#0073aa;
                padding: 0px 0px 0px 0px;
                display: none;
            }
            
            $nav_wrapper_id .mega-menu-mmplus-toggle + $mmplus_nav_menu_id{
                position: fixed;
                display: block;
                width: 300px;
                max-width: 90%;
                height: 100vh;
                max-height: 100vh;
                top: 0;
                box-sizing: border-box;
                transition: left 200ms ease-in-out, right 200ms ease-in-out;
                overflow:auto;
                z-index: 9999999999;
            }
            $nav_wrapper_id .mega-menu-mmplus-toggle + [data-effect-mobile="slide_left"]{
                right: -300px;
            }
            $nav_wrapper_id .mega-menu-mmplus-toggle.mega-menu-open + $mmplus_nav_menu_id{
                display: block;
            }

            $nav_wrapper_id .mega-menu-mmplus-toggle.mega-menu-open + [data-effect-mobile="slide_left"] {
                right: 0;

            }
             $nav_wrapper_id .mega-menu-mmplus-toggle.mega-menu-open + [data-effect-mobile="slide_right"] {
               left: 0;
            }
             $nav_wrapper_id .mega-menu-mmplus-toggle + [data-effect-mobile="slide_right"]{
                    left: -300px;
                }
            $nav_wrapper_id .mega-menu-mmplus-toggle.mega-menu-open + [data-effect-mobile="slide_center"]{
                display:block!important;
            }
              $nav_wrapper_id .mega-menu-mmplus-toggle + [data-effect-mobile="slide_center"] {
                    width: 100%!important;
                    margin: 0!important;
                    top: 0!important;
                    left: 0!important;
                    right: 0!important;
                    bottom: 0!important;
                    max-width: 100%!important;
                display:none!important;
                   -webkit-transition: all 0.3s ease!important;
                    -moz-transition: all 0.3s ease!important;
                    -ms-transition: all 0.3s ease!important;
                    -o-transition: all 0.3s ease!important;
                    transition: all 0.3s ease!important;
                    -webkit-animation: bodyfadeIn .3s!important;
                    -moz-animation: bodyfadeIn .3s!important;
                    -ms-animation: bodyfadeIn .3s!important;
                    -o-animation: bodyfadeIn .3s!important;
                    animation: bodyfadeIn .3s!important;
                }
                $nav_wrapper_id .mega-menu-mmplus-toggle + [data-effect-mobile="slide_center"] li{
                    width: 250px!important;
                    margin: auto!important;
                    display: inherit!important;
                }
                ul[data-effect-mobile=slide_center] .mega-toggle-label-mmplus-closed:first-child{
                    display:block;
                }
                    ul[data-effect-mobile=slide_center] .mega-toggle-label-mmplus-closed{
                    display:none;
                    }   

                   
            $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item{
                display: list-item;
                margin: 0;
                clear: both;
                border: 0;
                line-height:normal;
            }
            $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item > a.mmplus-menu-link{
                border-radius: 0;
                border: 0;
                margin: 0;
                line-height: 40px;
                height: 40px;
                padding: 0 10px;
                background: transparent;
                text-align: left;
                color: #fff;
                font-size: 14px;
            }
            $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item-has-children > a.mmplus-menu-link > span.mega-indicator {
                float: right;
            }

            $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item ul.mega-sub-menu-mmplus{
             position: static;
                float: left;
                width: 100%;
                padding: 0;
                border: 0;
            }
            $nav_wrapper_id $mmplus_nav_menu_id  > li.mmplus-menu-item.mega-toggle-on > ul.mega-sub-menu-mmplus,li.mega-toggle-on > ul.mega-sub-menu-mmplus{
                display:block;
                visibility: visible;
                opacity: 1;
               
               transition:none;
            }
            $nav_wrapper_id $mmplus_nav_menu_id> li.mmplus-menu-item > ul.mega-sub-menu-mmplus,ul.mega-sub-menu-mmplus{
                display:none;
                visibility: visible;
                opacity: 1;
            transition:none;
            }

            $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-menu-item-has-children.mega-toggle-on > a.mmplus-menu-link > span.mega-indicator:after {
                content: '\f142';
            }
            .mmplus-is-megamenu ul.mega-sub-menu-mmplus{
            display:block;
            }

            $nav_wrapper_id .mega-menu-mmplus-toggle + #mmplus-megamenu-menu-1{
              background:$mobile_menu_bg_color;
            }
            $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-menu-item{
              background:$mobile_menu_link_bg_color;
              
            }
             $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-menu-item:hover{
             background:$mobile_menu_hvr_bg_color;
             
           }
            $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item > a.mmplus-menu-link{
             color:$mobile_menu_link_color;
           }
           $nav_wrapper_id $mmplus_nav_menu_id > li.mmplus-menu-item:hover a.mmplus-menu-link{
             color:$mobile_menu_hvr_link_color;
           }
           $nav_wrapper_id $mmplus_nav_menu_id ul.mega-sub-menu-mmplus li.mmplus-menu-item a.mmplus-menu-link{
            background:$mobile_sub_menu_bg_link_color;
            color:$mobile_sub_menu_link_color;
           }
           $nav_wrapper_id $mmplus_nav_menu_id ul.mega-sub-menu-mmplus li.mmplus-menu-item a.mmplus-menu-link:hover{
            background:$mobile_sub_menu_bg_link_hvr_color;
            color:$mobile_sub_menu_link_hvr_color;
           }
          $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-is-megamenu .mmplus-menu-item.mmplus-mmth-type-widget:hover,$nav_wrapper_id $mmplus_nav_menu_id li.mmplus-is-megamenu .mmplus-menu-item.mmplus-mmth-type-widget{
            background:transparent;
            }
            $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-menu-item.mmplus-is-megamenu > ul.mega-sub-menu-mmplus{
            max-height: inherit;
                overflow: auto;
            }
          .mega-menu-mmplus-toggle{
              height:$toggle_bar_height;
              line-height:$toggle_bar_height;
              background:$toggle_bg_color;
           }
          $nav_wrapper_id $mmplus_nav_menu_id .mmplus-menu-link > span.mega-indicator:after,ul.mega-sub-menu-mmplus .mmplus-menu-link > span.mega-indicator:after{
              content:$mobile_menu_dropdown_arrow;
          }
          $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-menu-item-has-children.mega-toggle-on > a.mmplus-menu-link > span.mega-indicator:after{
               content:$mobile_sub_menu_dropdown_arrow;
          }
          $nav_wrapper_id .mega-menu-mmplus-toggle .mega-toggle-blocks-right .mega-toggle-block-1:after{
            content:$mobile_open_toggle_icon;
          }
          $nav_wrapper_id .mega-menu-mmplus-toggle.mega-menu-open .mega-toggle-block-1:after{
            content:$mobile_close_toggle_icon;
          }
          $nav_wrapper_id $mmplus_nav_menu_id .mmplus-is-megamenu .mmplus-mmplus-col{
            width:100%;
            }
            $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-is-megamenu .mmplus-menu-item.mmplus-mmth-type-widget h4.mmplus-item-title {
                font-size: 16px;
            margin:0;
            line-height:40px;
            }
            $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-is-megamenu .mmplus-menu-item.mmplus-mmth-type-widget {
                font-size: 14px;
                font-weight: normal;
            padding:10px;
            }
            $nav_wrapper_id .mega-menu-mmplus-toggle + $mmplus_nav_menu_id::-webkit-scrollbar-track
            {
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                background-color: #F5F5F5;
            }

            $nav_wrapper_id .mega-menu-mmplus-toggle + $mmplus_nav_menu_id::-webkit-scrollbar
            {
                width: 5px;
                background-color: #F5F5F5;
            }

            $nav_wrapper_id .mega-menu-mmplus-toggle + $mmplus_nav_menu_id::-webkit-scrollbar-thumb
            {
                background-color: #000000;
                border: 2px solid #555555;
            }
            $nav_wrapper_id ul[data-mobile-hide-submenu="on"] ul.mega-sub-menu-mmplus,$nav_wrapper_id ul[data-mobile-hide-submenu="on"] .mega-indicator{
             display:none!important;

            }
            $nav_wrapper_id $mmplus_nav_menu_id .mmplus-is-megamenu .mmplus-mmplus-col{
                padding:0!important;
            }
            $nav_wrapper_id $mmplus_nav_menu_id li.mmplus-menu-item.mmplus-is-megamenu > ul.mega-sub-menu-mmplus{
                border-radius:0!important;
             }

        }

        li.mmplus-menu-item.mmplus-is-megamenu > ul.mega-sub-menu-mmplus.panright{
        left: auto;
        right: 0;
        }

        $custom_css
                                                                      
EOT;

            return apply_filters('mmplus_generated_css', $style, $nav_wrapper_id);
        }  
        /**
         * Render css to wp head
         */
        public function render_css(){

            $style = '<style type="text/css">';
            $style .= $this->css();
            $style .= '</style>';

            echo $style;
        }
}

	new MMPlus_Style();

}