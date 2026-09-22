<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<section class="page-hero">
	<div class="section-inner">
		<div class="eyebrow"><?php bloginfo( 'name' ); ?></div>
		<h1><?php bloginfo( 'description' ); ?></h1>
	</div>
</section>
<section class="page-content">
	<div class="section-inner">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="entry-content"><?php the_excerpt(); ?></div>
				</article>
				<?php
			endwhile;
		endif;
		?>
	</div>
</section>
<?php
get_footer();
