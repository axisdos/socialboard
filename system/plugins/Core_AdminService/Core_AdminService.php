<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_AdminService;

class Core_AdminService extends \BBStandards\Plugin {
	public function getHooks() {
		return array(
			// Authentication
			"page.module.admin.fullpage" => "userWantsToAccessACP",
			"plugins.adminservice.access.validate" => "canAccessACP",

			// Add menu items
			"html.admin.menu.first.priority" => "showFirstMenuItems",
			"html.admin.menu.last.priority" => "showLastMenuItems",

			// Fundamental modules
			"admin.module.signout" => "signoutACP"
		);
	}

	public function userWantsToAccessACP() {
		$valid = \BBStandards\PluginManager::hookAnd("plugins.adminservice.access.validate");
		if ($valid) {
			return $this->showAdminPanel();
		} else {
			return \BBStandards\PluginManager::hookText("error.pagenotfound");
		}
	}

	public function canAccessACP() {
		if (\BBstandards\IdentityManager::isAdmin()) {
			return true;
		}

		return false;
	}

	public function showAdminPanel() {
		// Execute any actions set up for before the ACP
		\BBStandards\PluginManager::hookAction("plugins.adminservice.acp.start");

		// Figure out which module is being accessed
		$link = \BBstandards\Request::getArguments();
		$module = array_shift($link);
		if ($module == "") $module = "home";

		// Call the module's hook
		$content = \BBStandards\PluginManager::hookText("admin.module.$module", array("url" => $module));

		// Format content into the ACP template
		$html = \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_AdminService", "adminglobal", array("content" => $content));

		// Execute any actions set up for after the ACP
		\BBStandards\PluginManager::hookAction("plugins.adminservice.acp.start");

		return $html;
	}

	public function showFirstMenuItems() {
		return \AdminHelper::buildMenuItem("home", "home", "Summary");
	}

	public function showLastMenuItems() {
		return \AdminHelper::buildMenuItem("signout", "logout", "Signout");
	}

	public function signoutACP() {
		header("Location: ".BBSTANDARDS_WEBSITE_LINK);
		return "";
	}
}