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

class Response {
	public static function init() {

	}

	public static function prepare() {
		$page = \BBStandards\Request::getPage();
		if (strstr($page, ".")) {
			$page = "error";
		}

		$args = \BBStandards\Request::getArguments();

		$hook = "page.module.$page.fullpage";
		$content = \BBStandards\PluginManager::hookText($hook, $args);

		if ($content == "") {
			// If the page is not requesting to be formatted without the template
			$hook = "page.module.$page";
			$content = \BBStandards\PluginManager::hookText($hook, $args);

			// Call a  plugin hook before displaying anything
			\BBstandards\PluginManager::hookAction("global.beforeFormat");

			// Format the response into the global template
			$content = \BBStandards\TemplateManager::parseTemplate("global", array("content" => $content));
		}

		return $content;
	}
}