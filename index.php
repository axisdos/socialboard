<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

// Include required files
require_once("system/core/settings.php");
require_once("system/core/database.php");
require_once("system/core/templates.php");
require_once("system/core/plugins.php");
require_once("system/core/request.php");
require_once("system/core/response.php");

try {
	// Initialize the software
	\BBStandards\Settings::init();
	\BBStandards\Database::init();
	\BBStandards\TemplateManager::init();
	\BBStandards\PluginManager::init();
	\BBStandards\Request::init();
	\BBStandards\Response::init();

	// Call a few plugin hooks before doing anything
	\BBstandards\PluginManager::hookAction("global.start");

	// Prepare the response to send to the user
	$content = \BBStandards\Response::prepare();

	// Call a  plugin hook before displaying anything
	\BBstandards\PluginManager::hookAction("global.beforeFormat");

	// Format the response into the global template
	$html = \BBStandards\TemplateManager::parseTemplate("global", array("content" => $content));

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