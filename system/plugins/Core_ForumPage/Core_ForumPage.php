<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_ForumPage;

/**
 * Class Core_ForumPage
 *
 *
 *
 * @package BBStandards\Core_ForumPage
 */

class Core_ForumPage extends \BBStandards\Plugin {
	public function getHooks() {
		return array(
			"page.module.forum" => "showForum",
			"plugins.forumpage.discussionlist" => "listDiscussions"
		);
	}

	public function showForum($args) {

		\BBStandards\PluginManager::hookAction("plugins.forumpage.viewforum.start");

		$forumTable = \BBStandards\Database::table("forums");
		$forumPermissionsTable = \BBStandards\Database::table("forums_permissions");

		$forums = \BBStandards\Database::query(
			"SELECT ".
				"forum.id AS forum_id, ".
				"forum.name AS forum_name, ".
				"forum.description AS forum_description, ".
				"forum.icon AS forum_icon, ".
				"GROUP_CONCAT(DISTINCT permission.group ORDER BY permission.group) AS permission_groups_defined, ".
				"GROUP_CONCAT(DISTINCT CASE WHEN permission.see = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_see, ".
				"GROUP_CONCAT(DISTINCT CASE WHEN permission.view = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_view, ".
				"GROUP_CONCAT(DISTINCT CASE WHEN permission.read = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_read, ".
				"GROUP_CONCAT(DISTINCT CASE WHEN permission.post = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_post, ".
				"GROUP_CONCAT(DISTINCT CASE WHEN permission.start = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_start ".
			"FROM ".
				$forumTable." AS forum ".
				"LEFT JOIN ".$forumPermissionsTable." AS permission ON forum.id = permission.forum ".
			"WHERE forum.id = ?",
			array($args[0])
		);

		if (count($forums) > 0) {
			\BBStandards\PluginManager::hookAction("plugins.forumpage.viewforum.retrieved", array("forum" => $forums[0]));
			$canSee = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canSee", array("forum" => $forums[0]));
			$canView = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canView", array("forum" => $forums[0]));
			$canRead = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canRead", array("forum" => $forums[0]));
			$canPost = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canPost", array("forum" => $forums[0]));
			$canStart = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canStart", array("forum" => $forums[0]));

			if ($canView) {
				return \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_ForumPage", "forumpage", array("forum" => $forums[0], "canRead" => $canRead, "canPost" => $canPost, "canStart" => $canStart));
			} else {
				return "Page Not Found.";
			}

		} else {
			return "Page Not Found.";
		}

		\BBStandards\PluginManager::hookAction("plugins.forumpage.viewforum.stop");

	}

	public function listDiscussions($params) {
		$forum = $params["forum"];

		$discussionTable = \BBStandards\Database::table("discussions");
		$userTable = \BBStandards\Database::table("users");

		$discussions = \BBStandards\Database::query(
			"SELECT ".
				"discussion.name AS discussion_name, ".
				"discussion.locked AS discussion_locked, ".
				"discussion.hidden AS discussion_hidden, ".
				"discussion.pinned AS discussion_pinned, ".
				"discussion.owner AS discussion_owner, ".
				"user.name AS user_name ".
			"FROM $discussionTable AS discussion ".
				"LEFT JOIN $userTable AS user ON user.id = discussion.owner ".
			"WHERE discussion.forum = ? ".
			"ORDER BY discussion.pinned DESC",
			array($forum->forum_id)
		);

		return \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_ForumPage", "discussions", array("forum" => $forum, "discussions" => $discussions));
	}
}