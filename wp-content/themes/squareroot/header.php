<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Squareroot
 */
global $squareroot_data;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="shortcut icon" href="https://danieljamescarr.com/wp-content/uploads/2015/11/favicon2.png" type="image/x-icon" />
	<?php
	wp_head();
	?>
</head>

<body <?php body_class(); ?>>
<!-- Preloader Start-->
<?php if ( isset( $squareroot_data['show_perload'] ) && $squareroot_data['show_perload'] == 1) {?>
	<div id="preload">
		<img src="<?php echo get_template_directory_uri(); ?>/images/preload.gif" alt="preload">
	</div>
<?php }?>
<!-- Preloader End -->
<?php 
	if ($squareroot_data['header_layout'] == "header_v1" || $squareroot_data['header_layout'] == "header_v3")
		get_template_part( '/inc/header/'.$squareroot_data['header_layout'] ); 
?>
