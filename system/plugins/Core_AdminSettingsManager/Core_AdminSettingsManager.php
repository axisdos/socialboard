<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_AdminSettingsManager;

class Core_AdminSettingsManager extends \BBStandards\Plugin {
	public function getHooks() {
		return array(
			// Add menu items
			"html.admin.menu.last" => "showMenuItem",
			"admin.module.settings" => "showSettings",
			"admin.module.settings.validate" => "canAccess",
		);
	}

	public function showMenuItem() {
		return \AdminHelper::buildMenuItem("settings", "settings", "settings");
	}

	public function showSettings() {

	}

	public function canAccess() {
		return true;
	}
}