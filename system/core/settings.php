<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards;

/**
 * Class Settings
 *
 * This class is a simple front-end to the settings, which implements a
 * few useful settings-related functions.
 *
 * @package BBStandards
 */
class Settings {
	public static function init() {
		require_once("data/settings/settings.php");
	}
}