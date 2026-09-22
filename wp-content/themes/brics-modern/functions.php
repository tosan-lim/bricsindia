<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function brics_modern_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'brics-modern' ),
		)
	);
}
add_action( 'after_setup_theme', 'brics_modern_setup' );

function brics_modern_assets() {
	wp_enqueue_style( 'brics-modern-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap', array(), null );
	wp_enqueue_style( 'brics-modern-style', get_stylesheet_uri(), array( 'brics-modern-fonts' ), '2.1.3' );
	wp_register_script( 'brics-modern-nav', '', array(), '1.0.0', true );
	wp_enqueue_script( 'brics-modern-nav' );
	wp_add_inline_script(
		'brics-modern-nav',
		"(function(){var header=document.querySelector('.site-header');var toggle=document.querySelector('.nav-toggle');var nav=document.querySelector('.main-nav');if(!header||!toggle||!nav){return;}nav.id='primary-navigation';function setOpen(open){header.classList.toggle('nav-open',open);toggle.setAttribute('aria-expanded',open?'true':'false');toggle.setAttribute('aria-label',open?'Close navigation':'Open navigation');document.body.classList.toggle('nav-lock',open);}toggle.addEventListener('click',function(){setOpen(!header.classList.contains('nav-open'));});nav.addEventListener('click',function(event){var link=event.target.closest('a');if(link&&window.matchMedia('(max-width: 920px)').matches){setOpen(false);}});document.addEventListener('keydown',function(event){if(event.key==='Escape'){setOpen(false);}});window.addEventListener('resize',function(){if(!window.matchMedia('(max-width: 920px)').matches){setOpen(false);}});}());"
	);
}
add_action( 'wp_enqueue_scripts', 'brics_modern_assets' );

function brics_modern_img( $path ) {
	return esc_url( content_url( 'uploads/' . ltrim( $path, '/' ) ) );
}

function brics_modern_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . trim( $slug, '/' ) . '/' );
}

function brics_modern_primary_menu_fallback() {
	echo '<div class="main-nav">';
	echo '<a class="nav-link" href="' . esc_url( home_url( '/' ) ) . '">Home</a>';
	echo '<a class="nav-link" href="' . esc_url( brics_modern_page_url( 'about-us' ) ) . '">About</a>';
	echo '<div class="nav-dropdown">';
	echo '<a class="nav-link nav-dropdown-toggle" href="' . esc_url( brics_modern_page_url( 'business-area' ) ) . '">Business Area <span class="dropdown-caret" aria-hidden="true"></span></a>';
	echo '<div class="nav-dropdown-menu">';
	echo '<a href="' . esc_url( brics_modern_page_url( 'trade-matchmaking' ) ) . '"><strong>Trade &amp; Matchmaking</strong><span>Buyer mapping and business introductions</span></a>';
	echo '<a href="' . esc_url( brics_modern_page_url( 'brand-and-products' ) ) . '"><strong>Brand and Products</strong><span>Korean products for Indian channels</span></a>';
	echo '<a href="' . esc_url( brics_modern_page_url( 'consultation' ) ) . '"><strong>Taxation &amp; Licensing</strong><span>Compliance and import documentation</span></a>';
	echo '<a href="' . esc_url( brics_modern_page_url( 'sales-distribution-marketing' ) ) . '"><strong>Sales &amp; Marketing</strong><span>Distribution and demand building</span></a>';
	echo '</div>';
	echo '</div>';
	echo '<a class="nav-link" href="' . esc_url( brics_modern_page_url( 'contact' ) ) . '">Contact</a>';
	echo '</div>';
}

