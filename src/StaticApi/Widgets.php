<?php namespace Lean\Endpoints\StaticApi;

use Lean\Widgets\Register;

/**
 * Class Widgets
 *
 * @package Lean\Endpoints\StaticApi
 */
class Widgets {
	/**
	 * Returns an array of widget areas, with the assigned widgets in each.

	 * @return array
	 */
	public static function get_all_areas() {
		global $sidebars_widgets;

		$widget_areas = [];

		foreach ( $sidebars_widgets as $widget_area => $widgets ) {
			if ( 'wp_inactive_widgets' === $widget_area ) {
				continue;
			}

			$widget_areas[ $widget_area ] = [];

			if ( empty( $widgets ) ) {
				continue;
			}

			foreach ( $widgets as $widget ) {
				$model = Register::get_widget_instance( $widget );

				if ( ! $model ) {
					continue;
				}

				$widget_areas[ $widget_area ][] = [
					'type' => $model->get_slug(),
					'content' => $model->get_data(),
				];
			}
		}

		return $widget_areas;
	}
}
