<?php namespace Leean\Endpoints\StaticApi;

/**
 * Class Menus
 *
 * @package Leean\Endpoints\StaticApi
 */
class Menus
{
	/**
	 * Returns an array of menu locations, with the assigned menu in each.
	 *
	 * @return array
	 */
	public static function get() {
		$menus = [];

		$locations = get_nav_menu_locations();

		foreach ( $locations as $location => $menu_id ) {
			$menus[ $location ] = [];

			$menu_items = wp_get_nav_menu_items( $menu_id );

			foreach ( $menu_items as $menu_item ) {
				if ( ! $menu_item->menu_item_parent ) {
					$menus[ $location ][] = [
						'title' => $menu_item->title,
						'link' => str_replace( site_url(), '', $menu_item->url ),
						'items' => self::get_sub_menu_items( $menu_items, $menu_item->ID ),
					];
				}
			}
		}

		return $menus;
	}

	/**
	 * Recursively get all sub menu items.
	 *
	 * @param array $menu_items All menu items.
	 * @param int   $parent_id  The parent menu id.
	 * @return array
	 */
	public static function get_sub_menu_items( $menu_items, $parent_id ) {
		$items = [];

		foreach ( $menu_items as $menu_item ) {
			if ( $parent_id == $menu_item->menu_item_parent ) {
				$items[] = [
					'title' => $menu_item->title,
					'link' => str_replace( site_url(), '', $menu_item->url ),
					'items' => self::get_sub_menu_items( $menu_items, $menu_item->ID ),
				];
			}
		}

		return $items;
	}
}
