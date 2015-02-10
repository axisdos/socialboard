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
	private static $args;

	public static function init() {
		self::$link = (isset($_GET["q"]))?$_GET["q"]:"/";
		self::$page = self::identifyPage(self::$link);
	}

	public static function identifyPage($link) {
		$bits = explode("/", $link);

		if (count($bits) == 0) {
			self::$args = array();
			return "index";
		} else if ($bits[0] == "") {
			self::$args = array();
			return "index";
		} else {
			$module = array_shift($bits);
			self::$args = $bits;
			if (count(self::$args) > 1 && self::$args[count(self::$args)-1] == "") {
				array_pop(self::$args);
			}
			return $module;
		}
	}

	public static function getLink() {
		return self::$link;
	}

	public static function getPage() {
		return self::$page;
	}

	public static function getArguments() {
		return self::$args;
	}


}