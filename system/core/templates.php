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
 * Class TemplateManager
 *
 * This class is used to manage the theme and format data for the user.
 *
 * @package BBStandards
 */
class TemplateManager {
	private static $theme;
	private static $templates;
	private static $settings;

	/**
	 * Initialize the template manager. Call only when initializing the
	 * software.
	 */
	public static function init() {
		self::$theme = "data/themes/".BBSTANDARDS_THEME_DEFAULT."/";
		self::$templates = self::$theme."templates/";

		// Load the theme settings
		$settings = array();
		require_once(self::$theme."theme.php");
		self::$settings = $settings;
	}

	/**
	 * This function is used to parse the specified template from the theme
	 * which the user has selected.
	 *
	 * @param $name The name of the template
	 * @param array $params An array of arguments
	 * @return string The parsed template HTML
	 */
	public static function parseTemplate($name, $params = array()) {
		// Locate the file to use for the template
		$file = self::$templates.$name.".php";

		// If the file doesn't exist, find the right file
		if (!file_exists($file)) {
			$parents = explode(",", self::$settings["parents"]);
			foreach ($parents as $parent) {
				$file = "data/themes/$parent/templates/$name.php";
				if (file_exists($file)) break;
			}

			// If the template cannot be found in the dependency list
			if (!file_exists($file)) {
				return "Template not found.";
			}
		}

		// Parse the template file
		ob_start();
		require_once($file);
		return ob_get_clean();
	}

	public static function resource($link) {
		return self::$theme."public/$link";
	}
}