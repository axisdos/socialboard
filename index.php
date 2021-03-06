<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

// Start the php session manager
session_start();

// Include required files
require_once("system/core/settings.php");
require_once("system/core/database.php");
require_once("system/core/hashing.php");
require_once("system/core/templates.php");
require_once("system/core/plugins.php");
require_once("system/core/request.php");
require_once("system/core/response.php");
require_once("system/core/auth.php");
require_once("system/core/helper.php");
require_once("system/libraries/Michelf/MarkdownExtra.inc.php");

try {
	// Initialize the software
	\BBStandards\Settings::init();
	\BBStandards\Database::init();
	\BBStandards\TemplateManager::init();
	\BBStandards\PluginManager::init();
	\BBStandards\Request::init();
	\BBStandards\Response::init();
	\BBStandards\IdentityManager::init();

	// Call a few plugin hooks before doing anything
	\BBstandards\PluginManager::hookAction("global.start");

	// Prepare the response to send to the user
	$html = \BBStandards\Response::prepare();

	// Call a few plugin hooks before displaying
	\BBstandards\PluginManager::hookAction("global.beforeDisplay");

	// Send the formatted response to the user
	echo $html;

	// Call a few plugin hooks before doing anything
	\BBstandards\PluginManager::hookAction("global.stop");
} catch (Exception $e) {
	// If an error occurs, show the error page
	require_once("system/errors/init.php");
}