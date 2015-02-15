<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_AlertService;

class Core_AlertService extends \BBStandards\Plugin {
	public function getHooks() {
		return array(
			"plugins.alerts.sidebar.show" => "showSidebarUpdates"
		);
	}

	public function showSidebarUpdates() {
		return "";
	}
}