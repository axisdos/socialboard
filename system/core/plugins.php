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

class PluginManager {
	private static $directories;
	private static $hooks;
	private static $plugins;

	public static function init() {
		self::$hooks = array();
		self::$plugins = array();

		self::$directories = array();
		array_push(self::$directories, "data/plugins");
		array_push(self::$directories, "system/plugins");

		foreach (self::$directories as $dir) {
			if (is_dir($dir)) {
				self::loadPluginDirectory($dir);
			}
		}
	}

	private static function loadPluginDirectory($dir) {
		$dh  = opendir($dir);
		while (false !== ($filename = readdir($dh))) {
			if (substr($filename,0,1) == ".") continue;
			$plugin = $dir."/$filename";
			self::loadPlugin($filename, $plugin);
		}
	}

	private static function loadPlugin($plugin, $dir) {

		$hook = "$dir/$plugin.php";
		require_once($hook);

		$classname = "\\BBStandards\\$plugin\\$plugin";
		$object = new $classname();
		array_push(self::$plugins, $object);

		foreach ($object->getHooks() as $hook => $functionName) {
			self::$hooks[$hook][] = array($object, $classname, $functionName);
		}
	}

	public static function hook($name, $args = array()) {
		if (!array_key_exists($name, self::$hooks)) return array();

		$values = array();

		foreach(self::$hooks[$name] as $hook) {
			$object = $hook[0];
			$class = $hook[1];
			$method = $hook[2];

			$reflectionMethod = new \ReflectionMethod($class, $method);
			$values[] = $reflectionMethod->invoke($object, $args);
		}

		return $values;
	}

	/* ===== Action Hooks ===== */
	public static function hookAction($name, $args = array()) {
		self::hook($name, $args);
	}

	/* ===== Mathematical Hooks ===== */
	public static function hookSum($name, $args = array()) {
		$values = self::hook($name, $args);

		$sum = 0;
		foreach ($values as $value) $sum += $value;
		return $sum;
	}

	public static function hookAverage($name, $args = array()) {
		$values = self::hook($name, $args);

		$sum = 0;
		foreach ($values as $value) $sum += $value;
		return $sum/count($values);
	}

	public static function hookFactor($name, $args = array()) {
		$values = self::hook($name, $args);

		$factor = 0;
		foreach ($values as $value) $factor *= $value;
		return $factor;
	}

	/* ===== Boolean Hooks ===== */
	public static function hookAnd($name, $args = array()) {
		$values = self::hook($name, $args);

		foreach ($values as $value) if (!$value) return false;
		return true;
	}

	public static function hookOr($name, $args = array()) {
		$values = self::hook($name, $args);

		foreach ($values as $value) if ($value) return true;
		return false;
	}

	public static function hookNand($name, $args = array()) {
		return !self::hookAnd($name, $args);
	}

	public static function hookNor($name, $args = array()) {
		return !self::hookOr($name, $args);
	}

	/* ===== String Hooks ===== */
	public static function hookAppend($name, $args = array()) {
		$values = self::hook($name, $args);
		$text = "";

		foreach ($values as $value) $text .= $value;

		return $text;
	}

	public static function hookPrepend($name, $args = array()) {
		$values = self::hook($name, $args);
		$text = "";

		foreach ($values as $value) $text = $value.$text;

		return $text;
	}

	public static function hookText($name, $args = array()) {
		return self::hookAppend($name, $args);
	}

	public static function hookModify($name, $text, $args) {
		if (!array_key_exists($name, self::$hooks)) return array();

		foreach(self::$hooks[$name] as $hook) {
			$object = $hook[0];
			$class = $hook[1];
			$method = $hook[2];

			$reflectionMethod = new \ReflectionMethod($class, $method);
			$text = $reflectionMethod->invoke($object, $text, $args);
		}

		return $text;
	}
}

abstract class Plugin {
	public function getName() {

	}

	public abstract function getHooks();
}