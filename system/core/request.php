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

class Request {

	private static $link;
	private static $page;

	public static function init() {
		self::$link = (isset($_GET["q"]))?$_GET["q"]:"/";
		self::$page = self::identifyPage(self::$link);
	}

	public static function identifyPage($link) {
		$bits = explode("/", $link);

		if (count($bits) == 0) {
			return "index";
		} else if ($bits[0] == "") {
			return "index";
		} else {
			return $bits[0];
		}
	}

	public static function getLink() {
		return self::$link;
	}

	public static function getPage() {
		return self::$page;
	}


}