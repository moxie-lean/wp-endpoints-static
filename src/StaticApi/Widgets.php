<?php namespace Leean\Endpoints\StaticApi;

/**
 * Class Widgets
 *
 * @package Leean\Endpoints\StaticApi
 */
class Widgets
{
	/**
	 * Returns an array of widget areas, with the assigned widgets in each.

	 * @return array
	 */
	public static function get_all_areas() {
		global $wp_registered_widgets, $sidebars_widgets;

		$widget_areas = [];

		foreach ( $sidebars_widgets as $widget_area => $widgets ) {
			if ( 'wp_inactive_widgets' === $widget_area ) {
				continue;
			}

			$widget_areas[ $widget_area ] = [];

			foreach ( $widgets as $widget ) {
				$model = $wp_registered_widgets[ $widget ]['callback'][0];

				if ( is_a( $model, 'Leean\Widgets\Models\AbstractWidget' ) ) {
					$widget_areas[ $widget_area ][] = [
						'type' => $model->get_slug(),
						'content' => $model->get_data(),
					];
				}
			}
		}

		return $widget_areas;
	}
}
