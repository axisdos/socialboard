<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_AdminForumManager;

class Core_AdminForumManager extends \BBStandards\Plugin {
	public function getHooks() {
		return array(
			// Add menu items
			"html.admin.menu.first" => "showMenuItem",
			"admin.module.forums" => "showForumManager",
			"admin.module.forums.validate" => "canAccess",
		);
	}

	public function showMenuItem() {
		return \AdminHelper::buildMenuItem("forums", "content", "Structure");
	}

	public function showForumManager() {

	}

	public function canAccess() {
		return true;
	}
}