function brics_modern_page_profile( $slug ) {
	$profiles = array(
		'about-us' => array(
			'kicker'      => 'Company Profile',
			'headline'    => 'A practical bridge between Korean ambition and Indian market reality.',
			'description' => 'BRICS India Trade Pvt. Ltd. supports Korean companies with import, distribution, ecommerce and on-ground trade execution from New Delhi.',
			'image'       => '2021/11/about-us-2-min.jpg',
			'points'      => array( 'Established in New Delhi', 'Korean product import expertise', 'Retail and ecommerce orientation' ),
		),
		'business-area' => array(
			'kicker'      => 'Business Areas',
			'headline'    => 'One operating partner for sourcing, import, distribution and growth.',
			'description' => 'A coordinated service model for brands that need clarity, compliant execution and reliable market access in India.',
			'image'       => '2024/02/topic_trade-analysis.jpg',
			'points'      => array( 'Import planning', 'Wholesale distribution', 'Market development' ),
		),
		'brand-and-products' => array(
			'kicker'      => 'Brands & Products',
			'headline'    => 'Korean products positioned for Indian buyers, retailers and partners.',
			'description' => 'Food, wellness and lifestyle products are presented through cleaner brand storytelling and stronger product visuals.',
			'image'       => '2024/02/Samyang--768x578.jpg',
			'points'      => array( 'K-food', 'Wellness products', 'Brand partnerships' ),
		),
		'trade-matchmaking' => array(
			'kicker'      => 'Trade Matchmaking',
			'headline'    => 'Find the right business partners before you scale.',
			'description' => 'BRICS India helps connect Korean businesses with distributors, buyers, retailers and service partners in India.',
			'image'       => '2024/02/seoul-scaled.jpg',
			'points'      => array( 'Buyer mapping', 'Distributor introductions', 'B2B coordination' ),
		),
		'consultation' => array(
			'kicker'      => 'Taxation & Licensing',
			'headline'    => 'Cleaner compliance paths for import-led businesses.',
			'description' => 'Guidance for licensing, documentation, taxation and practical business requirements for Korean products entering India.',
			'image'       => '2021/11/service-2.jpg',
			'points'      => array( 'Import documents', 'Licensing guidance', 'Taxation support' ),
		),
		'sales-distribution-marketing' => array(
			'kicker'      => 'Sales & Marketing',
			'headline'    => 'Turn market entry into repeatable demand.',
			'description' => 'Distribution and marketing support for brands that need retail visibility, ecommerce readiness and buyer confidence.',
			'image'       => '2024/02/Samyang--768x578.jpg',
			'points'      => array( 'Retail placement', 'Ecommerce support', 'Sales planning' ),
		),
		'brands-and-marketing' => array(
			'kicker'      => 'Brand Marketing',
			'headline'    => 'Make Korean brands feel local without losing their origin story.',
			'description' => 'Brand positioning, market messaging and channel support tailored to Indian customers and trade partners.',
			'image'       => '2024/02/Kgc-1-683x1024.jpg',
			'points'      => array( 'Brand story', 'Channel content', 'Campaign support' ),
		),
		'contact' => array(
			'kicker'      => 'Contact',
			'headline'    => 'Tell us what you want to bring into the Indian market.',
			'description' => 'Share your product category, company details and target market. The enquiry will be routed to bricsindia@gmail.com.',
			'image'       => '2021/11/about-us-min.jpg',
			'points'      => array( 'New Delhi office', 'Email response', 'Business enquiry support' ),
		),
	);

	return isset( $profiles[ $slug ] ) ? $profiles[ $slug ] : array(
		'kicker'      => 'BRICS India',
		'headline'    => get_the_title(),
		'description' => 'Explore BRICS India Trade Pvt. Ltd. services for Korean imports, distribution and trade consulting in India.',
		'image'       => '2024/02/seoul-scaled.jpg',
		'points'      => array( 'Import support', 'Distribution', 'Consulting' ),
	);
}

