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
	 * @var mixed $id
	 */
	public $id;

	/**
	 * The receiver e-mail.
	 * It should be set to false if only user id is available.
	 *
	 * @var mixed $to
	 */
	public $to;

	/**
	 * Title of the e-mail.
	 *
	 * @var string $subject
	 */
	public $subject;

	/**
	 * Headers of the e-mail.
	 *
	 * @var array $headers
	 */
	public $headers;

	/**
	 * Body of the email.
	 *
	 * @var string $message
	 */
	public $message;

	/**
	 * Constructor method.
	 * It will receive the parameters and equate then to the class properties.
	 *
	 * @param mixed  $id
	 * @param mixed  $to
	 * @param string $subject
	 * @param string $message
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
	 * @return string
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
