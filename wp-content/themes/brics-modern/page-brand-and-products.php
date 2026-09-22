<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$brand_cards = array(
	array( 'name' => 'KGC', 'type' => 'Health & wellness', 'image' => '2024/02/Kgc-1-150x150.jpg' ),
	array( 'name' => 'KC', 'type' => 'Brand partnership', 'image' => '2026/05/kc-logo.png' ),
	array( 'name' => 'NDK Foods', 'type' => 'Instant food and seaweed', 'image' => '2024/02/ndk-150x150.jpg' ),
	array( 'name' => 'Samyang Foods', 'type' => 'Korean noodles and sauces', 'image' => '2024/02/Samyang-foods-150x150.png' ),
	array( 'name' => 'WLMX', 'type' => 'Consumer products', 'image' => '2024/02/wlmx-150x150.jpg' ),
);

$food_products = array(
	array( 'name' => 'Buldak Jjajang Multi', 'image' => '2024/02/BULDAK-JJAJANGMULTI-300x300.jpg' ),
	array( 'name' => 'Buldak Curry Ramen', 'image' => '2024/02/buldak-curry-ramen0-300x300.jpg' ),
	array( 'name' => 'Buldak Sauce', 'image' => '2024/02/buldak-sauce-2023-08-04-143021-3-e1693220641769-300x300.png' ),
	array( 'name' => 'Buldak Toppoki', 'image' => '2024/02/BULDAK-TOKPOKKI-1-300x298.png' ),
	array( 'name' => 'Samyang Original', 'image' => '2024/02/samyang-original-scaled-1-267x300.jpeg' ),
	array( 'name' => 'Kimchi', 'image' => '2024/02/kimchi-280x300.jpeg' ),
	array( 'name' => 'K-Gim Seaweed', 'image' => '2024/02/k-gim-261x300.jpg' ),
	array( 'name' => 'K-Gim Mini', 'image' => '2024/02/k-gim-mini-237x300.jpg' ),
	array( 'name' => 'Instant Retort Curry', 'image' => '2024/02/Instant-Retort-Curry-1.jpg' ),
	array( 'name' => 'KGC Everytime', 'image' => '2024/02/kgc-extract-eveytime-300x300.jpg' ),
	array( 'name' => 'KGC Powder', 'image' => '2024/02/kgc-powder-300x300.jpg' ),
	array( 'name' => 'Cheong Kwan Jang', 'image' => '2024/02/DHL-express-KGC-Cheong-Kwan-Jang-Korean-6-Years-_1-1-300x300.jpg' ),
	array( 'name' => 'Korean Coffee', 'image' => '2024/02/dongsuh-maxim-e1693220217357-300x300.webp' ),
);

$other_products = array(
	array( 'name' => 'Shower Towel', 'image' => '2024/02/258-Shower-Towel-Face-Body-200x200-1.jpg' ),
	array( 'name' => 'Chopsticks', 'image' => '2024/02/Chopsticks-300x200.jpg' ),
	array( 'name' => 'Rubber Gloves', 'image' => '2024/02/HOOK-TYPE-RUBBER-GLOVE-S-238x300.jpg' ),
	array( 'name' => 'WLMX Product', 'image' => '2024/02/wlmx-200x300.jpg' ),
	array( 'name' => 'NDK Product', 'image' => '2024/02/ndk1-200x300.jpg' ),
);
?>
<section class="brand-products-hero">
	<div class="section-inner brand-products-hero-grid">
		<div>
			<div class="eyebrow">Brands & Products</div>
			<h1>Korean brands and product categories ready for Indian channels.</h1>
			<p>Explore the Korean food, wellness and consumer products BRICS India supports through import, distribution, retail, ecommerce and buyer conversations in Delhi and across India.</p>
			<div class="hero-actions">
				<a class="button" href="<?php echo esc_url( brics_modern_page_url( 'contact' ) ); ?>">Enquire for products</a>
				<a class="button secondary" href="#product-pantry">View products</a>
			</div>
		</div>
		<div class="brand-products-hero-wall">
			<img src="<?php echo brics_modern_img( '2024/02/Samyang--768x578.jpg' ); ?>" alt="Samyang Korean food products">
			<img src="<?php echo brics_modern_img( '2024/02/Kgc-1-683x1024.jpg' ); ?>" alt="KGC Korean wellness product">
			<img src="<?php echo brics_modern_img( '2026/05/kc-logo.png' ); ?>" alt="KC partner brand">
		</div>
	</div>
</section>

<section class="band brand-partners-section">
	<div class="section-inner">
		<div class="section-kicker">Our Partner Brands</div>
		<h2 class="section-title">Brand partners and product families we work with.</h2>
		<p class="section-copy">The goal is not only to display products, but to make them easier for Indian buyers, distributors and retail partners in Delhi NCR and wider India to understand.</p>
		<div class="partner-brand-grid">
			<?php foreach ( $brand_cards as $brand ) : ?>
				<article class="partner-brand-card">
					<img src="<?php echo brics_modern_img( $brand['image'] ); ?>" alt="<?php echo esc_attr( $brand['name'] ); ?>">
					<h3><?php echo esc_html( $brand['name'] ); ?></h3>
					<p><?php echo esc_html( $brand['type'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="product-pantry" class="band soft product-showcase-section">
	<div class="section-inner product-showcase-heading">
		<div>
			<div class="section-kicker">Food Pantry</div>
			<h2 class="section-title">Korean food and wellness products.</h2>
		</div>
		<p class="section-copy">Directly from Korea: authentic products imported and positioned for Indian wholesale, retail and ecommerce opportunities.</p>
	</div>
	<div class="section-inner product-grid">
		<?php foreach ( $food_products as $product ) : ?>
			<article class="product-card">
				<img src="<?php echo brics_modern_img( $product['image'] ); ?>" alt="<?php echo esc_attr( $product['name'] ); ?>">
				<h3><?php echo esc_html( $product['name'] ); ?></h3>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<section class="band product-showcase-section">
	<div class="section-inner product-showcase-heading">
		<div>
			<div class="section-kicker">Beauty & Other</div>
			<h2 class="section-title">Consumer and lifestyle product categories.</h2>
		</div>
		<p class="section-copy">Selected Korean household, beauty and daily-use items can be prepared for category review and buyer discussions.</p>
	</div>
	<div class="section-inner product-grid compact">
		<?php foreach ( $other_products as $product ) : ?>
			<article class="product-card">
				<img src="<?php echo brics_modern_img( $product['image'] ); ?>" alt="<?php echo esc_attr( $product['name'] ); ?>">
				<h3><?php echo esc_html( $product['name'] ); ?></h3>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<section class="band page-cta-band">
	<div class="section-inner contact-strip">
		<div>
			<div class="section-kicker">Product Enquiry</div>
			<h2 class="section-title">Want to discuss a Korean product category?</h2>
			<p>Send product details or buyer requirements. The BRICS India team will review the best import, distribution or trade route.</p>
		</div>
		<a class="button secondary" href="<?php echo esc_url( brics_modern_page_url( 'contact' ) ); ?>">Send enquiry</a>
	</div>
</section>
<?php
get_footer();