function brics_modern_service_pages() {
	return array(
		'business-area' => array(
			'label'       => 'Business Areas',
			'headline'    => 'A complete operating system for Korean companies entering India.',
			'intro'       => 'BRICS India brings import planning, trade matchmaking, product representation, taxation support, licensing guidance, sales distribution and local marketing into one practical service model from New Delhi for companies targeting India.',
			'image'       => '2024/02/topic_trade-analysis.jpg',
			'services'    => array(
				array( 'title' => 'Trade & Matchmaking', 'text' => 'Identify buyers, distributors, retailers and B2B partners that fit the product category and growth stage.', 'slug' => 'trade-matchmaking' ),
				array( 'title' => 'Brand and Products', 'text' => 'Position Korean food, wellness and consumer products for Indian wholesale, retail and ecommerce channels.', 'slug' => 'brand-and-products' ),
				array( 'title' => 'Taxation & Licensing', 'text' => 'Support documentation, import readiness, FSSAI orientation, licensing steps and taxation coordination.', 'slug' => 'consultation' ),
				array( 'title' => 'Sales & Marketing', 'text' => 'Build sales routes through retail placement, ecommerce, distributor follow-up and market communication.', 'slug' => 'sales-distribution-marketing' ),
			),
			'process'     => array( 'Market fit review', 'Import and compliance planning', 'Partner shortlist', 'Channel launch support', 'Ongoing sales coordination' ),
			'keywords'    => array( 'Korean product importer in Delhi', 'India Korea trade consulting', 'Korean brand distribution India', 'market entry support India' ),
			'local'       => 'Based in New Delhi, BRICS India supports Korean companies that need import, distribution, licensing, buyer matching and sales coordination across Delhi NCR and wider India.',
		),
		'trade-matchmaking' => array(
			'label'       => 'Trade & Matchmaking',
			'headline'    => 'Find reliable Indian buyers, distributors and retail partners before you scale.',
			'intro'       => 'Our trade matchmaking service helps Korean companies reduce guesswork by mapping the right Indian business partners, preparing outreach and coordinating practical B2B conversations in Delhi NCR and across India.',
			'image'       => '2024/02/seoul-scaled.jpg',
			'services'    => array(
				array( 'title' => 'Buyer Mapping', 'text' => 'Shortlist importers, wholesalers, retailers and category-specific business contacts.' ),
				array( 'title' => 'Distributor Introductions', 'text' => 'Connect with distribution partners based on product category, geography and channel readiness.' ),
				array( 'title' => 'Meeting Coordination', 'text' => 'Prepare product decks, samples, commercial context and follow-up structure for B2B meetings.' ),
				array( 'title' => 'Market Feedback', 'text' => 'Collect practical feedback on price, packaging, demand, compliance and sales channel fit.' ),
			),
			'process'     => array( 'Product and target review', 'Indian partner research', 'Shortlist and outreach', 'B2B meeting support', 'Follow-up and next steps' ),
			'keywords'    => array( 'India Korea business matchmaking', 'trade matchmaking Delhi', 'Korean companies Indian buyers', 'distributor search India' ),
			'local'       => 'For businesses searching for buyer matching, distributor search or India Korea trade partners in Delhi, BRICS India helps create a practical shortlist and follow-up route.',
		),
		'brand-and-products' => array(
			'label'       => 'Brand and Products',
			'headline'    => 'Present Korean brands and products clearly for Indian buyers.',
			'intro'       => 'BRICS India supports Korean food, wellness and consumer brands with product positioning, catalogue readiness, channel selection and representation for Indian trade opportunities.',
			'image'       => '2024/02/Samyang--768x578.jpg',
			'services'    => array(
				array( 'title' => 'Product Positioning', 'text' => 'Clarify product story, use case, pricing logic and buyer value for the Indian market.' ),
				array( 'title' => 'Brand Representation', 'text' => 'Represent selected Korean brands in trade discussions, buyer meetings and channel conversations.' ),
				array( 'title' => 'Catalogue Readiness', 'text' => 'Organize product images, descriptions, SKU details, packaging data and buyer-facing material.' ),
				array( 'title' => 'Channel Fit', 'text' => 'Assess whether products are better suited for wholesale, retail, ecommerce or B2B distribution.' ),
			),
			'process'     => array( 'Brand review', 'SKU and compliance check', 'Catalogue preparation', 'Buyer presentation', 'Channel development' ),
			'keywords'    => array( 'Korean brands in India', 'Korean products Delhi', 'K-food distribution India', 'brand representation India' ),
			'local'       => 'From New Delhi, BRICS India helps Korean food, wellness and consumer product brands prepare product stories, catalogues and buyer discussions for Indian channels.',
		),
		'consultation' => array(
			'label'       => 'Taxation & Licensing',
			'headline'    => 'Make import, licensing and taxation decisions with clearer local guidance.',
			'intro'       => 'For Korean products entering India, documentation and compliance can decide the speed of launch. BRICS India helps companies understand the practical requirements before committing time and money.',
			'image'       => '2021/11/service-2.jpg',
			'services'    => array(
				array( 'title' => 'Import Documentation', 'text' => 'Guidance around product documents, importer requirements and shipment-readiness checks.' ),
				array( 'title' => 'Licensing Orientation', 'text' => 'Support for understanding food, consumer product and category-specific licensing expectations.' ),
				array( 'title' => 'Taxation Coordination', 'text' => 'Practical coordination with local tax and compliance professionals where specialist advice is needed.' ),
				array( 'title' => 'Risk Review', 'text' => 'Identify documentation gaps, label issues, restricted claims and operational friction before launch.' ),
			),
			'process'     => array( 'Product category review', 'Document checklist', 'Licensing path', 'Tax coordination', 'Launch readiness' ),
			'keywords'    => array( 'import licensing Delhi', 'FSSAI guidance Korean food', 'taxation support India import', 'India import documentation' ),
			'local'       => 'Companies looking for import documentation, FSSAI orientation, licensing guidance or taxation coordination in Delhi can use BRICS India as a practical first point of review.',
		),
		'sales-distribution-marketing' => array(
			'label'       => 'Sales & Marketing',
			'headline'    => 'Turn Korean market entry into repeatable sales channels in India.',
			'intro'       => 'BRICS India helps brands move beyond first conversations by supporting sales planning, distributor coordination, retail placement, ecommerce readiness and local marketing communication.',
			'image'       => '2024/02/Samyang--768x578.jpg',
			'services'    => array(
				array( 'title' => 'Distribution Planning', 'text' => 'Build channel routes across wholesale, retail, ecommerce and local business partners.' ),
				array( 'title' => 'Retail Placement', 'text' => 'Support buyer conversations and product presentation for relevant retail opportunities.' ),
				array( 'title' => 'Ecommerce Readiness', 'text' => 'Prepare product details, marketplace suitability and operational basics for online selling.' ),
				array( 'title' => 'Market Communication', 'text' => 'Adapt brand messaging for Indian trade buyers and customer-facing sales contexts.' ),
			),
			'process'     => array( 'Channel strategy', 'Sales material setup', 'Distributor and buyer outreach', 'Retail or ecommerce launch', 'Performance follow-up' ),
			'keywords'    => array( 'Korean brand distribution Delhi', 'sales marketing Korean products', 'retail placement India', 'ecommerce support India' ),
			'local'       => 'BRICS India supports Korean brands that want retail placement, wholesale distribution, ecommerce readiness and sales coordination from Delhi into Indian markets.',
		),
	);
}

