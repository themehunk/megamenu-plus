<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access.
}
    $selected_nav =  ! empty( $_REQUEST['menu'] ) ? (int) $_REQUEST['menu'] : 0;
    if ( ! $selected_nav){
    	$selected_nav = absint( get_user_option( 'nav_menu_recently_edited' ) );
    }
?>
 <div class="megamenu-plus-metabox"> 	      
    <div class="mmplus_themes_response"></div>
      <?php
		$get_attached_location_with_menu = mmplus_get_attached_location_with_menu( $selected_nav );
		$current_location = '';
		if ( ! empty( $get_attached_location_with_menu ) ) {
			foreach ( $get_attached_location_with_menu as $current_location => $location_name ){
                $mmth_nav_location_settings = get_mmplus_option( $current_location );
			?>
            <div class="mmplus-menu-meta-box-wrapper">
                <p><?php _e( $location_name, 'mmplus' ); ?></p>
                            
                <div class="mmplus-menu-meta-box-data">
                    
                    <input type="hidden" name="nav_menu_recently_edited_id" value="<?php echo $selected_nav; ?>">
                    <input type="hidden" name="mmplus_nav_settings[<?php echo $current_location; ?>][menu_location]" value="<?php echo $current_location; ?>">

                    <input type='checkbox' class='mmplus_is_enabled' name='mmplus_nav_settings[<?php echo $current_location; ?>][is_enabled]' value='1' <?php checked( isset($mmth_nav_location_settings['is_enabled']) ); ?> />
                </div>
            </div>

	<?php }   submit_button( __( 'Save' ), 'mmplus-mega-menu-save button-primary alignright' ); ?>
                <span class='spinner'></span>
   <?php }else {
			?>
            <div class="mmth-notice-warning">
                <p>
					<?php _e( 'This menu is not in any location, please set a location first', 'mmplus' ); ?>
                </p>
            </div>
	</div>	
	<?php	}	?>
            
