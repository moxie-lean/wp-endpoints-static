<?php namespace Leean\Endpoints\StaticApi;

/**
 * Verification strings.
 */
class Verification {
	public static function webmaster_tools() {
		$data = [];
		if ( defined( 'WPSEO_VERSION' ) ) {
			$options = self::get_options();
			foreach ( $options as $name => $value ) {
				if ( self::is_webmaster_tool( $name ) ) {
					$data[ $name ] = $value;
				}
			}
		}
		return $data;
	}

	protected static function get_options() {
		return get_option( 'wpseo', [] );
	}

	protected static function is_webmaster_tool( $name = '', $tool = 'verify' ) {
		return strpos( $name, $tool ) !== false;
	}
}

