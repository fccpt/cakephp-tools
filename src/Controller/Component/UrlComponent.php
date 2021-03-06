<?php

namespace Tools\Controller\Component;

use Cake\Routing\Router;
use Shim\Controller\Component\Component;

/**
 * A component for URL topics
 *
 * @author Mark Scherer
 * @license MIT
 */
class UrlComponent extends Component {

	/**
	 * Returns a URL based on provided parameters.
	 *
	 * ### Options:
	 *
	 * - `fullBase`: If true, the full base URL will be prepended to the result
	 *
	 * @param string|array|null $url Either a relative string url like `/products/view/23` or
	 *    an array of URL parameters. Using an array for URLs will allow you to leverage
	 *    the reverse routing features of CakePHP.
	 * @param array $options Array of options
	 * @return string Full translated URL with base path.
	 */
	public function build($url = null, array $options = []) {
		$defaults = [
			'fullBase' => false,
		];
		$options += $defaults;

		$url = Router::url($url, $options['fullBase']);

		return $url;
	}

	/**
	 * Creates a reset URL.
	 * The prefix and plugin params are resetting to default false.
	 *
	 * Can only add defaults for array URLs.
	 *
	 * @param string|array|null $url URL.
	 * @param bool $full If true, the full base URL will be prepended to the result
	 * @return string Full translated URL with base path.
	 */
	public function reset($url = null, $full = false) {
		if (is_array($url)) {
			$url += $this->defaults();
		}

		return Router::url($url, $full);
	}

	/**
	 * @return array
	 */
	public function defaults() {
		return [
			'prefix' => false,
			'plugin' => false
		];
	}

	/**
	 * Returns a URL based on provided parameters.
	 *
	 * Can only add query strings for array URLs.
	 *
	 * @param string|array|null $url URL.
	 * @param bool $full If true, the full base URL will be prepended to the result
	 * @return string Full translated URL with base path.
	 */
	public function complete($url = null, $full = false) {
		if (is_array($url)) {
			$url = $this->addQueryStrings($url);
		}

		return Router::url($url, $full);
	}

	/**
	 * @param array $url
	 *
	 * @return array
	 */
	protected function addQueryStrings(array $url) {
		if (!isset($url['?'])) {
			$url['?'] = [];
		}
		$url['?'] += $this->request->query;

		return $url;
	}

}
