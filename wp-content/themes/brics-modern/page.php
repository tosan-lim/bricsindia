<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$slug         = get_post_field( 'post_name', get_the_ID() );
	$profile      = brics_modern_page_profile( $slug );
	$service_data = brics_modern_service_page_data( $slug );
	?>
	<section class="modern-page-hero">
		<div class="section-inner modern-page-grid">
			<div>
				<div class="eyebrow"><?php echo esc_html( $profile['kicker'] ); ?></div>
				<h1><?php echo esc_html( $profile['headline'] ); ?></h1>
				<p><?php echo esc_html( $profile['description'] ); ?></p>
			</div>
			<div class="page-visual">
				<img src="<?php echo brics_modern_img( $profile['image'] ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
				<div class="page-points">
					<?php foreach ( $profile['points'] as $point ) : ?>
						<span><?php echo esc_html( $point ); ?></span>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<?php if ( $service_data ) : ?>
		<?php brics_modern_render_service_page( $service_data ); ?>
	<?php else : ?>
		<section class="page-content premium-page-content">
			<div class="section-inner">
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-panel' ); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
			</div>
		</section>
	<?php endif; ?>

	<section class="band page-cta-band">
		<div class="section-inner contact-strip">
			<div>
				<div class="section-kicker">BRICS India</div>
				<h2 class="section-title">Need help choosing the right trade path?</h2>
				<p>Talk to the BRICS India team about product category, import stage and Indian market goals.</p>
			</div>
			<a class="button secondary" href="<?php echo esc_url( brics_modern_page_url( 'contact' ) ); ?>">Send enquiry</a>
		</div>
	</section>
	<?php
endwhile;

get_footer();
