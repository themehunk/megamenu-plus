<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
} 
$menu_item_id = (int) sanitize_text_field( $_POST['menu_item_id'] );
$menu_id = (int) sanitize_text_field( $_POST['menu_id'] );
$menu_item_depth = (int) sanitize_text_field( $_POST['menu_item_depth'] ); 
$mmplus_item_megamenu_status = get_post_meta( $menu_item_id, 'mmplus_item_megamenu_status', true );
$mmplus_layout = get_post_meta( $menu_item_id, 'mmplus_layout', true );
$mmth_builder_option  = get_post_meta( $menu_item_id, 'mmplus_builder_options', true );
$widgets = MMPlus_Widgets::mmplus_get_all_registered_widgets();	
define('MMPLUS_PANEL_LEFT', MMPLUS_URL . 'assets/images/panel-left.png');
define('MMPLUS_PANEL_RIGHT', MMPLUS_URL . 'assets/images/panel-right.png');
define('MMPLUS_ALIGN_LEFT', MMPLUS_URL . 'assets/images/left-align.png');
define('MMPLUS_ALIGN_CENTER', MMPLUS_URL . 'assets/images/center-align.png');
define('MMPLUS_ALIGN_RIGHT', MMPLUS_URL . 'assets/images/right-align.png');
?>
 <div class="mmth-item-settings-top-bar"> 
 	<div class="mmth-item-settings-title">
        <span class="mmplus-item-settings-heading"></span>
    </div>
    <?php if ( $menu_item_depth == 0 ) { ?>
    <span class="mmplus-megamenu-status">
    	<label for='mmplus-megamenu-status-chkbox' class="mmplus-megamenu-status-text <?php echo esc_attr($mmplus_item_megamenu_status); ?>"><?php _e('Activate MegaMenu', 'mmplus') ?>
    	<input type="checkbox" id="mmplus-megamenu-status-chkbox" <?php checked( $mmplus_item_megamenu_status, 'active' ); ?> >
    	</label>
    </span>
	<?php } ?>
	<a href="javascript:;" id="mmth-saving-indicator" style="display: none;"><?php _e('Saving...', 'mmplus'); ?></a>
 	<a href="javascript:;" class="mmplus-builder-close-btn">
 		<span class="dashicons dashicons-no-alt"></span>
 	</a>
 	<div class="clear"></div>
 </div>
 <div class="mmth-item-settings-builder-area">
 	<div class="mmth-builder-settings-wrapper"> 	
 		<div class="mmplus-draggable-widgets-wrapper">
 			<div class=" mmth-builder-settings  mmplus-draggable-widgets-list-title active">
 				<i class="dashicons dashicons-editor-kitchensink"></i>   <?php _e('Widgets', 'mmplus'); ?>
 			</div>	                          
		    <div class="mmplus-draggable-widgets-list">
		    	<?php
		        if ( count( $widgets ) ){
		            foreach ($widgets as $key => $value){
		                echo '<div class="draggable-widget" data-widget-id-base="' . $value['id_base'] . '" data-type="outside-widget"> '. 
		                	'<span class="outside-widget-name">' 
		                	. $value['name'] . 
		                	'</span>'.
		                	' <span class="widgets-drag-btn"><i class="fa fa-arrows"></i>'
		                	.__('Drag', 'mmplus').'</span>
		                	</div>';
		            }
		        }
		       ?>
		    </div>
		</div>    
	    <div class="mmth-builder-settings mmplus-builder-config-options">
	    	<i class="dashicons dashicons-admin-generic"></i> <?php _e('Options', 'mmplus'); ?>
	    </div>	    
	    <div class="mmth-builder-settings mmplus-builder-megamenu-icons">
	    	<i class="dashicons dashicons-format-gallery"></i> <?php _e('Icons', 'mmplus'); ?>
	    </div>
 	</div>
 	<div class="mmplus-builder-content-wrapper">
 		<!-- Please activate MegaMenu for this menu item. -->
 		<?php if ( $menu_item_depth == 0 ) { ?>
 		<h3 class="activate-megamenu-msg" style="<?php if ( $mmplus_item_megamenu_status == 'active' ) { echo 'display: none;';	} ?>">
 			<?php _e( 'Please activate MegaMenu for this menu item.', 'mmplus' ) ?>	
 		</h3>		
 		<div class="mmplus-builder-content" style="<?php if ( $mmplus_item_megamenu_status == 'inactive' ) { echo 'display: none;';	} ?>">	
 			<div class="mmth-builder">
				<div class="mmplusDraggableWidgetArea">	
			 		<div class="item-widgets-wrap mmth-limit-height">
					   <div id="mmplus_item_layout_wrap">
			 			<div id="mmplus_item_layout_wrap--notices" style="display: none;"></div>
			            <?php  
	
	                      if ( count($mmplus_layout['layout']) ){ 
	                            foreach ($mmplus_layout['layout'] as $layout_key => $layout_value){ ?>
	                                <div class="mmplus-row" data-row-id="<?php echo $layout_key; ?>">

	                                <div class="mmplus-row-actions">
	                                    <div class="mmplus-row-left mmthRowSortingIcon"> <i class="fa fa-sort"></i> <?php  _e('Row', 'mmplus')  ?></div>
	                                    <div class="mmplus-row-right"> 
				 							<span class="mmplus-add-col-btn">
	                                    		<span class="dashicons dashicons-plus">
				 								</span>
				 								<?php _e('Column', 'mmplus') ?> 
				 							</span>
	                                    	<span class="mmthRowDeleteIcon">
	                                    		<i class="fa fa-trash-o"></i> 
	                                    	</span> 
	                                    </div>
	                                <div class="clear"></div>
	                                </div>
	                            <?php
	                                foreach ($layout_value['row'] as $col_key => $layout_col){ ?>

	                                  <div class="mmplus-col mmplus-col-<?php echo $layout_col['col']; ?> " data-col-id="<?php echo $col_key; ?>">

	                                    <div class="mmplus-item-wrap">
	                                        <div class="mmplus-column-actions">
	                                        	<span class="mmplusColSortingIcon"><i class="fa fa-arrows"></i> <?php _e('Column', 'mmplus') ?> 
	                                    		</span>
	                                    		<span class="mmthColDeleteIcon">
	                                    			<i class="fa fa-trash-o"></i> 
	                                    		</span> 
	                                      	</div>
	                             <?php  
	                                    	foreach ( $layout_col['items'] as $key => $value ){
		                                        if ( $value['item_type'] == 'widget' && $value['widget_id'] ){
		                                            
		                                            MMPlus_Widgets::mmplus_widget_items($value['widget_id'], $key);
		                                            
		                                        }elseif ( $value['ID'] ){
		                                            MMPlus_Widgets::mmplus_menu_items( $value, $key ); 
		                                        }
		                                    }					
	                               ?>     
	                                    </div>

	                                    </div>
	                              <?php } ?> 
	                                </div>
	                          <?php } ?> 
	                         <?php } ?>
	                    </div> <!-- #mmplus_item_layout_wrap -->
						
						<div class="megamenu-new-row-add">
				 			<div class="mmplus-add-row-btn">
				 				<span class="dashicons dashicons-plus"></span>
				 				<span class="new-row-btn-text">New Row</span>
				 			</div>
				 		</div>	
				 	</div><!--	item-widgets-wrap mmth-limit-height -->
	            </div> <!-- .mmplusDraggableWidgetArea -->  

		 		<div class="mmplus-builder-config-options-content">
		 			<form method="post" class="mmplus-builder-config-options-data">
						<table>
						  <tr>
						    <td class="mmth-name">
						    	<?php _e('Panel', 'mmplus') ?>
						    </td>
						    <td class="mmth-sett-optn">
						    	<input type="hidden" name="menu_item_id" value="<?php echo $menu_item_id; ?>">
						    	<span class="mega-short-desc"><?php  _e('Width (px, %, em)', 'mmplus');?></span>
						    	<input type="text" name="mmplus_width" value="<?php echo isset( ( $mmth_builder_option['mmplus_width'] ) ) ? $mmth_builder_option['mmplus_width'] : '100%'; ?>">
						    </td>
						    
						  </tr>
						  <tr>
						  <!-- chk box -->
						  	<td class="mmth-name">
                               <?php _e('Panel fit to End-to-End', 'mmplus') ?>
                           </td>
						  <td class="mmth-sett-optn">
						            <span class="mega-short-desc"><?php  _e('Enable', 'mmplus');?></span>
						    	<input type="checkbox" id="mmplus_endtoend" name="mmplus_endtoend" value="end-to-end" <?php if($mmth_builder_option['mmplus_endtoend']=="end-to-end") echo "checked"; ?>>
						    </td>
						</tr>
						  <!-- radio image -->
						  <tr>
						  	<td class="mmth-name">
						  		<?php _e('Panel Alingment', 'mmplus');  ?>
						  	</td>
						  	<td class="mmth-sett-optn">
						  		<label class="mmplus-pannel-alignment">
									<div class="mmth-radio-selector">
									    <input id="panleft" type="radio" name="mmplus-pannel-alignment" value="panleft" />
									    
									    <label class="radio-cc <?php if($mmth_builder_option['mmth_pannel_alignment']=="panleft") echo "active"; ?>" style="background-image: url(<?php echo MMPLUS_PANEL_LEFT ?>);" for="panleft"></label>

									    <input id="panright" type="radio" name="mmplus-pannel-alignment" value="panright" />
									    
									    <label class="radio-cc <?php if($mmth_builder_option['mmth_pannel_alignment']=="panright") echo "active"; ?>" style="background-image: url(<?php echo MMPLUS_PANEL_RIGHT ?>);" for="panright"></label>
									 </div>
						  	   </label>
						  	</td>
						  </tr>
						
						  <tr>
						  	<td class="mmth-name">
						  		<?php _e('Background Image', 'mmplus') ?>
						  	</td>
						  	<td class="mmth-sett-optn">
						  		
							  	<input type="text" id="item-megamenu-bgimage-url" name="mmplus_bg_image" value="<?php echo $mmth_builder_option['mmplus_bg_image']; ?>">
							  	<input type="button" id="set-item-megamenu-bgimage" value="<?php _e('Upload Image', 'mmplus') ?>">
						  		<?php $hidden = empty( $mmth_builder_option['mmplus_bg_image'] ) ? 'hidden' : ''  ?>
						  		<p class="hide-if-no-js <?php echo $hidden; ?>">
						  			<span class="img-ovrlay">
									    <img id="item-megamenu-bgimage-container" src="<?php echo $mmth_builder_option['mmplus_bg_image']; ?>" />
									</span><br>
										<a href="javascript:;" id="remove_mmplus_bg_image">
											<?php _e('Remove Image', 'mmplus') ?>
										</a>
								</p>					 
						  	</td>
						  </tr>
						    <tr>
						  	<td class="mmth-name">
						  		<?php _e('Background Color/Overlay Color', 'mmplus') ?>
						  	</td>
						  	<td class="mmth-sett-optn">
						  		<label class="mmth-mega-bg-color">
						  			<span class="mega-short-desc"><?php  _e('Color', 'mmplus');?></span>
						  		<input type='text' class='color_picker_megamenu' name='mmplus_bg_color' value='<?php echo isset( ( $mmth_builder_option['mmplus_bg_color'] ) ) ? $mmth_builder_option['mmplus_bg_color'] : '#fff'; ?>' style='background:<?php echo isset( ( $mmth_builder_option['mmplus_bg_color'] ) ) ? $mmth_builder_option['mmplus_bg_color'] : '#fff'; ?>' />

						  		
						  	   </label>
						  	</td>
						  </tr>
						  <tr>
						  	<td class="mmth-name">
						  		<?php _e('Panel Padding', 'mmplus'); ?>
						  	</td>
						  	<td class="mmth-sett-optn">
						  		<label class="mmth-mega-pannel-top-padding">
						  			<span class="mega-short-desc"><?php  _e('Top (px)', 'mmplus');?></span>
						  			<input class="mmplus_mega_pannel_padding_top mmth-padding" type="text" name="mmplus_mega_pannel_padding_top" value="<?php echo $mmth_builder_option['mmplus_mega_pannel_padding_top']; ?>">
						  		</label>
						  		<label class="mmth-mega-pannel-right-padding">
						  			<span class="mega-short-desc"><?php  _e('Right (px)', 'mmplus');?></span>
						  			<input class="mmplus_mega_pannel_padding_right mmth-padding" type="text" name="mmplus_mega_pannel_padding_right" value="<?php echo $mmth_builder_option['mmplus_mega_pannel_padding_right']; ?>">
						  		</label>
						  		<label class="mmth-mega-pannel-bottom-padding">
						  			<span class="mega-short-desc"><?php  _e('Bottom (px)', 'mmplus');?></span>
						  				<input class="mmplus_mega_pannel_padding_bottom mmth-padding" type="text" name="mmplus_mega_pannel_padding_bottom" value="<?php echo $mmth_builder_option['mmplus_mega_pannel_padding_bottom']; ?>">
						  		</label>
						  		<label class="mmth-mega-pannel-left-padding">
						  			<span class="mega-short-desc"><?php  _e('Left (px)', 'mmplus');?> </span>
						  			<input class="mmplus_mega_pannel_padding_left mmth-padding" type="text" name="mmplus_mega_pannel_padding_left" value="<?php echo $mmth_builder_option['mmplus_mega_pannel_padding_left']; ?>">
						  		</label>
						  	</td>
						  </tr>
						  <tr>
						  	<td class="mmth-name">
						  		<?php _e('Border', 'mmplus'); ?>
						  	</td>
						  	<td class="mmth-sett-optn">
						  		<label class="mmth-mega-border-color">
						  			<span class="mega-short-desc"><?php  _e('Color', 'mmplus');?></span>
						  			<input type='text' class='color_picker_megamenu' name='mmplus_border_color' value='<?php echo isset( ( $mmth_builder_option['mmplus_border_color'] ) ) ? $mmth_builder_option['mmplus_border_color'] : '#fff'; ?>' style='background:<?php echo isset( ( $mmth_builder_option['mmplus_border_color'] ) ) ? $mmth_builder_option['mmplus_border_color'] : '#fff'; ?>' />
						  		</label>
						 
						  		<label class="mmth-mega-pannel-top-border">
						  			<span class="mega-short-desc"><?php  _e('Top (px)', 'mmplus');?></span>
						  			<input class="mmplus_mega_pannel_border_top mmth-border" type="text" name="mmplus_mega_pannel_border_top" value="<?php echo $mmth_builder_option['mmplus_mega_pannel_border_top']; ?>">
						  		</label>
						  		<label class="mmth-mega-pannel-right-border">
						  			<span class="mega-short-desc"><?php  _e('Right (px)', 'mmplus');?></span>
						  			<input class="mmplus_mega_pannel_border_right mmth-border" type="text" name="mmplus_mega_pannel_border_right" value="<?php echo $mmth_builder_option['mmplus_mega_pannel_border_right']; ?>">
						  		</label>
						  		<label class="mmth-mega-pannel-bottom-border">
						  			<span class="mega-short-desc"><?php  _e('Bottom (px)', 'mmplus');?></span>
						  				<input class="mmplus_mega_pannel_border_bottom mmth-border" type="text" name="mmplus_mega_pannel_border_bottom" value="<?php echo $mmth_builder_option['mmplus_mega_pannel_border_bottom']; ?>">
						  		</label>
						  		<label class="mmth-mega-pannel-left-border">
						  			<span class="mega-short-desc"><?php  _e('Left (px)', 'mmplus');?> </span>
						  			<input class="mmplus_mega_pannel_border_left mmth-border" type="text" name="mmplus_mega_pannel_border_left" value="<?php echo $mmth_builder_option['mmplus_mega_pannel_border_left']; ?>">
						  		</label>
						  	</td>
						  </tr>
						  <tr>
						  	<td class="mmth-name">
						  		<?php _e('Border Radius', 'mmplus'); ?>
						  	</td>
						  	<td class="mmth-sett-optn">
						  		<label class="mmth-mega-pannel-top-left-radius">
						  			<span class="mega-short-desc"><?php  _e('Top (px)', 'mmplus');?></span>
						  			<input class="mmplus_mega_pannel_raidus_top_left mmth-padding" type="text" name="mmplus_mega_pannel_raidus_top_left" value="<?php echo $mmth_builder_option['mmplus_mega_pannel_raidus_top_left']; ?>">
						  		</label>
						  		<label class="mmth-mega-pannel-top-right-radius">
						  			<span class="mega-short-desc"><?php  _e('Right (px)', 'mmplus');?></span>
						  			<input class="mmplus_mega_pannel_raidus_top_right mmth-padding" type="text" name="mmplus_mega_pannel_raidus_top_right" value="<?php echo $mmth_builder_option['mmplus_mega_pannel_raidus_top_right']; ?>">
						  		</label>
						  		<label class="mmth-mega-pannel-bottom-right-radius">
						  			<span class="mega-short-desc"><?php  _e('Bottom (px)', 'mmplus');?></span>
						  				<input class="mmplus_mega_pannel_raidus_bottom_right mmth-padding" type="text" name="mmplus_mega_pannel_raidus_bottom_right" value="<?php echo $mmth_builder_option['mmplus_mega_pannel_raidus_bottom_right']; ?>">
						  		</label>
						  		<label class="mmth-mega-pannel-bottom-left-radius">
						  			<span class="mega-short-desc"><?php  _e('Left (px)', 'mmplus');?> </span>
						  			<input class="mmplus_mega_pannel_raidus_bottom_left mmth-padding" type="text" name="mmplus_mega_pannel_raidus_bottom_left" value="<?php echo $mmth_builder_option['mmplus_mega_pannel_raidus_bottom_left']; ?>">
						  		</label>
						  	</td>
						  </tr>
						  <tr>
						  	<td class="mmth-name">
						  		<?php _e('Column Padding', 'mmplus'); ?>
						  	</td>
						  	<td class="mmth-sett-optn">
						  		<label class="mmth-mega-column-top-padding">
						  			<span class="mega-short-desc"><?php  _e('Top (px)', 'mmplus');?></span>
						  			<input class="mmplus_mega_column_padding_top mmth-padding" type="text" name="mmplus_mega_column_padding_top" value="<?php echo $mmth_builder_option['mmplus_mega_column_padding_top']; ?>">
						  		</label>
						  		<label class="mmth-mega-column-right-padding">
						  			<span class="mega-short-desc"><?php  _e('Right (px)', 'mmplus');?></span>
						  			<input class="mmplus_mega_column_padding_right mmth-padding" type="text" name="mmplus_mega_column_padding_right" value="<?php echo $mmth_builder_option['mmplus_mega_column_padding_right']; ?>">
						  		</label>
						  		<label class="mmth-mega-column-bottom-padding">
						  			<span class="mega-short-desc"><?php  _e('Bottom (px)', 'mmplus');?></span>
						  				<input class="mmplus_mega_column_padding_bottom mmth-padding" type="text" name="mmplus_mega_column_padding_bottom" value="<?php echo $mmth_builder_option['mmplus_mega_column_padding_bottom']; ?>">
						  		</label>
						  		<label class="mmth-mega-column-left-padding">
						  			<span class="mega-short-desc"><?php  _e('Left (px)', 'mmplus');?> </span>
						  			<input class="mmplus_mega_column_padding_left mmth-padding" type="text" name="mmplus_mega_column_padding_left" value="<?php echo $mmth_builder_option['mmplus_mega_column_padding_left']; ?>">
						  		</label>
						  	</td>
						  </tr>
					
						  <tr>
						  	<td class="mmth-name">
						  		<?php _e('Widget', 'mmplus') ?>
						  	</td>
						  	<td class="mmth-sett-optn">
						  		<label class="mmth-mega-widget-title-color">
						  			<span class="mega-short-desc"><?php  _e('Title color', 'mmplus');?></span>
						  		<input type='text' class='color_picker_megamenu' name='mmplus_mmplus_widget_title_color' value='<?php echo isset( ( $mmth_builder_option['mmplus_mmplus_widget_title_color'] ) ) ? $mmth_builder_option['mmplus_border_color'] : '#000'; ?>' style='background:<?php echo isset( ( $mmth_builder_option['mmplus_mmplus_widget_title_color'] ) ) ? $mmth_builder_option['mmplus_border_color'] : '#000'; ?>' />
						  	   </label>
						  	   <label class="mmth-mega-widget-text-color">
						  			<span class="mega-short-desc"><?php  _e('Text', 'mmplus');?></span>
						  		<input type='text' class='color_picker_megamenu' name='mmplus_megamenu_widget_text_color' value='<?php echo isset( ( $mmth_builder_option['mmplus_megamenu_widget_text_color'] ) ) ? $mmth_builder_option['mmplus_megamenu_widget_text_color'] : '#000'; ?>' style='background:<?php echo isset( ( $mmth_builder_option['mmplus_megamenu_widget_text_color'] ) ) ? $mmth_builder_option['mmplus_megamenu_widget_text_color'] : '#000'; ?>' />
						  	   </label>
						  	   <label class="mmth-mega-widget-link-color">
						  			<span class="mega-short-desc"><?php  _e('Link', 'mmplus');?></span>
						  		<input type='text' class='color_picker_megamenu' name='mmplus_megamenu_widget_link_color' value='<?php echo isset( ( $mmth_builder_option['mmplus_megamenu_widget_link_color'] ) ) ? $mmth_builder_option['mmplus_megamenu_widget_link_color'] : '#000'; ?>' style='background:<?php echo isset( ( $mmth_builder_option['mmplus_megamenu_widget_link_color'] ) ) ? $mmth_builder_option['mmplus_megamenu_widget_link_color'] : '#000'; ?>' />
						  	   </label>
						  	   <label class="mmth-mega-widget-linkhvr-color">
						  			<span class="mega-short-desc"><?php  _e('Link Hover', 'mmplus');?></span>
						  		<input type='text' class='color_picker_megamenu' name='mmplus_megamenu_widget_linkhvr_color' value='<?php echo isset( ( $mmth_builder_option['mmplus_megamenu_widget_linkhvr_color'] ) ) ? $mmth_builder_option['mmplus_megamenu_widget_linkhvr_color'] : '#000'; ?>' style='background:<?php echo isset( ( $mmth_builder_option['mmplus_megamenu_widget_linkhvr_color'] ) ) ? $mmth_builder_option['mmplus_megamenu_widget_linkhvr_color'] : '#000'; ?>' />
						  	   </label>
						  	</td>	
						  </tr>
						  
                          <tr>
						  	<td class="mmth-name">
						  		<?php _e('Widget Content Alingment', 'mmplus'); ?>
						  	</td>
						  	<td class="mmth-sett-optn">
						  		<label class="mmplus-pannel-alignment">
									<div class="mmth-radio-selector">
										
									    <input id="left" type="radio" name="mmth-widget-content-alignment" value="left" />
									    <label class="radio-cc <?php if($mmth_builder_option['mmplus_widget_content_alignment']=="left") echo "active"; ?>" style="background-image: url(<?php echo MMPLUS_ALIGN_LEFT ?>);" for="left"></label>

                                        <input id="center" type="radio" name="mmth-widget-content-alignment" value="center" />
									    <label class="radio-cc <?php if($mmth_builder_option['mmplus_widget_content_alignment']=="center") echo "active"; ?>" style="background-image: url(<?php echo MMPLUS_ALIGN_CENTER ?>);" for="center"></label>

									    <input id="right" type="radio" name="mmth-widget-content-alignment" value="right" /> 
									    <label class="radio-cc <?php if($mmth_builder_option['mmplus_widget_content_alignment']=="right") echo "active"; ?>" style="background-image: url(<?php echo MMPLUS_ALIGN_RIGHT ?>);" for="right"></label>

									    
									 </div>
						  	   </label>
						  	</td>
						  </tr>


						  	  <tr>
						  	<td class="mmth-name"><?php 
	                        	submit_button( 
	                        					__( 'Save' ), 
	                        					'button-primary alignleft mmth-builder-options-submit', 
	                        					'mmplus_builder_options', 
	                        					false 
	                        				);
                            ?></td>
						  	<td class="mmth-sett-optn">
	                        
						  	</td>
						  </tr>
						</table>
					</form>
		 		</div>
	            <div class="mmplus-icons-container">
	                <div class="mmplus-icons-menu">
	                    <div class="mmplus-icons-topbar-left">
	                        <ul>
	                            <li>
	                            	<a href="#icons-tabs-1" class='icon-tabs-nav active' data-icon-tabs='icons-tabs-1'>
	                            		<?php _e('Dashicons', 'mmplus'); ?>
	                            	</a>
	                            </li>
	                            <li>
	                            	<a href="#icons-tabs-2" class='icon-tabs-nav' data-icon-tabs='icons-tabs-2'>
	                            		<?php _e('Font Awesome', 'mmplus'); ?>    		
	                            	</a>
	                            </li>
	                            <li>
	                            	<a href="#icons-tabs-3" class='icon-tabs-nav' data-icon-tabs='icons-tabs-3'>
	                            		<?php _e('IcoFont', 'mmplus'); ?>		
	                            	</a>
	                            </li>
	                        </ul>
	                    </div>

	                    <div class="mmplus-icons-topbar-right">
	                        <div class="mmth-icon-search-wrap">
	                            <input id="mmplus_icons_search" type="text" value="" placeholder="<?php _e('Search...', 'mmplus'); ?>">
	                            <i class="fa fa-search"></i>
	                        </div>
	                    </div>

	                    <div class="clear"></div>
	                </div>

	                <div class="mmplus-icons-tab-content mmth-limit-height">

	                    <div id="icons-tabs-1">
	                        <?php
	                        $dashicons = mmplus_dashicons();

	                        $current_icon = '';
	                        if ( ! empty($mmth_builder_option['icon'])){
	                            $current_icon = $mmth_builder_option['icon'];
	                        }
	                        echo "<a href='javascript:;' class='mmplus-icons' data-icon='' title=''>&nbsp;</a>";
	                        foreach ($dashicons as $di_key => $di_name){
	                            $selected_icon = ($current_icon == 'dashicons '.$di_key) ? 'mmplus-icon-selected' :'';
	                            echo "<a href='javascript:;' class='mmplus-icons {$selected_icon} ' data-icon='dashicons {$di_key}' title='{$di_name}'>
	                            <i class='dashicons {$di_key}'></i></a>";
	                        }
	                        ?>
	                    </div>

	                    <div id="icons-tabs-2">
	                        <?php
	                        // $font_awesome = mmth_font_awesome();
	                        echo "<span class='mmplus-megamenu-pro'><i class='dashicons dashicons-lock'></i> This is available in Pro version</span>";
	                        
	                        ?>
	                    </div>	

	                    <div id="icons-tabs-3">
                            <?php
                            // $icofonts = mmth_icofont();
                             echo "<span class='mmplus-megamenu-pro'><i class='dashicons dashicons-lock'></i> This is available in Pro version</span>";
                            ?>
                        </div>	        
	                </div>
	            </div>

	 		</div><!-- .mmth-builder  -->

	 		<?php }else {?>
	 			<div class="mmth-no-mega-menu">
	 				<?php _e('Mega Menu will only work on top level menu items.', 'mmplus') ?>
	 			</div>
		 		<?php } ?>
 		</div>	
 	</div>
 </div>