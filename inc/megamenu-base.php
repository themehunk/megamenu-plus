<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access.
}
/**
 * 
 */
if ( ! class_exists('MMPLUS_Base')) {
 
	class MMPLUS_Base {
		
		/**
		 * @return wp_megamenu_base
		 */
		public static function init(){
			$return = new self();
			return $return;
		}


		public function admin_print_scripts( $hook ) {
		   do_action( 'admin_print_scripts-widgets.php' );
		}

		public function admin_print_footer_scripts( $hook ) {
		   do_action( 'admin_footer-widgets.php' );
		}

		public function __construct() {
			add_action( 'admin_print_scripts-nav-menus.php', array( $this, 'admin_print_scripts' ) );
			add_filter( 'body_class', array( $this, 'mmplus_add_body_classes' ) );
    		add_action( 'admin_print_footer_scripts-nav-menus.php', array( $this, 'admin_print_footer_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this,'mmplus_megamenu_mmplus_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'mmplus_megamenu_mmplus_admin_scripts' ) );
			add_action( 'wp_ajax_mmplus_item_enable_megamenu', array($this, 'mmplus_item_enable_megamenu'));
			add_action( 'wp_ajax_mmplus_item_settings_load', array($this, 'mmplus_item_settings_load'));
			add_action( 'wp_ajax_mmplus_save_layout', array($this, 'mmplus_save_layout'));
			add_filter( 'wp_nav_menu_objects', array( $this, 'mmplus_add_widgets_to_menu' ), 10, 2 );
			add_action( 'wp_ajax_mmplus_save_builder_options', array($this, 'mmplus_save_builder_options'));
			add_action( 'wp_ajax_mmplus_update_megamenu_icon', array($this, 'mmplus_update_megamenu_icon'));
		}

		//Enqueue scripts	
		public function mmplus_megamenu_mmplus_scripts(){
			wp_enqueue_style( 'mmplus-megamenu-style', MMPLUS_URL. '/assets/css/megamenu.css' );
			wp_enqueue_style('mmplus-fontawesome_css_admin', MMPLUS_URL .'lib/font-awesome-4.7.0/css/font-awesome.min.css', false, '4.7.0');
			wp_enqueue_script( 'hoverIntent' );
			wp_enqueue_script( 'mmplus-megamenu-script', MMPLUS_URL. '/assets/js/megamenu.js', 
				array(
	            'jquery')
	        );
           $params = apply_filters("mmplus_javascript_localisation",
            array(
                "timeout" => 300,
                "interval" => 100
            )
          );

        wp_localize_script( 'mmplus-megamenu-script', 'megamenu', $params );

		}

		//Enqueue admin scripts
		public function mmplus_megamenu_mmplus_admin_scripts(){
			wp_enqueue_style( 'mmplus-megamenu-admin-style', MMPLUS_URL. '/assets/css/megamenu-admin.css' );
			wp_enqueue_style('mmplus-fontawesome_css_admin', MMPLUS_URL .'lib/font-awesome-4.7.0/css/font-awesome.min.css', false, '4.7.0');
			
			wp_enqueue_script( 'wp-color-picker-alpha', MMPLUS_URL .'lib/wpcolorpicker-alpha.js', array('wp-color-picker', 'jquery'), '1.2.2', true);
			wp_enqueue_media();
			wp_enqueue_script( 'mmplus-megamenu-admin-script', MMPLUS_URL. '/assets/js/megamenu-admin.js', 
				array(
	            'jquery',
	            'jquery-ui-core',
	            'jquery-ui-sortable',
	            'jquery-ui-accordion',
	        	'wp-color-picker')
	        );
  
	        wp_localize_script('mmplus-megamenu-admin-script', 'mmplus_obj', 
	        	array( 
	        		'ajax_url' => admin_url('admin-ajax.php'), 
	        		'mmplus_nonce'    => wp_create_nonce('mmplus_check_security'),
	        		'no_column_space_error' => __( 'There is not enough space in this row to add a new column.', 'mmplus' ), 
	        		'mmth_begin_text' => __( 'Mega Menu TH', 'mmplus' )
	        	) 
	        );
		}
			/**
	     * Add a body class for each active Thunk mega menu location.
	     *
	     * @since 2.3
	     * @param array $classes
	     * @return array
	     */
	    public function mmplus_add_body_classes( $classes ){
	        $locations = get_nav_menu_locations();

	        if ( count( $locations ) ) {
	            foreach ( $locations as $location => $id ) {
	                if ( has_nav_menu( $location ) && mmplus_is_enabled( $location ) ) {
	                    $classes[] = 'mmplus-menu mmplus-menu-' . str_replace( "_", "-", $location );
	                }
	            }
	        }

	        return $classes;
	    }
		
		/**
		 * Check if Thunk megamenu is enabled for top menu item
		 */
		public function mmplus_item_enable_megamenu(){
			check_ajax_referer( 'mmplus_check_security', 'mmplus_nonce' );
			$menu_item_id = (int) sanitize_text_field( $_POST['menu_item_id'] );
			$mmplus_item_megamenu_status = sanitize_text_field( $_POST['mmplus_item_megamenu_status'] );
			
			update_post_meta( $menu_item_id, 'mmplus_item_megamenu_status', $mmplus_item_megamenu_status );
			$mmplus_item_megamenu_status = get_post_meta( $menu_item_id, 'mmplus_item_megamenu_status', true );
			wp_send_json_success( array('mmplus_item_megamenu_status' => $mmplus_item_megamenu_status) );
			die();
		}
		/**
		 * Show settings menu
		 */
		public function mmplus_item_settings_load(){
			check_ajax_referer( 'mmplus_check_security', 'mmplus_nonce' );

			$menu_item_id = (int) sanitize_text_field( $_POST['menu_item_id'] );
			$menu_id = (int) sanitize_text_field( $_POST['menu_id'] );
			$menu_item_depth = (int) sanitize_text_field( $_POST['menu_item_depth'] );


			//We are working with top level menu
			if ($menu_item_depth == 0) {
				$get_layout = (array) get_post_meta($menu_item_id, 'mmplus_layout', true);
				$array_menu = wp_get_nav_menu_items($menu_id);

				if (empty($get_menu_settings['menu_type'])){
					$get_menu_settings['menu_type'] = 'mmth_dropdown_menu';
				}

				$new_menu_item_id = array();
				$unique_items = array();
				foreach ($array_menu as $m) {
					if ($m->menu_item_parent && ($m->menu_item_parent == $menu_item_id)) {
						$unique_items[$m->ID] = array('item_type' => 'menu_item', 'ID' => $m->ID, 'title' => $m->title, 'url' => $m->url, 'description' => $m->description, 'options' => array());
						$new_menu_item_id[] = $m->ID;
					}
				}

				
				if (! empty($get_layout['layout'])){
					foreach($get_layout['layout'] as $lkey => $all_layout){
						if (count($all_layout['row'])){
							foreach ($all_layout['row'] as $rkey => $cols){
								
								foreach ($cols['items'] as $col_key => $col_item){
									
									if ($col_item['item_type'] === 'menu_item'){
										
										if (array_key_exists($col_item['ID'], $unique_items)){
											//Assigning New name, if changed name of item
											$get_layout['layout'][$lkey]['row'][$rkey]['items'][$col_key]['title'] = $unique_items[$col_item['ID']]['title'];
											unset($unique_items[$col_item['ID']]);
										}
										if ( ! in_array($col_item['ID'], $new_menu_item_id)){
											unset($get_layout['layout'][$lkey]['row'][$rkey]['items'][$col_key] );
										}
										//removing check, if not in array();
									}
								}
							}
						}
					}
				}

				
				if ( ! empty($unique_items)){
					$first_row_key = mmplus_get_array_first_key($get_layout['layout']);
					$first_col_key = mmplus_get_array_first_key($get_layout['layout'][$first_row_key]['row']);

					if ( ! empty($get_layout['layout'][$first_row_key]['row'][$first_col_key]['items'])){
						// $get_layout['layout'][$first_row_key]['row'][$first_col_key]['col'] = 12;
						$get_layout['layout'][$first_row_key]['row'][$first_col_key]['items'] = array_merge($get_layout['layout'][$first_row_key]['row'][$first_col_key]['items'],
							array_values($unique_items));
					}else{
						$get_layout['layout'][0]['row'][0]['col'] = 12;
						$get_layout['layout'][0]['row'][0]['items'] = array_values($unique_items);
					}
				}

				update_post_meta( $menu_item_id, 'mmplus_layout', $get_layout );
				
			}

			include MMPLUS_DIR.'views/admin/item_settings.php';
			die();

		}

		public function mmplus_save_layout(){
			check_ajax_referer( 'mmplus_check_security', 'mmplus_nonce' );

			$layout_format = sanitize_text_field($_POST['layout_format']);
			$layout_name = sanitize_text_field($_POST['layout_name']);
			$menu_item_id = (int) sanitize_text_field($_POST['menu_item_id']);
			$current_rows = (int) sanitize_text_field($_POST['current_rows']);

			$get_layout = (array) maybe_unserialize( get_post_meta($menu_item_id, 'mmplus_layout', true));
			$layout_explode = explode(',', $layout_format);

			$col_data = array();
			$new_col_size = 0;
			foreach($layout_explode as $col_size){
				$new_col_size= $new_col_size + $col_size;
				$col_data[] = array('col' => $col_size);

				if ($new_col_size >= 12){
					$new_col_size = 0;
					$get_layout['layout'][]['row'] = $col_data;
					$col_data = array();
				}
			}


			//If this is first row, add top menu item here
			if ($current_rows === 0) {
				$menu_id = (int)sanitize_text_field($_POST['menu_id']);
				$menu_items = wp_get_nav_menu_items($menu_id);

				$new_menu_item_id = array();
				$unique_items = array();
				foreach ($array_menu as $m) {
					if ($m->menu_item_parent && ($m->menu_item_parent == $menu_item_id)) {
						$unique_items[$m->ID] = array('item_type' => 'menu_item', 'ID' => $m->ID, 'title' => $m->title, 'url' => $m->url, 'description' => $m->description, 'options' => array());
						$new_menu_item_id[] = $m->ID;
					}
				}
				
				$get_layout['layout'][0]['row'][0]['items'] = array_values( $unique_items );
			}
			
			$update = update_post_meta($menu_item_id, 'mmplus_layout', $get_layout);
			$get_updated_data = get_post_meta( $menu_item_id, 'mmplus_layout' );
			wp_send_json_success( array('update_data' => $get_updated_data) );
		}

		public function mmplus_add_widgets_to_menu( $sorted_menu_items, $args ) {

			if ( ! $args->walker instanceof MMPlus_Walker ) {
				return $sorted_menu_items;
			}


			$mmth_widgets_factory = new MMPlus_Widgets();

			$menu_sub_menu_items = array();
			$megamenu_parent_items = array();

			foreach ($sorted_menu_items as $key => $item){
				$mmth_status = get_post_meta( $item->ID, 'mmplus_item_megamenu_status', true );
				$get_layout  = get_post_meta($item->ID, 'mmplus_layout', true);

				//Getting all sub menu items
				if ($item->menu_item_parent) {
					$menu_sub_menu_items[$key] = $item;
					unset($sorted_menu_items[$key]);
				}else{
					if ( ! empty( $mmth_status ) ) {
						if ($mmth_status == 'active') {
							$megamenu_parent_items[$key] = $item;
						}
					}
				}

				if ( ! empty( $mmth_status ) ){
					if ( $mmth_status == 'active' ){

						if ( ! empty($get_layout['layout'])){

							$item_count = 1;
							foreach ($get_layout['layout'] as $row_key =>$row){
								if ( ! empty($row['row'])){
									$big_row_int_ID = rand(0, 9999)+$item->ID;

									$sorted_menu_items[] = (object) array(
										'menu_item_parent'  => $item->ID,
										'type'              => 'mmth_row',
										'title'             => '',
										'ID'                => $big_row_int_ID,
										'db_id'             => $big_row_int_ID,
										'classes'           => array('mmplus-row')
									);

									foreach ($row['row'] as $col_key => $col){
										if ( ! empty($col['col'])){
											$col_class = "mmplus-col-".$col['col'];
										}else{
											$col_class = "mmplus-col-";
										}
										$big_col_int_ID = rand(0, 9999)+ $big_row_int_ID + $item->ID;
										
										$sorted_menu_items[] = (object) array(
											'menu_item_parent'      => $big_row_int_ID,
											'type'      => 'mmth_col',
											'title'     => '',
											'ID'        => $big_col_int_ID,
											'db_id'     => $big_col_int_ID,
											'classes' => array('mmplus-col', $col_class)
										);

										if (! empty($col['items'])){
											foreach ($col['items'] as $widget_key => $widget_item){
												if ( ! empty( $widget_item ) ) {												
													$menu_item = array(
														'type'                  => $widget_item['item_type'],
														'item_type'             => 'mmth_generated',
														'title'                 => $widget_item['item_type'] == 'widget' ?  $widget_item['widget_id'] : $widget_item['title'] ,
														'output'                => $widget_item['item_type'] == 'widget' ?  $mmth_widgets_factory->mmplus_show_widget($widget_item['widget_id']) : '',
														'menu_item_parent'      => $big_col_int_ID,
														 //Always have no child menu
														'ID'                    => $widget_item['item_type'] == 'widget' ? $widget_key + $item->ID : $widget_item['ID'],
														'depth'                 => 1,
														'classes'               => array(
															"menu-item",
															// "mmth-type-widget",
															// "menu-widget-class",
														),
													);

													if ($widget_item['item_type'] == 'widget'){

														$menu_item['db_id'] = 0; //Always have no child menu
														$menu_item['ID'] = $widget_item['item_type'] == 'widget' ? $widget_key + $item->ID : $widget_item['ID'];
														$menu_item['depth'] = 1;
														$menu_item['classes'][] = "mmth-type-widget";

													}else{
														$menu_item['db_id'] = $widget_item['ID'];
														$menu_item['classes'][] = "mmth-type-item";

														foreach ($menu_sub_menu_items as $skey => $submenu){
															if ($widget_item['ID'] == $submenu->ID){
																unset($menu_sub_menu_items[$skey]);
															}
														}
														
													}

													if ($widget_item['item_type'] == 'menu_item'){
														$menu_item['url'] = $widget_item['url'];
													}
													
													$sorted_menu_items[] = (object) $menu_item;
												}	
											}
										}
										$item_count++;
									}
								}
							}
						}
					}
				}
			}

			$megamenu_parent_item_id = array();
			foreach ($megamenu_parent_items as $pkey => $pvalue){
				$megamenu_parent_item_id[] = $pvalue->ID;
			}

			if (count($menu_sub_menu_items)){
				foreach ($menu_sub_menu_items as $item){
					if ( ! in_array( $item->menu_item_parent, $megamenu_parent_item_id)){ 
					// Check non megamenu sub menu item
						$sorted_menu_items[] = $item;
					}
				}
			}
			return $sorted_menu_items;
			
		}

		public function mmplus_save_builder_options() {
			$menu_item_id      = (int) sanitize_text_field($_POST['menu_item_id']);
			$mmplus_width    = sanitize_text_field($_POST['mmplus_width']);
			$mmplus_endtoend = sanitize_text_field($_POST['mmplus_endtoend']);
			$mmplus_bg_color = sanitize_text_field($_POST['mmplus_bg_color']);
			$mmplus_bg_image = sanitize_text_field($_POST['mmplus_bg_image']);

			$mmth_pannel_alignment           = sanitize_text_field($_POST['mmplus-pannel-alignment']);
			$mmplus_mega_pannel_padding_top    = sanitize_text_field($_POST['mmplus_mega_pannel_padding_top']);
			$mmplus_mega_pannel_padding_right  = sanitize_text_field($_POST['mmplus_mega_pannel_padding_right']);
			$mmplus_mega_pannel_padding_bottom = sanitize_text_field($_POST['mmplus_mega_pannel_padding_bottom']);
			$mmplus_mega_pannel_padding_left   = sanitize_text_field($_POST['mmplus_mega_pannel_padding_left']);

			$mmplus_border_color          = sanitize_text_field($_POST['mmplus_border_color']);
			$mmplus_mega_pannel_border_top    = sanitize_text_field($_POST['mmplus_mega_pannel_border_top']);
			$mmplus_mega_pannel_border_right  = sanitize_text_field($_POST['mmplus_mega_pannel_border_right']);
			$mmplus_mega_pannel_border_bottom = sanitize_text_field($_POST['mmplus_mega_pannel_border_bottom']);
			$mmplus_mega_pannel_border_left   = sanitize_text_field($_POST['mmplus_mega_pannel_border_left']);

			$mmplus_mega_pannel_raidus_top_left     = sanitize_text_field($_POST['mmplus_mega_pannel_raidus_top_left']);
			$mmplus_mega_pannel_raidus_top_right    = sanitize_text_field($_POST['mmplus_mega_pannel_raidus_top_right']);
			$mmplus_mega_pannel_raidus_bottom_right = sanitize_text_field($_POST['mmplus_mega_pannel_raidus_bottom_right']);
			$mmplus_mega_pannel_raidus_bottom_left  = sanitize_text_field($_POST['mmplus_mega_pannel_raidus_bottom_left']);

			$mmplus_mega_column_padding_top    = sanitize_text_field($_POST['mmplus_mega_column_padding_top']);
			$mmplus_mega_column_padding_right  = sanitize_text_field($_POST['mmplus_mega_column_padding_right']);
			$mmplus_mega_column_padding_bottom = sanitize_text_field($_POST['mmplus_mega_column_padding_bottom']);
			$mmplus_mega_column_padding_left   = sanitize_text_field($_POST['mmplus_mega_column_padding_left']);

			$mmplus_mmplus_widget_title_color     = sanitize_text_field($_POST['mmplus_mmplus_widget_title_color']);
			$mmplus_megamenu_widget_text_color      = sanitize_text_field($_POST['mmplus_megamenu_widget_text_color']);
			$mmplus_megamenu_widget_link_color      = sanitize_text_field($_POST['mmplus_megamenu_widget_link_color']);
			$mmplus_megamenu_widget_linkhvr_color   = sanitize_text_field($_POST['mmplus_megamenu_widget_linkhvr_color']);

			$mmplus_widget_content_alignment   = sanitize_text_field($_POST['mmth-widget-content-alignment']);



			$old_settings = (array) maybe_unserialize( get_post_meta($menu_item_id, 'mmplus_builder_options', true)); 
			$new_settings = array();
			$new_settings['menu_item_id'] = isset( ( $menu_item_id ) ) ? $menu_item_id : '';
			$new_settings['mmplus_width'] = isset( ( $mmplus_width ) ) ? $mmplus_width : '';
			$new_settings['mmplus_endtoend'] = isset( ( $mmplus_endtoend ) ) ? $mmplus_endtoend : '';
			$new_settings['mmplus_bg_color'] = isset( ( $mmplus_bg_color ) ) ? $mmplus_bg_color : '';
			$new_settings['mmplus_bg_image'] = isset( ( $mmplus_bg_image ) ) ? $mmplus_bg_image : '';

			$new_settings['mmth_pannel_alignment'] = isset( ( $mmth_pannel_alignment ) ) ? $mmth_pannel_alignment : '';

			$new_settings['mmplus_mega_pannel_padding_top'] = isset( ( $mmplus_mega_pannel_padding_top ) ) ? $mmplus_mega_pannel_padding_top : '';
			$new_settings['mmplus_mega_pannel_padding_right'] = isset( ( $mmplus_mega_pannel_padding_right ) ) ? $mmplus_mega_pannel_padding_right : '';
			$new_settings['mmplus_mega_pannel_padding_bottom'] = isset( ( $mmplus_mega_pannel_padding_bottom ) ) ? $mmplus_mega_pannel_padding_bottom : '';
			$new_settings['mmplus_mega_pannel_padding_left'] = isset( ( $mmplus_mega_pannel_padding_left  ) ) ? $mmplus_mega_pannel_padding_left  : '';

			$new_settings['mmplus_border_color'] = isset( ( $mmplus_border_color ) ) ? $mmplus_border_color : '';
			$new_settings['mmplus_mega_pannel_border_top'] = isset( ( $mmplus_mega_pannel_border_top ) ) ? $mmplus_mega_pannel_border_top : '';
			$new_settings['mmplus_mega_pannel_border_right'] = isset( ( $mmplus_mega_pannel_border_right ) ) ? $mmplus_mega_pannel_border_right : '';
			$new_settings['mmplus_mega_pannel_border_bottom'] = isset( ( $mmplus_mega_pannel_border_bottom  ) ) ? $mmplus_mega_pannel_border_bottom  : '';
			$new_settings['mmplus_mega_pannel_border_left'] = isset( ( $mmplus_mega_pannel_border_left  ) ) ? $mmplus_mega_pannel_border_left : '';

			$new_settings['mmplus_mega_pannel_raidus_top_left'] = isset( ( $mmplus_mega_pannel_raidus_top_left ) ) ? $mmplus_mega_pannel_raidus_top_left : '';
			$new_settings['mmplus_mega_pannel_raidus_top_right'] = isset( ( $mmplus_mega_pannel_raidus_top_right ) ) ? $mmplus_mega_pannel_raidus_top_right : '';
			$new_settings['mmplus_mega_pannel_raidus_bottom_right'] = isset( ( $mmplus_mega_pannel_raidus_bottom_right  ) ) ? $mmplus_mega_pannel_raidus_bottom_right : '';
			$new_settings['mmplus_mega_pannel_raidus_bottom_left'] = isset( ( $mmplus_mega_pannel_raidus_bottom_left ) ) ? $mmplus_mega_pannel_raidus_bottom_left : '';

			$new_settings['mmplus_mega_column_padding_top'] = isset( ( $mmplus_mega_column_padding_top ) ) ? $mmplus_mega_column_padding_top : '';
			$new_settings['mmplus_mega_column_padding_right'] = isset( ( $mmplus_mega_column_padding_right ) ) ? $mmplus_mega_column_padding_right : '';
			$new_settings['mmplus_mega_column_padding_bottom'] = isset( ( $mmplus_mega_column_padding_bottom  ) ) ? $mmplus_mega_column_padding_bottom : '';
			$new_settings['mmplus_mega_column_padding_left'] = isset( ( $mmplus_mega_column_padding_left ) ) ? $mmplus_mega_column_padding_left : '';

			$new_settings['mmplus_mmplus_widget_title_color'] = isset( ( $mmplus_mmplus_widget_title_color ) ) ? $mmplus_mmplus_widget_title_color : '#fff';
			$new_settings['mmplus_megamenu_widget_text_color'] = isset( ( $mmplus_megamenu_widget_text_color ) ) ? $mmplus_megamenu_widget_text_color : '';
			$new_settings['mmplus_megamenu_widget_link_color'] = isset( ( $mmplus_megamenu_widget_link_color ) ) ? $mmplus_megamenu_widget_link_color: '';
			$new_settings['mmplus_megamenu_widget_linkhvr_color'] = isset( ( $mmplus_megamenu_widget_linkhvr_color ) ) ? $mmplus_megamenu_widget_linkhvr_color : '';

			$new_settings['mmplus_widget_content_alignment'] = isset( ( $mmplus_widget_content_alignment ) ) ? $mmplus_widget_content_alignment : '';



			$updated_settings = array_merge( $old_settings, $new_settings );

			update_post_meta( $menu_item_id, 'mmplus_builder_options', $updated_settings );

			$updated_data = (array) maybe_unserialize( get_post_meta($menu_item_id, 'mmplus_builder_options', true)); 
			
			wp_send_json_success( array(
									'menu_item_id' => $menu_item_id, 
									'mmplus_width' => $mmplus_width,
									'mmplus_bg_image' => $mmplus_bg_image,
									'mmplus_bg_color' => $mmplus_bg_color,
									'mmth_pannel_alignment' => $mmth_pannel_alignment,
									'mmplus_mega_pannel_padding_top' => $mmplus_mega_pannel_padding_top,
									'mmplus_mega_pannel_padding_right' => $mmplus_mega_pannel_padding_right,
									'mmplus_mega_pannel_padding_bottom' => $mmplus_mega_pannel_padding_bottom,
									'mmplus_mega_pannel_padding_left' => $mmplus_mega_pannel_padding_left,
									'mmplus_border_color' => $mmplus_border_color,
									'mmplus_mega_pannel_border_top' => $mmplus_mega_pannel_border_top,
									'mmplus_mega_pannel_border_right' => $mmplus_mega_pannel_border_right,
									'mmplus_mega_pannel_border_bottom' => $mmplus_mega_pannel_border_bottom,
									'mmplus_mega_pannel_border_left' => $mmplus_mega_pannel_border_left,
									'mmplus_mega_pannel_raidus_top_left' => $mmplus_mega_pannel_raidus_top_left,
									'mmplus_mega_pannel_raidus_top_right' => $mmplus_mega_pannel_raidus_top_right,
								    'mmplus_mega_pannel_raidus_bottom_right' => $mmplus_mega_pannel_raidus_bottom_right,
									'mmplus_mega_pannel_raidus_bottom_left' => $mmplus_mega_pannel_raidus_bottom_left,
									'mmplus_mega_column_padding_top' => $mmplus_mega_column_padding_top,
									'mmplus_mega_column_padding_right' => $mmplus_mega_column_padding_right,
								    'mmplus_mega_column_padding_bottom' => $mmplus_mega_column_padding_bottom,
									'mmplus_mega_column_padding_left' => $mmplus_mega_column_padding_left,
									'mmplus_mmplus_widget_title_color' => $mmplus_mmplus_widget_title_color,
									'mmplus_megamenu_widget_text_color' => $mmplus_megamenu_widget_text_color,
								    'mmplus_megamenu_widget_link_color' => $mmplus_megamenu_widget_link_color,
									'mmplus_megamenu_widget_linkhvr_color' => $mmplus_megamenu_widget_linkhvr_color,
									'mmplus_widget_content_alignment' => $mmplus_widget_content_alignment,
									'new_settings' => $new_settings,
									'updated_data' => $updated_data,
								));
			die();
		}

		public function mmplus_update_megamenu_icon(){
			check_ajax_referer( 'mmplus_check_security', 'mmplus_nonce' );
			$menu_item_id = (int) sanitize_text_field( $_POST['menu_item_id'] );
			$icon 		  = sanitize_text_field( $_POST['icon'] );

			$old_settings = (array) maybe_unserialize( get_post_meta($menu_item_id, 'mmplus_builder_options', true)); 
			$new_settings = array();
			$new_settings['icon'] = isset( ( $icon ) ) ? $icon : '';
			
			$updated_settings = array_merge( $old_settings, $new_settings );

			update_post_meta( $menu_item_id, 'mmplus_builder_options', $updated_settings );

			$updated_data = (array) maybe_unserialize( get_post_meta($menu_item_id, 'mmplus_builder_options', true)); 
			
			wp_send_json_success( array(
									'menu_item_id' => $menu_item_id, 
									'icon' => $icon, 
									'new_settings' => $new_settings,
									'old_settings' => $old_settings,
									'merged_settings' => $updated_settings,
									'updated_data' => $updated_data,
								));
			
		}
		

	} // Class Ends Here

		MMPLUS_Base::init();
 } 