<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
	<div class="nav-wrap">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php bloginfo( 'name' ); ?>">
			<img src="<?php echo brics_modern_img( '2024/02/Brics-logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
		</a>
		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-navigation" aria-label="Open navigation">
			<span></span>
			<span></span>
			<span></span>
		</button>
		<?php brics_modern_primary_menu_fallback(); ?>
		<a class="nav-cta" href="<?php echo esc_url( brics_modern_page_url( 'contact' ) ); ?>">Talk to us</a>
	</div>
</header>
<main id="content">
