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
use BBStandards\IdentityManager;

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
			// This hook establishes the user's login on each pageview
			"global.start" => "initLogin",

			// These hooks are GUI widgets embedded into the site
			"html.menu.login" => "showMemberWidget",
			"html.rightmenu" => "showLoginWidget",

			// These hooks pertain to registering
			"page.module.register" => "showRegister",
			"plugins.authservice.register.action" => "processRegistration",
			"plugins.authservice.register.action.validate" => "validateRegistration",

			// These hooks pertain to logging in
			"page.module.login" => "showLogin",
			"plugins.authservice.login.action" => "processLogin",
			"plugins.authservice.login.action.validate" => "validateLogin",
			"plugins.authservice.login.perform" => "executeLogin",

			// These hooks pertain to logging out
			"page.module.logout" => "showLogout"
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

		if ($user != "" && $token != "") {
			$sessionTable = \BBStandards\Database::table("sessions");
			$userTable = \BBStandards\Database::table("users");
			$groupTable = \BBStandards\Database::table("groups");
			$assignTable = \BBStandards\Database::table("assignments");
			$permissionsTable = \BBStandards\Database::table("permissions");
			$forumPermissionsTable = \BBStandards\Database::table("forums_permissions");

			$sessions = \BBStandards\Database::query(
				"SELECT ".
					"session.id AS session_id, ".
					"session.address AS session_ip, ".
					"user.id AS user_id, ".
					"user.name AS user_name, ".
					"user.email AS user_email, ".
					"GROUP_CONCAT(DISTINCT assignment.group ORDER BY assignment.group) AS group_memberships, ".
					"GROUP_CONCAT(DISTINCT role.name ORDER BY role.name) AS group_names, ".
					"GROUP_CONCAT(DISTINCT CASE WHEN permission.allowed = '1' THEN permission.key ELSE NULL END ORDER BY permission.key) AS group_allowed, ".
					"GROUP_CONCAT(DISTINCT CASE WHEN permission.never = '1' THEN permission.key ELSE NULL END ORDER BY permission.key) AS group_never, ".
					"GROUP_CONCAT(DISTINCT CASE WHEN userpermission.allowed = '1' THEN userpermission.key ELSE NULL END ORDER BY userpermission.key) AS user_allowed, ".
					"GROUP_CONCAT(DISTINCT CASE WHEN userpermission.never = '1' THEN userpermission.key ELSE NULL END ORDER BY userpermission.key) AS user_never, ".
					"GROUP_CONCAT(DISTINCT CASE WHEN assignment.leader = '1' THEN assignment.group ELSE NULL END ORDER BY assignment.group) AS group_leaderships, ".
					"CASE WHEN role.admin = 1 THEN '1' ELSE '0' END AS admin, ".
					"CASE WHEN role.moderator = 1 THEN '1' ELSE '0' END AS moderator, ".
					"CASE WHEN role.staff = 1 THEN '1' ELSE '0' END AS staff, ".
					"CASE WHEN forumpermission.see = 1 THEN '1' ELSE '0' END AS forum_default_see, ".
					"CASE WHEN forumpermission.view = 1 THEN '1' ELSE '0' END AS forum_default_view, ".
					"CASE WHEN forumpermission.read = 1 THEN '1' ELSE '0' END AS forum_default_read, ".
					"CASE WHEN forumpermission.post = 1 THEN '1' ELSE '0' END AS forum_default_post, ".
					"CASE WHEN forumpermission.start = 1 THEN '1' ELSE '0' END AS forum_default_start, ".
					"CASE WHEN assignment.primary = 1 THEN assignment.group ELSE NULL END AS primary_group ".
				"FROM ".$sessionTable." AS session ".
					"LEFT JOIN ".$userTable." AS user ON session.user = user.id ".
					"LEFT JOIN ".$assignTable." AS assignment ON session.user = assignment.user ".
					"LEFT JOIN ".$groupTable." AS role ON assignment.group = role.id ".
					"LEFT JOIN ".$permissionsTable." AS permission ON role.id = permission.group ".
					"LEFT JOIN ".$permissionsTable." AS userpermission ON session.user = userpermission.user ".
					"LEFT JOIN ".$forumPermissionsTable." AS forumpermission ON (forumpermission.forum = 0 AND forumpermission.group = role.id) ".
				"WHERE session.user=? AND session.token=? AND session.expires > ?",
				array($user, $token, time()));

			if (count($sessions) > 0) {
				IdentityManager::storeIdentity($sessions[0]);
			}
		}
	}

	/**
	 * This hook displays the login widget at the location which the theme
	 * has delegated to displaying it.
	 */
	public function showLoginWidget() {
		if (IdentityManager::isLoggedIn()) {
			return \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_AuthService", "loginwidget_member", array("session" => IdentityManager::getSession()));
		} else {
			return \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_AuthService", "loginwidget_guest", array());
		}
	}

	/**
	 *
	 */
	public function showMemberWidget() {
		if (IdentityManager::isLoggedIn()) {
			return \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_AuthService", "memberwidget", array("session" => IdentityManager::getSession()));
		} else {
			return "";
		}
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
			$name = stripslashes(htmlentities($_POST["username"]));
			$email = htmlentities($_POST["email"]);
			$password = create_hash($_POST["password"]);

			$table = \BBStandards\Database::table("users");
			\BBStandards\Database::execute("INSERT INTO ".$table." (name, email, password) VALUES(?, ?, ?)", array($name, $email, $password));

			\BBStandards\PluginManager::hookAction("plugins.authservice.login.perform", array("id" => \BBStandards\Database::lastInsertId()));
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
		$name = stripslashes(htmlentities($_POST["username"]));
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
	 * This function is the controller logic for the showLogin page. It is
	 * bound to the hook which is called when the user visits /login/, meaning
	 * that is solely controls displaying the login page, and processing
	 * user logins.
	 */
	public function showLogin() {
		// Execute any actions set up for before the login page
		\BBStandards\PluginManager::hookAction("plugins.authservice.login.start");

		if (isset($_POST["email"])) {
			\BBStandards\PluginManager::hookAction("plugins.authservice.login.action");
		}

		// Fetch the contents of the loginpage template.
		$html = \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_AuthService", "loginpage", array("error" => $this->error));

		// Execute any actions set up for after the index page
		\BBStandards\PluginManager::hookAction("plugins.authservice.login.stop");

		return $html;
	}

	/**
	 * This hook processes a POST login request. It calls the validation
	 * hook to determine whether the login is valid, then calls the execution
	 * hook to command the system to log in the user.
	 */
	public function processLogin() {
		\BBStandards\PluginManager::hookAction("plugins.authservice.login.action.before");

		// Fetch the credentials
		$email = $_POST["email"];
		$password = $_POST["password"];

		// Check the credentials
		$valid = \BBStandards\PluginManager::hookAnd("plugins.authservice.login.action.validate", array("email" => $email, "password" => $password));

		if ($valid) {
			// Lookup the user id
			$table = \BBStandards\Database::table("users");
			$row = \BBStandards\Database::query("SELECT * FROM ".$table." WHERE email=?", array($email));
			$userid = $row[0]->id;

			// Send the login command
			\BBStandards\PluginManager::hookAction("plugins.authservice.login.perform", array("id" => $userid));
		} else {
			$this->error = "The login information you entered was incorrect.";
		}

		\BBStandards\PluginManager::hookAction("plugins.authservice.login.action.after");
	}

	/**
	 * This is a boolean hook function which will return whether the
	 * auth service thinks the provided login details are valid. As it
	 * is a hook, other plugins can also inject their own code and decline
	 * the login by binding themselves to the same hook.
	 */
	public function validateLogin($params) {
		// Extract the login details
		$email = $params["email"];
		$password = $params["password"];

		// Fetch the user's account, if it exists
		$table = \BBStandards\Database::table("users");
		$rows = \BBStandards\Database::query("SELECT * FROM ".$table." WHERE email=?", array($email));

		// Check whether the account exists
		$exists = count($rows) > 0;

		// Set the default state for whether it's correct or not
		$correct = false;

		// If it exists, verify the hash
		if ($exists) {
			$hash = $rows[0]->password;
			$correct = validate_password($password, $hash);
		}

		// Only approve login if user exists and hash is verified
		return $exists && $correct;
	}

	/**
	 * This method is bound to the login execution event, meaning that it
	 * will process a login command once it has been DETERMINED that the user
	 * is to be logged in. This method does NOT validate login details.
	 */
	public function executeLogin($params) {
		\BBStandards\PluginManager::hookAction("plugins.authservice.login.perform.before", array("id" => \BBStandards\Database::lastInsertId()));

		$user = $params["id"];
		$token = \BBStandards\SecurityManager::createSecureToken(128);
		$initiated = time();
		$expires = $initiated+(86400*365);
		$ip = htmlentities($_SERVER["REMOTE_ADDR"]);

		$table = \BBStandards\Database::table("sessions");
		\BBStandards\Database::execute("INSERT INTO ".$table." (user, token, initiated, expires, address) VALUES(?, ?, ?, ?, ?)", array($user, $token, $initiated, $expires, $ip));

		self::setCookie("user", $params["id"]);
		self::setCookie("token", $token);

		\BBStandards\PluginManager::hookAction("plugins.authservice.login.perform.after", array("id" => \BBStandards\Database::lastInsertId()));

		header("Location: ".BBSTANDARDS_WEBSITE_LINK);
	}

	public function showLogout() {
		session_destroy();

		self::setCookie("user", "");
		self::setCookie("token", "");

		header("Location: ".BBSTANDARDS_WEBSITE_LINK);
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

	/**
	 * This is a utility function for setting cookies.
	 */
	private static function setCookie($name, $value) {
		if (headers_sent()) {
			throw new \Exception("Headers already sent");
		} else {
			$key = "bbs_".BBSTANDARDS_COOKIE_PREFIX."_$name";

			$domain = $_SERVER["HTTP_HOST"];
			if ($domain == "localhost") $domain = false;

			setcookie($key, $value, time()+(86400*365), "/", $domain);
			$_COOKIE[$key] = $value;
		}

	}
}