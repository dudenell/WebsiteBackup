<?php 
/*
Plugin Name: Pricing Table Plus
Plugin URI: http://wpbriz.com
Description: Generate Pricing Table easily. Use simple short-code <strong>[pricing-table id=123]</strong> ( <strong>123</strong> = use any table id here) inside page or post content to embed Pricing Table. This is a fork of Pricing Table plugin (by Shaon) with lots of tweaks & improvements for better UI/UX and performance.
Author: wpBriz
Version: 1.1
Author URI: http://wpbriz.com
*/

include("libs/class.plugin.php");
global $pricingtablepluss_plugin, $pricingtablepluss_enque;

$pricingtablepluss_enque = 0;

$pricingtablepluss_plugin = new wpptp_plugin('pricing-table-plus');


$plugindir = str_replace('\\','/',dirname(__FILE__));
 

defined('PLUGINDIR') OR define('PLUGINDIR' ,$plugindir);  

 

function wpptp_custom_init() 
{
  
  load_plugin_textdomain( 'pricing-table-plus', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 

  $labels = array(
	'name' => _x('Pricing Table+', 'pricing-table-plus'),
	'singular_name' => _x('Pricing Table+', 'pricing-table-plus'),
	'add_new' => _x('Add New', 'pricing-table-plus','pricing-table-plus'),
	'add_new_item' => __('Add New Pricing Table','pricing-table-plus'),
	'edit_item' => __('Edit Pricing Table','pricing-table-plus'),
	'new_item' => __('New Pricing Table','pricing-table-plus'),
	'all_items' => __('All Pricing Table','pricing-table-plus'),
	'view_item' => __('View Pricing Table','pricing-table-plus'),
	'search_items' => __('Search Pricing Table','pricing-table-plus'),
	'not_found' =>  __('No Pricing Table found','pricing-table-plus'),
	'not_found_in_trash' => __('No Pricing Table found in Trash','pricing-table-plus'), 
	'parent_item_colon' => '',
	'menu_name' => 'Pricing Table+'

  );
  $args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true, 
	'show_in_menu' => true, 
	'query_var' => true,
	'rewrite' => true,
	'capability_type' => 'post',
	'has_archive' => true, 
	'hierarchical' => false,
	'menu_position' => null,
	'supports' => array('title'),
	'menu_icon' => plugins_url().'/pricing-table-plus/images/table.gif'
  ); 
  register_post_type('pricing-table-plus',$args);
}


function wpptp_table($params){
	 $pid = $params['id'];
	 $template = isset($params['template'])?$params['template']:'green'; 
	 $currency = isset($params['currency'])&&$params['currency']!=''?$params['currency']:'$';   
	 ob_start();
	 include("tpls/price_table-$template.php"); 
	 $data = ob_get_clean();			 
	 $data = str_replace(array("\n","\r","[y]","[n]"),array("","","<img src='".plugins_url('/pricing-table-plus/images/tick.png')."' />","<img src='".plugins_url('/pricing-table-plus/images/cross.png')."' />"),$data);
	 return $data;
}

function wpptp_help(){
	include("tpls/help.php");
}

function wpptp_menu(){
	add_submenu_page('edit.php?post_type=pricing-table-plus', 'Help', 'Help', 'administrator', 'help', 'wpptp_help');	
	
}


function wpptp_columns_struct( $columns ) {	 
	$column_shorcode = array( 'shortcode' => __('Embed Code','pricing-table-plus') );	
	$columns = array_slice( $columns, 0, 2, true ) + $column_shorcode + array_slice( $columns, 2, NULL, true );
	return $columns;
}

function wpptp_column_obj( $column ) {
	global $post;
	switch ( $column ) {	   
		case 'shortcode':
			echo "<input type=text readonly=readonly value='[pricing-table id={$post->ID} template=\"gray\" currency=\"\$\"]' size=35 style='font-weight:bold;text-align:Center;' onclick='this.select()' />";
			echo "<input type=text readonly=readonly value='[pricing-table id={$post->ID} template=\"green\" currency=\"\$\"]' size=35 style='font-weight:bold;text-align:Center;' onclick='this.select()' />";
			echo "<input type=text readonly=readonly value='[pricing-table id={$post->ID} template=\"smooth\" currency=\"\$\"]' size=35 style='font-weight:bold;text-align:Center;' onclick='this.select()' />";
			break;
	}
}
 
 if(is_admin()){
	 add_action("admin_menu","wpptp_menu");
 } 

function wpptp_live_preview($content){
	global $post, $pricingtablepluss_enque;
	$pricingtablepluss_enque = 1;
	wpptp_enqueue_scripts();
	if(get_post_type()!='pricing-table-plus') return $content;
	echo do_shortcode("[pricing-table id={$post->ID}]");
}

function wpptp_admin_enqueue_scripts(){	
	wp_enqueue_script("jquery");
	if(get_post_type()=='pricing-table-plus')
	wp_enqueue_script("jquery-dragtable",plugins_url('/pricing-table-plus/js/admin/dragtable.js'),array('jquery'));
	
}

function wpptp_enqueue_scripts(){   
	global $pricingtablepluss_enque; 
	wp_enqueue_script("jquery");	
	if($pricingtablepluss_enque==1){		
		wp_enqueue_script("tiptipjs", plugins_url()."/pricing-table-plus/js/site/jquery.tipTip.minified.js",array('jquery'));
		wp_enqueue_style("tiptipcss", plugins_url()."/pricing-table-plus/css/site/tipTip.css");
	}
}

function wpptp_tiptip_init(){
	global $pricingtablepluss_enque; 
	 
	if($pricingtablepluss_enque==1){		
	?>
		<script language="JavaScript"> 
		  jQuery(function(){
						jQuery(".wppttip").tipTip({defaultPosition:'right'});
					});
		 
		</script>
	<?php
	}
}

 
function wpptp_detect_shortcode()
{
	global $post, $pricingtablepluss_enque;
	$pattern = get_shortcode_regex();
	if(isset($post->post_content)){
		if ( preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
			&& array_key_exists( 2, $matches )
			&& in_array( 'pricing-table', $matches[2] ) )
		{
			$pricingtablepluss_enque = 1;
		}
	}
}

$pricingtablepluss_plugin->load_modules();

add_action( 'wp', 'wpptp_detect_shortcode' ); 
add_action('wp_enqueue_scripts', 'wpptp_enqueue_scripts');  
add_action('admin_enqueue_scripts', 'wpptp_admin_enqueue_scripts'); 
add_action('wp_footer', 'wpptp_tiptip_init'); 
add_action('init', 'wpptp_custom_init'); 
add_shortcode("pricing-table",'wpptp_table');
add_filter( 'manage_edit-pricing-table-plus_columns', 'wpptp_columns_struct', 10, 1 );
add_filter( 'the_content', 'wpptp_live_preview');
add_action( 'manage_posts_custom_column', 'wpptp_column_obj', 10, 1 );
