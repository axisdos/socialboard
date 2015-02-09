<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_AuthService;

/**
 * Class Core_AuthService
 *
 * This service handles authentication. Specifically, it establishes the
 * user's credentials on each page view, and stores them in the core class
 * which maintains this information, called IdentityManager.
 *
 * Also, this class handles the controller side of login pages, etc.
 * Basically, if it has to do with authentication, this class handles it.
 *
 * @package BBStandards\Core_AuthService
 */
class Core_AuthService extends \BBStandards\Plugin {

	// This stores an error from login/register forms
	private $error = "";

	public function getHooks() {
		return array(
			"global.start" => "initLogin",
			"page.module.login" => "showLogin",

			"page.module.register" => "showRegister",
			"plugins.authservice.register.action" => "processRegistration",
			"plugins.authservice.register.action.validate" => "validateRegistration",

			"html.menu.login" => "showLoginWidget",
		);
	}

	/**
	 * This function is the login which determines whether a user is logged
	 * in, and what access level they have. This is bound to the global.start
	 * hook, which means it runs at every page load.
	 */
	public function initLogin() {
		$user = self::readCookie("user");
		$token = self::readCookie("token");
	}

	/**
	 * This function is the controller logic for the showLogin page. It is
	 * bound to the hook which is called when the user visits /login/, meaning
	 * that is solely controls displaying the login page, and processing
	 * user logins.
	 */
	public function showLogin() {
		// Execute any actions set up for before the login page
		\BBStandards\PluginManager::hookAction("plugins.authservice.login.start");

		// Fetch the contents of the loginpage template.
		$html = \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_AuthService", "loginpage", array());

		// Execute any actions set up for after the index page
		\BBStandards\PluginManager::hookAction("plugins.authservice.login.stop");

		return $html;
	}

	/**
	 * This function displays the registration page, and is bound to the
	 * hook which is called when the user visits /register/.
	 */
	public function showRegister() {

		// Execute any actions set up for before the login page
		\BBStandards\PluginManager::hookAction("plugins.authservice.register.start");

		if (isset($_POST["username"])) {
			\BBStandards\PluginManager::hookAction("plugins.authservice.register.action.before");
			\BBStandards\PluginManager::hookAction("plugins.authservice.register.action");
			\BBStandards\PluginManager::hookAction("plugins.authservice.register.action.after");
		}

		// Fetch the contents of the loginpage template.
		$html = \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_AuthService", "registerpage", array("error" => $this->error));

		// Execute any actions set up for after the index page
		\BBStandards\PluginManager::hookAction("plugins.authservice.register.stop");

		return $html;
	}

	/**
	 * This function is bound to the event which is invoked whenever a request
	 * to register an account is received.
	 */
	public function processRegistration() {
		$valid = \BBStandards\PluginManager::hookAnd("plugins.authservice.register.action.validate");

		if ($valid) {
			$name = htmlentities($_POST["username"]);
			$email = htmlentities($_POST["email"]);
			$password = $_POST["password"];

			$table = \BBStandards\Database::table("users");
			\BBStandards\Database::execute("INSERT INTO ".$table." (name, email) VALUES(?, ?)", array($name, $email));
		}
	}

	/**
	 * This function checks the registration request to make sure that it
	 * is valid. It is a hook which is bound to the request which is sent
	 * out by processRegistration. If this function returns true, and all
	 * other functions bound to that event return true, then the registration
	 * happens.
	 *
	 * However, other functions to that hook can decline the
	 * registration. Very useful when writing plugins which perform
	 * extra validation for spam prevention, for example.
	 */
	public function validateRegistration() {
		$name = htmlentities($_POST["username"]);
		$email = htmlentities($_POST["email"]);
		$password = $_POST["password"];
		$confirm = $_POST["confirm"];

		// Check the length of name
		if (strlen($name) < 1 || strlen($name) > 128) {
			$this->error = "Username needs to be between 1-128 characters in size";
			return false;
		}

		// Check the length of email
		if (strlen($email) < 4 || strlen($email) > 128) {
			$this->error = "Email needs to be between 4-128 characters in size";
			return false;
		}

		// Check the length of the password
		if (strlen($password) < 4) {
			$this->error = "Username needs to be between longer thn 3 characters";
			return false;
		}

		// Check whether the user typed in the password consistently
		if ($password != $confirm) {
			$this->error = "The password confirmation you typed in was not identical to the password you typed in.";
			return false;
		}

		// Make sure that the email is a valid email address
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->error = "Email needs to be correctly formatted.";
			return false;
		}

		// Check to see if the user already exists
		$table = \BBStandards\Database::table("users");
		$existing = \BBStandards\Database::query("SELECT * FROM ".$table." WHERE email=? OR name=?", array($email, $name));

		// If the user already exists, deny the registration
		if (count($existing) > 0) {
			$this->error = "A user already exists with that username or email.";
			return false;
		}

		// If all checks pass, return true and allow the registration.
		return true;

	}

	/**
	 * This hook displays the login widget at the location which the theme
	 * has delegated to displaying it.
	 */
	public function showLoginWidget() {
		return \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_AuthService", "loginwidget_guest", array());
	}

	/**
	 * This is a utility function for reading cookies.
	 */
	private static function readCookie($name) {
		$key = "bbs_".BBSTANDARDS_COOKIE_PREFIX."_$name";

		if (isset($_COOKIE[$key])) {
			return $_COOKIE[$key];
		} else {
			return "";
		}
	}
}