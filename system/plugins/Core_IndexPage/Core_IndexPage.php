<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_IndexPage;

/**
 * Class Core_IndexPage
 *
 * This plugin manages the software's index page. It binds itself to that
 * particular URL, and responds to it using the showWrap method, which in
 * turn calls some of the other hooks which are defined by this plugin.
 * In this framework, pretty much everything is a hook, including all of the
 * web pages which are fundamental to the forum software.
 *
 * @package BBStandards\Core_IndexPage
 */

class Core_IndexPage extends \BBStandards\Plugin {

	/**
	 * This function binds all of the hooks, so that the index page can
	 * be displayed.
	 */
	public function getHooks() {
		return array(
			"page.module.index" => "showWrap",
			"plugins.indexpage.categories" => "showCategories"
		);
	}

	/**
	 * This method displays the overall page. Different parts of the page
	 * are displayed using other hooks, which are defined in the other
	 * functions below. This function only handles the overall page structure,
	 * nothing more detailed than that.
	 */
	public function showWrap() {
		// Execute any actions set up for before the index page
		\BBStandards\PluginManager::hookAction("plugins.indexpage.start");

		// Fetch the contents of the indexpage template.
		$html = \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_IndexPage", "indexpage", array());

		// Execute any actions set up for after the index page
		\BBStandards\PluginManager::hookAction("plugins.indexpage.stop");

		return $html;
	}

	/**
	 * This method displays the category list. This hook is called inside
	 * the indexpage template, but can also be called elsewhere if need be.
	 */
	public function showCategories() {
		// Read the list of categories from the database
		$table = \BBStandards\Database::table("forums");
		$forums = \BBStandards\Database::query("SELECT parent.name AS parent_name, parent.id AS parent_id, child.name, child.id, child.description, child.icon FROM ".$table." AS parent LEFT JOIN ".$table." AS child ON child.parent = parent.id WHERE parent.parent = 0 ORDER BY parent.order, child.order");

		foreach($forums as $forum) {
			$categories[$forum->parent_id][] = $forum;
		}

		$args = array("categories" => $categories);

		// Insert the data into the categorylist template
		$html = \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_IndexPage", "categorylist", $args);

		// Return the data
		return $html;
	}
}