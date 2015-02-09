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

		$hook = "page.module.$page";
		$content = \BBStandards\PluginManager::hookText($hook, array());
		return $content;
	}
}