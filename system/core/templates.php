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
		return self::parseFile($file, $params);
	}

	/**
	 * This takes a link relative to a theme's "public" folder, and creates
	 * a URL relative to the website. This is required for displaying
	 * resources which are bundled along with a theme.
	 */
	public static function resource($link) {
		return self::$theme."public/$link";
	}

	/**
	 * This method parses the specified template which belongs to the
	 * specified plugin (system plugins only). This also allows a
	 * theme to override the template.
	 */
	public static function parseSystemPluginTemplate($plugin, $template, $args) {
		return self::parseFileOrTemplate("system/plugins/$plugin/templates/$template.php", $plugin."/".$template, $args);
	}

	/**
	 * This method parses the specified template which belongs to the
	 * specified plugin (non-system plugins only). This also allows a
	 * theme to override the template.
	 */
	public static function parsePluginTemplate($plugin, $template, $args) {
		return self::parseFileOrTemplate("data/plugins/$plugin/templates/$template.php", $plugin."/".$template, $args);
	}

	/**
	 * This method parses either the specified file or the specified theme
	 * template, whichever exists. Preference is given to the theme template.
	 * This allows a plugin to have a default template which is overridable
	 * by a theme. Required for good modular programming.
	 *
	 * This is primarily used by parsePluginTemplate(), but is conceivably
	 * usable by other applications, so is made public.
	 */
	public static function parseFileOrTemplate($path, $template, $args) {
		// Locate the file to use for the template
		$file = self::$templates.$template.".php";

		// If the file doesn't exist, find the right file
		if (!file_exists($file)) {
			$parents = explode(",", self::$settings["parents"]);
			foreach ($parents as $parent) {
				$file = "data/themes/$parent/templates/$template.php";
				if (file_exists($file)) break;
			}

			// If the template cannot be found in the dependency list
			if (!file_exists($file)) {
				if (file_exists($path)) {
					return self::parseFile($path, $args);
				} else {
					return "Template not found.";
				}
			}
		}

		return self::parseFile($file, $args);
	}

	/**
	 * This function takes the specified path and parses it as a template.
	 * Very, very simple.
	 */
	public static function parseFile($path, $params) {
		ob_start();
		require_once($path);
		return ob_get_clean();
	}
}