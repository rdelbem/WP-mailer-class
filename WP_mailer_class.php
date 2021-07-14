<?php

/**
 * This class provides an easy way to call wp_mail anywhere it may be needed.
 * NOTICE - The function wp_mail is only available after wp_load is rendered.
 * So, it may not work depending on WHEN your application is hooked on.
 */
class WP_mailer_class {

	/**
	 * User id. Can be either a string or an int.
	 * It can be false, if you have the e-mail
	 * available when instatiating this class.
	 *
	 * @var MIXED
	 */
	public $id;

	/**
	 * The receiver e-mail.
	 * It should be set to false if only user id is available.
	 *
	 * @var MIXED
	 */
	public $to;

	/**
	 * Title of the e-mail.
	 *
	 * @var STRING
	 */
	public $subject;

	/**
	 * Headers of the e-mail.
	 *
	 * @var ARRAY
	 */
	public $headers;

	/**
	 * Body of the email.
	 *
	 * @var STRING
	 */
	public $message;

	/**
	 * Constructor method.
	 * It will receive the parameters and equate then to the class properties.
	 *
	 * @param MIXED  $id
	 * @param MIXED  $to
	 * @param STRING $subject
	 * @param STRING $message
	 */
	public function __construct( $id, $to, $subject, $message ) {
		if ( $id !== false ) {
			$this->id = (int) $id;
		}

		if ( is_string( $to ) ) {
			$this->to = $to;
		}

		if ( $to === false ) {
			$this->to = $this->get_user_email_by_id();
		}

		$this->subject = $subject;
		$this->headers = array( 'Content-Type: text/html; charset=UTF-8', 'From:' . get_bloginfo() . ' <' . get_option( 'admin_email' ) . '>' );
		$this->message = $message;

		$this->send_mail();
	}

	/**
	 * If only user id is available,
	 * this function will retrieve the user email by the provided id.
	 *
	 * @return STRING
	 */
	public function get_user_email_by_id() {
		$user_info  = get_userdata( $this->id );
		$user_email = $user_info->user_email;
		return $user_email;
	}

	/**
	 * This calls the wp_mail function.
	 *
	 * @return void
	 */
	public function send_mail() {
		wp_mail( $this->to, $this->subject, $this->message, $this->headers );
	}
}
