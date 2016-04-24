<?php namespace Lean\Endpoints\StaticApi;

/**
 * Class GravityForms.
 *
 * @package Lean\Endpoints\StaticApi
 */
class GravityForms {
	const SIGNATURE_EXPIRY = '+1 day';

	/**
	 * Get the settings need to Gravity Forms.
	 */
	public static function get_settings() {
		// If the gforms plugin is not active.
		if ( ! class_exists( 'GFWebAPI' ) ) {
			return false;
		}

		$settings = get_option( 'gravityformsaddon_gravityformswebapi_settings' );

		// If the API is not enabled.
		if ( empty( $settings ) || ! $settings['enabled'] ) {
			return false;
		}

		$forms = [];

		$method = 'GET';

		$expires = strtotime( self::SIGNATURE_EXPIRY );

		foreach ( \GFAPI::get_forms() as $form ) {

			$get_form_route = 'forms/' . $form['id'];

			$string_to_sign = sprintf( '%s:%s:%s:%s', $settings['public_key'], $method, $get_form_route, $expires );

			$forms[ $form['id'] ] = [
				'get_form' => [
					'route' => $get_form_route,
					'expires' => $expires,
					'signature' => self::calculate_signature( $string_to_sign, $settings['private_key'] ),
				],
				'post_submission' => [
					'route' => 'forms/' . $form['id'] . '/submissions',
				],
			];
		}

		return [
			'api_base' => GFWEBAPI_API_BASE_URL,
			'api_key' => $settings['public_key'],
			'forms' => $forms,
		];
	}

	/**
	 * Get the signature.
	 *
	 * @param string $string 	  The string to sign.
	 * @param string $private_key The private key to sign it with.
	 * @return string
	 */
	private static function calculate_signature( $string, $private_key ) {
		$hash = hash_hmac( 'sha1', $string, $private_key, true );

		return rawurlencode( base64_encode( $hash ) );
	}
}

