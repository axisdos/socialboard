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

class IdentityManager {

	private static $loggedIn;
	private static $session;

	public static function init() {
		self::$loggedIn = false;
		self::$session = array();
	}

	public static function storeIdentity($row) {

		self::$loggedIn = true;
		self::$session = $row;

	}

	public static function isLoggedIn() {
		return self::$loggedIn;
	}

	public static function getSession() {
		return self::$session;
	}

	public static function isStaff() {
		return self::$loggedIn && self::$session->staff;
	}
}

class SecurityManager {
	public static function createSecureToken($size) {
		return bin2hex(openssl_random_pseudo_bytes($size));
	}
}

/*
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";
	if ( $img ) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}