<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_MarkdownService;

class Core_MarkdownService extends \BBStandards\Plugin {
	public function getHooks() {
		return array(
			"plugins.parse.usertext" => "applyMarkdown"
		);
	}

	public function applyMarkdown($text, $args) {
		$markdown = new \Michelf\MarkdownExtra();
		$markdown->no_markup = false;
		return $markdown->transform($text);
	}
}