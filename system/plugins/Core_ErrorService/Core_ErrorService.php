<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_ErrorService;

class Core_ErrorService extends \BBStandards\Plugin {
	public function getHooks() {
		return array(
			"error.pagenotfound" => "showPageNotFound"
		);
	}

	public function showPageNotFound() {
		return "Page Not Found";
	}
}