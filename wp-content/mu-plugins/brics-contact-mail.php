<?php
/**
 * Make contact form delivery reliable for BRICS India.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BRICS_CONTACT_EMAIL', 'bricsindia@gmail.com' );
define( 'BRICS_CONTACT_FORM_ID', '9f9cbf04' );
define( 'BRICS_CONTACT_RATE_LIMIT_WINDOW', HOUR_IN_SECONDS );
define( 'BRICS_CONTACT_RATE_LIMIT_MAX', 3 );

add_filter(
	'wp_mail',
	function ( $args ) {
		$to = isset( $args['to'] ) ? (array) $args['to'] : array();
		$to = array_map( 'strtolower', array_map( 'trim', $to ) );

		if ( ! in_array( BRICS_CONTACT_EMAIL, $to, true ) ) {
			return $args;
		}

		$headers       = array( 'Content-Type: text/html; charset=UTF-8' );
		$reply_to      = brics_contact_extract_reply_to( isset( $args['message'] ) ? $args['message'] : '' );
		$site_host     = wp_parse_url( home_url(), PHP_URL_HOST );
		$site_host     = $site_host ? preg_replace( '/^www\./', '', $site_host ) : 'localhost';
		$from_email    = 'wordpress@' . $site_host;
		$from_name     = 'BRICS India Website';
		$args['to']    = array( BRICS_CONTACT_EMAIL );
		$args['headers'] = $headers;

		if ( 'localhost' !== $site_host && is_email( $from_email ) ) {
			$args['headers'][] = 'From: ' . $from_name . ' <' . $from_email . '>';
		} else {
			$args['headers'][] = 'From: ' . $from_name . ' <' . BRICS_CONTACT_EMAIL . '>';
		}

		if ( $reply_to ) {
			$args['headers'][] = 'Reply-To: Website Visitor <' . $reply_to . '>';
		}

		if ( empty( $args['subject'] ) || 'Form Submission' === $args['subject'] ) {
			$args['subject'] = 'New contact form submission - BRICS India';
		}

		return $args;
	},
	20
);

add_action( 'wp_ajax_uagb_process_forms', 'brics_contact_guard_uagb_submission', 0 );
add_action( 'wp_ajax_nopriv_uagb_process_forms', 'brics_contact_guard_uagb_submission', 0 );
add_action( 'wp_ajax_uagb_process_forms', 'brics_contact_log_uagb_attempt', 1 );
add_action( 'wp_ajax_nopriv_uagb_process_forms', 'brics_contact_log_uagb_attempt', 1 );
add_action( 'admin_post_brics_contact_submit', 'brics_contact_handle_modern_form' );
add_action( 'admin_post_nopriv_brics_contact_submit', 'brics_contact_handle_modern_form' );

add_action(
	'wp_footer',
	function () {
		if ( ! is_page( 'contact' ) ) {
			return;
		}
		?>
		<script>
		(function () {
			var form = document.querySelector('[name="uagb-form-<?php echo esc_js( BRICS_CONTACT_FORM_ID ); ?>"]');
			if (!form) {
				return;
			}

			var email = form.querySelector('input[type="email"]');
			var message = form.querySelector('textarea');

			if (email) {
				email.required = true;
			}

			if (message) {
				message.required = true;
				message.minLength = 12;
				message.maxLength = 2000;
			}

			if (!form.querySelector('[name="company_site"]')) {
				var honeypot = document.createElement('input');
				honeypot.type = 'text';
				honeypot.name = 'company_site';
				honeypot.id = 'hidden';
				honeypot.value = '';
				honeypot.tabIndex = -1;
				honeypot.autocomplete = 'off';
				honeypot.setAttribute('aria-hidden', 'true');
				honeypot.style.cssText = 'position:absolute;left:-9999px;width:1px;height:1px;opacity:0;';
				form.appendChild(honeypot);
			}
		}());
		</script>
		<?php
	},
	20
);

add_action(
	'wp_mail_failed',
	function ( $error ) {
		brics_contact_log_submission(
			array(
				'time'  => current_time( 'mysql' ),
				'error' => $error instanceof WP_Error ? $error->get_error_message() : 'Unknown mail error',
			)
		);
	}
);

add_action(
	'uagb_form_success',
	function ( $form_data ) {
		brics_contact_log_submission(
			array(
				'time'      => current_time( 'mysql' ),
				'delivered' => true,
				'to'        => BRICS_CONTACT_EMAIL,
				'data'      => $form_data,
			)
		);
	}
);

function brics_contact_guard_uagb_submission() {
	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'uagb_forms_ajax_nonce' ) ) {
		brics_contact_block_ajax_submission( 'bad_nonce' );
	}

	$block_id = isset( $_POST['block_id'] ) ? sanitize_text_field( wp_unslash( $_POST['block_id'] ) ) : '';
	if ( BRICS_CONTACT_FORM_ID !== $block_id ) {
		return;
	}

	$contact_page = get_page_by_path( 'contact' );
	$post_id      = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
	if ( ! $contact_page || $post_id !== (int) $contact_page->ID ) {
		brics_contact_block_ajax_submission( 'wrong_page' );
	}

	$form_data = brics_contact_get_uagb_form_data();
	if ( ! $form_data || empty( $form_data['id'] ) || BRICS_CONTACT_FORM_ID !== $form_data['id'] ) {
		brics_contact_block_ajax_submission( 'bad_form_data' );
	}

	$name    = isset( $form_data['First Name'] ) ? trim( sanitize_text_field( $form_data['First Name'] ) ) : '';
	$email   = isset( $form_data['Email'] ) ? sanitize_email( $form_data['Email'] ) : '';
	$subject = isset( $form_data['Last Name'] ) ? trim( sanitize_text_field( $form_data['Last Name'] ) ) : '';
	$message = isset( $form_data['Message'] ) ? trim( sanitize_textarea_field( $form_data['Message'] ) ) : '';
	$joined  = strtolower( trim( implode( ' ', array_map( 'strval', $form_data ) ) ) );

	if ( '' === $name || '' === $subject || '' === $message || ! is_email( $email ) ) {
		brics_contact_block_ajax_submission( 'missing_required_fields', $form_data );
	}

	if ( strlen( $name ) > 100 || strlen( $subject ) > 160 || strlen( $message ) > 2000 || strlen( $message ) < 12 ) {
		brics_contact_block_ajax_submission( 'invalid_length', $form_data );
	}

	if ( preg_match_all( '/https?:\/\/|www\.|bit\.ly|t\.me|wa\.me|telegram|casino|viagra|loan|crypto|forex|porn|escort|seo service/i', $joined ) > 0 ) {
		brics_contact_block_ajax_submission( 'blocked_spam_terms', $form_data );
	}

	if ( ! empty( $form_data['company_site'] ) || ! empty( $form_data['website'] ) || ! empty( $form_data['url'] ) ) {
		brics_contact_block_ajax_submission( 'honeypot_filled', $form_data );
	}

	if ( brics_contact_rate_limited( brics_contact_client_ip() ) || brics_contact_rate_limited( strtolower( $email ) ) ) {
		brics_contact_block_ajax_submission( 'rate_limited', $form_data );
	}
}

function brics_contact_log_uagb_attempt() {
	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'uagb_forms_ajax_nonce' ) ) {
		return;
	}

	if ( empty( $_POST['form_data'] ) ) {
		return;
	}

	$form_data = json_decode( wp_unslash( $_POST['form_data'] ), true ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	if ( ! is_array( $form_data ) || empty( $form_data['id'] ) || BRICS_CONTACT_FORM_ID !== $form_data['id'] ) {
		return;
	}

	brics_contact_log_submission(
		array(
			'time'   => current_time( 'mysql' ),
			'status' => 'received',
			'to'     => BRICS_CONTACT_EMAIL,
			'data'   => array_map( 'sanitize_text_field', $form_data ),
		)
	);
}

function brics_contact_get_uagb_form_data() {
	if ( empty( $_POST['form_data'] ) ) {
		return array();
	}

	$form_data = json_decode( wp_unslash( $_POST['form_data'] ), true ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	return is_array( $form_data ) ? $form_data : array();
}

function brics_contact_block_ajax_submission( $reason, $form_data = array() ) {
	brics_contact_log_submission(
		array(
			'time'   => current_time( 'mysql' ),
			'event'  => 'blocked_contact_form',
			'reason' => $reason,
			'ip'     => brics_contact_client_ip(),
			'data'   => array_map( 'sanitize_text_field', (array) $form_data ),
		)
	);

	wp_send_json_success( 400 );
}

function brics_contact_client_ip() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	return preg_replace( '/[^0-9a-fA-F:\.]/', '', $ip );
}

function brics_contact_rate_limited( $key ) {
	if ( '' === $key ) {
		return false;
	}

	$transient_key = 'brics_contact_rate_' . md5( $key );
	$count         = (int) get_transient( $transient_key );

	if ( $count >= BRICS_CONTACT_RATE_LIMIT_MAX ) {
		return true;
	}

	set_transient( $transient_key, $count + 1, BRICS_CONTACT_RATE_LIMIT_WINDOW );
	return false;
}

function brics_contact_handle_modern_form() {
	if ( empty( $_POST['brics_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['brics_contact_nonce'] ) ), 'brics_contact_submit' ) ) {
		brics_contact_redirect_with_status( 'error' );
	}

	if ( ! empty( $_POST['company_site'] ) ) {
		brics_contact_redirect_with_status( 'sent' );
	}

	$name    = isset( $_POST['full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['full_name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$subject = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name || '' === $subject || ! is_email( $email ) || strlen( $message ) < 12 || brics_contact_rate_limited( brics_contact_client_ip() ) || brics_contact_rate_limited( strtolower( $email ) ) ) {
		brics_contact_redirect_with_status( 'error' );
	}

	$mail_subject = $subject ? 'BRICS India enquiry - ' . $subject : 'New contact form submission - BRICS India';
	$body         = "Name: {$name}\nEmail: {$email}\nSubject: {$subject}\n\nMessage:\n{$message}\n";
	$headers      = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( BRICS_CONTACT_EMAIL, $mail_subject, $body, $headers );

	brics_contact_log_submission(
		array(
			'event'   => 'modern_contact_form',
			'success' => (bool) $sent,
			'data'    => array(
				'name'    => $name,
				'email'   => $email,
				'subject' => $subject,
				'message' => $message,
			),
		)
	);

	brics_contact_redirect_with_status( $sent ? 'sent' : 'error' );
}

function brics_contact_redirect_with_status( $status ) {
	$url = get_permalink( get_page_by_path( 'contact' ) );
	if ( ! $url ) {
		$url = home_url( '/contact/' );
	}

	wp_safe_redirect( add_query_arg( 'contact_status', $status, $url ) . '#contact-form' );
	exit;
}

function brics_contact_extract_reply_to( $message ) {
	if ( ! is_string( $message ) || '' === $message ) {
		return '';
	}

	if ( preg_match( '/<strong>\s*Email\s*<\/strong>\s*-\s*([^<\s]+)/i', $message, $matches ) ) {
		$email = sanitize_email( html_entity_decode( $matches[1] ) );
		return is_email( $email ) ? $email : '';
	}

	return '';
}

function brics_contact_log_submission( $entry ) {
	$upload_dir = wp_upload_dir();
	if ( empty( $upload_dir['basedir'] ) ) {
		return;
	}

	$file = trailingslashit( $upload_dir['basedir'] ) . 'brics-contact-submissions.log';
	$line = wp_json_encode( $entry ) . PHP_EOL;
	file_put_contents( $file, $line, FILE_APPEND | LOCK_EX );
}
