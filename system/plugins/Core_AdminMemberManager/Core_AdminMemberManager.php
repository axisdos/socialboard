<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_AdminMemberManager;

class Core_AdminMemberManager extends \BBStandards\Plugin {
	public function getHooks() {
		return array(
			// Add menu items
			"html.admin.menu.first" => "showMenuItem",
			"admin.module.members" => "showMemberManager",
			"admin.module.members.validate" => "canAccess",
		);
	}

	public function showMenuItem() {
		return \AdminHelper::buildMenuItem("members", "user", "Members");
	}

	public function showMemberManager() {

	}

	public function canAccess() {
		return true;
	}
}