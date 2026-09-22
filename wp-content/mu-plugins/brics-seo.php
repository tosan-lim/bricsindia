<?php
/**
 * Page-level SEO metadata for BRICS India.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function brics_seo_pages() {
	return array(
		'home-2' => array(
			'title'       => 'BRICS India Trade Pvt. Ltd. | Korean Importer & Trade Partner in Delhi India',
			'description' => 'BRICS India Trade Pvt. Ltd. in New Delhi helps Korean brands enter India with importing, wholesale distribution, sourcing, licensing, taxation and trade consulting.',
		),
		'about-us' => array(
			'title'       => 'About BRICS India | Korean Import & Distribution Company New Delhi',
			'description' => 'Learn about BRICS India Trade Pvt. Ltd., a New Delhi company supporting Korean food, consumer products, ecommerce and cross-border trade in India.',
		),
		'contact' => array(
			'title'       => 'Contact BRICS India Delhi | Korean Product Import & Trade Consulting',
			'description' => 'Contact BRICS India in New Delhi for Korean product imports, wholesale distribution, sourcing, licensing, trade matchmaking and India market entry support.',
		),
		'brand-and-products' => array(
			'title'       => 'Korean Brands & Products in India | K-Food Distribution Delhi',
			'description' => 'Explore Korean food, wellness and consumer products represented by BRICS India for Indian wholesale, retail, ecommerce and distribution opportunities.',
		),
		'business-area' => array(
			'title'       => 'Korean Import, Distribution & Consulting Services in Delhi India',
			'description' => 'BRICS India provides trade matchmaking, Korean product distribution, licensing, taxation, sales and marketing support from New Delhi for India.',
		),
		'trade-matchmaking' => array(
			'title'       => 'Trade Matchmaking Delhi India | Korea Business Partner Search',
			'description' => 'Find Indian buyers, distributors, retailers and trade partners through BRICS India matchmaking services for Korean companies entering India.',
		),
		'consultation' => array(
			'title'       => 'Import Licensing & Taxation Consulting Delhi | Compliance Support India',
			'description' => 'Get support for import documentation, taxation coordination, licensing, FSSAI orientation and compliance planning for Korean products in India.',
		),
		'sales-distribution-marketing' => array(
			'title'       => 'Korean Brand Sales, Distribution & Marketing in Delhi India',
			'description' => 'BRICS India supports Korean brands with wholesale distribution, retail placement, ecommerce readiness, sales planning and marketing in India.',
		),
		'brands-and-marketing' => array(
			'title'       => 'Brand Marketing in India for Korean Products | BRICS India',
			'description' => 'Build your Korean brand in India with BRICS India marketing, ecommerce, retail distribution and local trade support services.',
		),
		'correction1' => array(
			'title'       => 'India South Korea Trade Solutions | BRICS India',
			'description' => 'BRICS India streamlines India and South Korea trade with practical support for import, sourcing, distribution and business consulting.',
		),
	);
}

function brics_seo_data_for_current_page() {
	if ( ! is_singular( 'page' ) ) {
		return null;
	}

	$post = get_queried_object();
	if ( ! $post || empty( $post->post_name ) ) {
		return null;
	}

	$pages = brics_seo_pages();
	return isset( $pages[ $post->post_name ] ) ? $pages[ $post->post_name ] : array(
		'title'       => get_the_title( $post ) . ' | BRICS India Trade Pvt. Ltd.',
		'description' => 'BRICS India Trade Pvt. Ltd. supports Korean product imports, wholesale distribution and trade consulting services in India.',
	);
}

function brics_seo_current_slug() {
	if ( ! is_singular( 'page' ) ) {
		return '';
	}

	$post = get_queried_object();
	return ( $post && ! empty( $post->post_name ) ) ? $post->post_name : '';
}

add_filter(
	'pre_get_document_title',
	function ( $title ) {
		$seo = brics_seo_data_for_current_page();
		return $seo ? $seo['title'] : $title;
	},
	20
);

add_action(
	'wp_head',
	function () {
		$seo = brics_seo_data_for_current_page();
		if ( ! $seo ) {
			return;
		}

		$title       = esc_attr( $seo['title'] );
		$description = esc_attr( $seo['description'] );
		$url         = esc_url( get_permalink() );
		$site_name   = esc_attr( get_bloginfo( 'name' ) );

		echo "\n" . '<meta name="description" content="' . $description . '">' . "\n";
		echo '<link rel="canonical" href="' . $url . '">' . "\n";
		echo '<meta property="og:type" content="website">' . "\n";
		echo '<meta property="og:site_name" content="' . $site_name . '">' . "\n";
		echo '<meta property="og:title" content="' . $title . '">' . "\n";
		echo '<meta property="og:description" content="' . $description . '">' . "\n";
		echo '<meta property="og:url" content="' . $url . '">' . "\n";
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
		echo '<meta name="twitter:title" content="' . $title . '">' . "\n";
		echo '<meta name="twitter:description" content="' . $description . '">' . "\n";
	},
	1
);

add_action(
	'wp_head',
	function () {
		$slug = brics_seo_current_slug();
		if ( 'correction1' === $slug ) {
			echo '<meta name="robots" content="noindex,follow">' . "\n";
		}
	},
	1
);

add_action(
	'wp_head',
	function () {
		if ( ! is_front_page() && ! is_page( 'contact' ) && ! is_page( 'about-us' ) ) {
			return;
		}

		$schema = array(
			'@context' => 'https://schema.org',
			'@graph'   => array(
				array(
					'@type'       => array( 'Organization', 'LocalBusiness' ),
					'@id'         => home_url( '/#organization' ),
					'name'        => 'BRICS India Trade Pvt. Ltd.',
					'url'         => home_url( '/' ),
					'email'       => 'bricsindia@gmail.com',
					'telephone'   => '01149070215',
					'description' => 'New Delhi based India-Korea trade company supporting Korean product import, distribution, licensing, trade matchmaking and consulting in India.',
					'address'     => array(
						'@type'           => 'PostalAddress',
						'streetAddress'   => '21/3 and 4, 2nd Floor, Yusuf Sarai Main Market',
						'addressLocality' => 'New Delhi',
						'postalCode'      => '110016',
						'addressCountry'  => 'IN',
					),
					'areaServed'  => array(
						array(
							'@type' => 'City',
							'name'  => 'Delhi',
						),
						array(
							'@type' => 'Country',
							'name'  => 'India',
						),
						array(
							'@type' => 'Country',
							'name'  => 'South Korea',
						),
					),
					'makesOffer'  => array(
						array(
							'@type' => 'Offer',
							'itemOffered' => array(
								'@type' => 'Service',
								'name'  => 'Korean product import and distribution in India',
							),
						),
						array(
							'@type' => 'Offer',
							'itemOffered' => array(
								'@type' => 'Service',
								'name'  => 'India Korea trade matchmaking and consulting',
							),
						),
					),
				),
				array(
					'@type'      => 'WebSite',
					'@id'        => home_url( '/#website' ),
					'url'        => home_url( '/' ),
					'name'       => 'BRICS India Trade Pvt. Ltd.',
					'publisher'  => array(
						'@id' => home_url( '/#organization' ),
					),
					'inLanguage' => 'en-IN',
				),
			),
		);

		echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	},
	2
);

add_action(
	'wp_head',
	function () {
		if ( ! is_singular( 'page' ) ) {
			return;
		}

		$post = get_queried_object();
		if ( ! $post || empty( $post->post_name ) ) {
			return;
		}

		$service_types = array(
			'business-area'                 => 'Business consulting, import support and distribution services for Korean companies in India',
			'trade-matchmaking'             => 'Trade matchmaking and India Korea business partner search services',
			'brand-and-products'            => 'Korean brand representation and product distribution services in India',
			'consultation'                  => 'Import documentation, taxation coordination and licensing consultation services in India',
			'sales-distribution-marketing'  => 'Sales, distribution, ecommerce and marketing support for Korean brands in India',
		);

		if ( ! isset( $service_types[ $post->post_name ] ) ) {
			return;
		}

		$seo = brics_seo_data_for_current_page();
		if ( ! $seo ) {
			return;
		}

		$schema = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Service',
			'name'        => wp_strip_all_tags( $seo['title'] ),
			'description' => wp_strip_all_tags( $seo['description'] ),
			'serviceType' => $service_types[ $post->post_name ],
			'provider'    => array(
				'@type' => 'Organization',
				'@id'   => home_url( '/#organization' ),
				'name'  => 'BRICS India Trade Pvt. Ltd.',
				'url'   => home_url( '/' ),
				'email' => 'bricsindia@gmail.com',
			),
			'areaServed'  => array(
				array(
					'@type' => 'Country',
					'name'  => 'India',
				),
				array(
					'@type' => 'Country',
					'name'  => 'South Korea',
				),
			),
			'url'         => get_permalink( $post ),
		);

		echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	},
	2
);
