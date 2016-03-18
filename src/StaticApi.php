<?php namespace Leean\Endpoints;

/**
 * Class to provide activation point for our endpoints.
 */
class StaticApi
{
	const ENDPOINT = '/static';

	/**
	 * Init.
	 */
	public static function init() {
		add_action( 'rest_api_init', function () {
			$namespace = apply_filters( 'ln_endpoints_api_namespace', 'leean', self::ENDPOINT );
			$version = apply_filters( 'ln_endpoints_api_version', 'v1', self::ENDPOINT );

			register_rest_route(
				$namespace . '/' . $version,
				self::ENDPOINT,
				[
					'methods' => 'GET',
					'callback' => [ __CLASS__, 'get_data' ],
				]
			);
		} );

		Inc\Content::acf_customize();
	}

	/**
	 * Get the data.
	 *
	 * @param \WP_REST_Request $request The request.
	 *
	 * @return array|\WP_Error
	 */
	public static function get_data( \WP_REST_Request $request ) {

		return [
			'site_name' => get_bloginfo( 'name' ),
			'site_description' => get_bloginfo( 'description' ),
			'site_icon' => get_site_icon_url(),
		];
	}
}
