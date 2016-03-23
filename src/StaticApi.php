<?php namespace Leean\Endpoints;

use Leean\Endpoints\StaticApi\Menus;
use Leean\Endpoints\StaticApi\Widgets;
use Leean\AbstractEndpoint;

/**
 * Class to provide activation point for our endpoints.
 */
class StaticApi extends AbstractEndpoint {

	/**
	 * Endpoint path
	 *
	 * @Override
	 * @var String
	 */
	protected $endpoint = '/static';

	/**
	 * Get the data.
	 *
	 * @Override
	 * @param \WP_REST_Request $request The request.
	 *
	 * @return array|\WP_Error
	 */
	public function endpoint_callback( \WP_REST_Request $request ) {
		$data = [
			'site_name' => get_bloginfo( 'name' ),
			'site_description' => get_bloginfo( 'description' ),
			'site_icon' => get_site_icon_url(),
			'menus' => Menus::get_all_locations(),
			'widgets' => Widgets::get_all_areas(),
		];
		return $this->filter_data( $data );
	}
}
