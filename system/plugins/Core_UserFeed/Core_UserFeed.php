<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_UserFeed;

/**
 * Class Core_UserFeed
 *
 * This class is a hook which is designed to display a user feed with a
 * specified set of filters. This is used by the index page and the view
 * forum page to show a feed of recent topics.
 *
 * @package BBStandards\Core_UserFeed
 */

class Core_UserFeed extends \BBStandards\Plugin {

	/**
	 * This function binds all of the hooks, so that the feed can
	 * be displayed.
	 */
	public function getHooks() {
		return array(
			"page.module.index" => "showWrap"
		);
	}

	public function showWrap() {
		return "";
	}

}