<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$status = isset( $_GET['contact_status'] ) ? sanitize_key( wp_unslash( $_GET['contact_status'] ) ) : '';
?>
<section class="contact-hero">
	<div class="section-inner contact-hero-grid">
		<div>
			<div class="eyebrow">Contact BRICS India</div>
			<h1>Talk to the team before you enter the Indian market.</h1>
			<p>Share your product category, company details and target market for import, distribution, licensing or India-Korea trade support from New Delhi. Your enquiry will be routed directly to bricsindia@gmail.com.</p>
			<div class="contact-hero-actions">
				<a class="button" href="#contact-form">Send enquiry</a>
				<a class="button secondary" href="mailto:bricsindia@gmail.com">Email directly</a>
			</div>
		</div>
		<div class="contact-hero-panel">
			<img src="<?php echo brics_modern_img( '2021/11/about-us-min.jpg' ); ?>" alt="BRICS India contact and trade support">
			<div class="contact-hero-points">
				<span>New Delhi office</span>
				<span>India-Korea trade support</span>
				<span>Response by email</span>
			</div>
		</div>
	</div>
</section>

<section class="band contact-main-section">
	<div class="section-inner contact-main-grid">
		<aside class="contact-info-panel">
			<div class="section-kicker">Get In Touch</div>
			<h2>Start with a clear enquiry.</h2>
			<p>For import, distribution, licensing, trade matchmaking or sales support in Delhi NCR and across India, send the details below and the BRICS India team will review the best next step.</p>
			<div class="contact-info-list">
				<a href="tel:01149070215">
					<span>Phone</span>
					<strong>01149070215</strong>
				</a>
				<a href="mailto:bricsindia@gmail.com">
					<span>Email</span>
					<strong>bricsindia@gmail.com</strong>
				</a>
				<div>
					<span>Office</span>
					<strong>21/3 and 4, 2nd Floor, Yusuf Sarai Main Market, New Delhi - 110016</strong>
				</div>
			</div>
		</aside>

		<div id="contact-form" class="modern-contact-form-card">
			<div class="contact-form-heading">
				<div>
					<div class="section-kicker">Send A Message</div>
					<h2>Tell us about your product or business goal.</h2>
				</div>
				<span>Usually best with product category, origin, stage and target channel.</span>
			</div>

			<?php if ( 'sent' === $status ) : ?>
				<div class="contact-alert success">Thank you. Your enquiry has been submitted to BRICS India.</div>
			<?php elseif ( 'error' === $status ) : ?>
				<div class="contact-alert error">Please check your name, email and message, then try again.</div>
			<?php endif; ?>

			<form class="modern-contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="brics_contact_submit">
				<?php wp_nonce_field( 'brics_contact_submit', 'brics_contact_nonce' ); ?>
				<label class="contact-honeypot">
					Company website
					<input type="text" name="company_site" tabindex="-1" autocomplete="off">
				</label>
				<div class="form-row two">
					<label>
						<span>Full name</span>
						<input type="text" name="full_name" autocomplete="name" required>
					</label>
					<label>
						<span>Email address</span>
						<input type="email" name="email" autocomplete="email" required>
					</label>
				</div>
				<label>
					<span>Subject</span>
					<input type="text" name="subject" autocomplete="off" placeholder="Import, distribution, licensing or trade enquiry">
				</label>
				<label>
					<span>Message</span>
					<textarea name="message" rows="6" required placeholder="Share product category, company details, target market and current stage."></textarea>
				</label>
				<button class="button" type="submit">Send enquiry</button>
			</form>
		</div>
	</div>
</section>

<section class="band contact-map-section">
	<div class="section-inner contact-map-panel">
		<div>
			<div class="section-kicker">Trade Route</div>
			<h2>Built for India and Korea business coordination.</h2>
			<p>BRICS India supports Korean companies with practical market entry, import, distribution and local business coordination from New Delhi into Indian markets.</p>
		</div>
		<a class="button secondary" href="<?php echo esc_url( brics_modern_page_url( 'business-area' ) ); ?>">View services</a>
	</div>
</section>
<?php
get_footer();
