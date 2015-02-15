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
use BBStandards\IdentityManager;

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
			"page.module.forum" => "determinePage",
			"plugins.forumpage.discussionlist" => "listDiscussions",

			"plugins.forumpage.newtopic.validate" => "validateNewDiscussion"
		);
	}

	public function determinePage($args) {
		if (count($args) == 0) {
			return "Not found";
		} else if (count($args) > 0) {

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

			if (count($forums) == 0) {
				return "Page Not Found.";
			}

			\BBStandards\PluginManager::hookAction("plugins.forumpage.viewforum.retrieved", array("forum" => $forums[0]));
			$canSee = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canSee", array("forum" => $forums[0]));
			$canView = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canView", array("forum" => $forums[0]));
			$canRead = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canRead", array("forum" => $forums[0]));
			$canPost = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canPost", array("forum" => $forums[0]));
			$canStart = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canStart", array("forum" => $forums[0]));

			if (count($args) > 1) {
				if ($args[1] == "post" && $canView && $canStart) {
					return $this->showPostForm($args, $forums[0], $canSee, $canView, $canRead, $canPost, $canStart);
				} else {
					return $this->showForum($args, $forums[0], $canSee, $canView, $canRead, $canPost, $canStart);
				}
			} else {
				return $this->showForum($args, $forums[0], $canSee, $canView, $canRead, $canPost, $canStart);
			}
		}
	}

	public function showForum($args, $forum, $canSee, $canView, $canRead, $canPost, $canStart) {

		\BBStandards\PluginManager::hookAction("plugins.forumpage.viewforum.start");


		if ($canView) {
			return \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_ForumPage", "forumpage", array("forum" => $forum, "canRead" => $canRead, "canPost" => $canPost, "canStart" => $canStart));
		} else {
			return "Page Not Found.";
		}

		\BBStandards\PluginManager::hookAction("plugins.forumpage.viewforum.stop");

	}

	public function listDiscussions($params) {
		$forum = $params["forum"];

		$discussionTable = \BBStandards\Database::table("discussions");
		$userTable = \BBStandards\Database::table("users");
		$replyTable = \BBStandards\Database::table("replies");

		$discussions = \BBStandards\Database::query(
			"SELECT ".
				"discussion.id AS discussion_id, ".
				"discussion.name AS discussion_name, ".
				"discussion.locked AS discussion_locked, ".
				"discussion.hidden AS discussion_hidden, ".
				"discussion.pinned AS discussion_pinned, ".
				"discussion.owner AS discussion_owner, ".
				"discussion.replies AS discussion_replies, ".
				"discussion.views AS discussion_views, ".
				"user.name AS user_name, ".
				"user.email AS user_email, ".
				"latest.created AS latest_time, ".
				"latest.id AS latest_id, ".
				"latest_user.id AS latest_user_id, ".
				"latest_user.email AS latest_user_email, ".
				"latest_user.name AS latest_user_name ".
			"FROM $discussionTable AS discussion ".
				"LEFT JOIN $userTable AS user ON user.id = discussion.owner ".
				"LEFT JOIN $replyTable AS latest ON latest.discussion = discussion.id ".
				"LEFT JOIN $userTable AS latest_user ON latest_user.id = latest.poster ".
			"WHERE discussion.forum = ? ".
			"GROUP BY discussion.id ".
			"ORDER BY discussion.pinned DESC, discussion.bumped DESC",
			array($forum->forum_id)
		);

		return \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_ForumPage", "discussions", array("forum" => $forum, "discussions" => $discussions));
	}

	public function showPostForm($args, $forum, $canSee, $canView, $canRead, $canPost, $canStart) {

		if (isset($_POST["name"])) {
			$name = htmlentities(stripslashes($_POST["name"]));
			$content = htmlentities(stripslashes($_POST["content"]));
			$valid = \BBStandards\PluginManager::hookAnd("plugins.forumpage.newtopic.validate", array("forum" => $forum, "name" => $name, "content" => $content));

			if ($valid) {

				$discussionTable = \BBStandards\Database::table("discussions");
				$replyTable = \BBStandards\Database::table("replies");

				\BBStandards\Database::execute(
					"INSERT INTO $discussionTable ".
					"(forum, name, owner, `created`, bumped) VALUES ".
					"(?, ?, ?, ?)",
					array($forum->forum_id, $name, IdentityManager::getSession()->user_id, time(), time())
				);

				$discussionId = \BBStandards\Database::lastInsertId();

				\BBStandards\Database::execute(
					"INSERT INTO $replyTable ".
					"(discussion, poster, content, parsed, `created`) VALUES ".
					"(?, ?, ?, ?, ?)",
					array($discussionId, IdentityManager::getSession()->user_id, $content, $content, time())
				);

				header("Location: ".BBSTANDARDS_WEBSITE_LINK."discussion/$discussionId/");
			}
		}

		return \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_ForumPage", "postform", array("forum" => $forum, "canStart" => $canStart));
	}

	public function validateNewDiscussion($params) {
		return strlen($params["name"]) > 2 && strlen($params["content"]) > 2;
	}
}