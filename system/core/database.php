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
 * Class Database
 *
 * This class is a simple front-end for PHP PDO, which allows the code to
 * interact with the database.
 *
 * @package BBStandards
 */
class Database {
	private static $db;

	public static function init() {
		$server = BBSTANDARDS_MYSQL_SERVER;
		$name = BBSTANDARDS_MYSQL_DATABASE;
		$username = BBSTANDARDS_MYSQL_USER;
		$password = BBSTANDARDS_MYSQL_PASSWORD;

		self::$db = new \PDO("mysql:host=$server;dbname=$name;charset=utf8", $username, $password);
		self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		self::$db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
	}

	public static function execute($query) {
		return self::$db->exec($query);
	}

	public static function query($query, $params = array()) {
		if (count($params) == 0) {
			return self::$db->query($query);
		} else {
			$stmt = self::$db->prepare($query);
			$stmt->execute($params);
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}
	}

	public static function lastInsertId() {
		return self::$db->lastInsertId();
	}

	public static function table($name) {
		return BBSTANDARDS_MYSQL_PREFIX."_".$name;
	}
}