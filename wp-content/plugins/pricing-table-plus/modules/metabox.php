<?php
/* Define the custom box */



// backwards compatible (before WP 3.0)
// add_action( 'admin_init', 'myplugin_add_custom_box', 1 );

/* Do something with the data entered */


/* Adds a box to the main column on the Post and Page edit screens */

function wpptp_add_custom_box() {
    add_meta_box( 'pricing-table-plus-feature-options', __( 'Packages/Features', 'wppt' ), 'wpptp_individual_features', 'pricing-table-plus', 'normal','core' );
}


function wpptp_individual_features( $post ) {
    global $pricingtablepluss_plugin;     
    include($pricingtablepluss_plugin->plugin_dir."/tpls/metabox-feature-options.php");
}

function wpptp_save_pricing_table( $post_id ) {
     
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( !current_user_can( 'edit_post', $post_id ) ) return;


	if(isset($_POST['features']) && $_POST['features']){
		update_post_meta($post_id,'pricing_table_for_post',$_POST['features']);
	//if($_POST['features']){
		update_post_meta($post_id,'pricing_table_opt',$_POST['features']);
		update_post_meta($post_id,'pricing_table_opt_feature',$_POST['featured']); 
	}
  
}

 
add_action( 'add_meta_boxes', 'wpptp_add_custom_box');
add_action( 'save_post', 'wpptp_save_pricing_table' );  