function brics_modern_service_page_data( $slug ) {
	$pages = brics_modern_service_pages();
	return isset( $pages[ $slug ] ) ? $pages[ $slug ] : null;
}

function brics_modern_render_service_page( $data ) {
	?>
	<section class="service-overview band">
		<div class="section-inner service-overview-grid">
			<div>
				<div class="section-kicker"><?php echo esc_html( $data['label'] ); ?></div>
				<h2 class="section-title"><?php echo esc_html( $data['headline'] ); ?></h2>
				<p class="section-copy"><?php echo esc_html( $data['intro'] ); ?></p>
			</div>
			<div class="service-keywords" aria-label="Service focus areas">
				<?php foreach ( $data['keywords'] as $keyword ) : ?>
					<span><?php echo esc_html( $keyword ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="band soft service-detail-band">
		<div class="section-inner service-detail-grid">
			<div class="service-image-panel">
				<img src="<?php echo brics_modern_img( $data['image'] ); ?>" alt="<?php echo esc_attr( $data['label'] ); ?>">
			</div>
			<div class="service-card-grid">
				<?php foreach ( $data['services'] as $index => $service ) : ?>
					<?php $url = ! empty( $service['slug'] ) ? brics_modern_page_url( $service['slug'] ) : ''; ?>
					<article class="service-feature-card">
						<span><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<h3><?php echo esc_html( $service['title'] ); ?></h3>
						<p><?php echo esc_html( $service['text'] ); ?></p>
						<?php if ( $url ) : ?>
							<a href="<?php echo esc_url( $url ); ?>">Explore service</a>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="band service-process-band">
		<div class="section-inner">
			<div class="section-kicker">Process</div>
			<h2 class="section-title">A practical workflow from first review to market action.</h2>
			<div class="service-process">
				<?php foreach ( $data['process'] as $index => $step ) : ?>
					<div>
						<span><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<strong><?php echo esc_html( $step ); ?></strong>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php if ( ! empty( $data['local'] ) ) : ?>
		<section class="band soft local-seo-band">
			<div class="section-inner local-seo-panel">
				<div>
					<div class="section-kicker">Delhi & India Coverage</div>
					<h2 class="section-title">Local support for India-Korea trade services.</h2>
				</div>
				<p><?php echo esc_html( $data['local'] ); ?></p>
			</div>
		</section>
	<?php endif; ?>
	<?php
}
