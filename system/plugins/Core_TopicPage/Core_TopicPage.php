<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_TopicPage;

/**
 * Class Core_TopicPage
 *
 *
 *
 * @package BBStandards\Core_TopicPage
 */

class Core_TopicPage extends \BBStandards\Plugin {
	public function getHooks() {
		return array(
			"page.module.discussion" => "showTopic",
			"plugins.topicpage.posts" => "listPosts",
			"plugins.topicpage.newreply.validate" => "validateReply"
		);
	}

	public function showTopic($args) {

		\BBStandards\PluginManager::hookAction("plugins.topicpage.viewforum.start");

		$topicTable = \BBStandards\Database::table("discussions");
		$forumTable = \BBStandards\Database::table("forums");
		$postTable = \BBStandards\Database::table("replies");
		$userTable = \BBStandards\Database::table("users");
		$forumPermissionsTable = \BBStandards\Database::table("forums_permissions");

		$topics = \BBStandards\Database::query(
			"SELECT ".
			"topic.id AS topic_id, ".
			"topic.name AS topic_name, ".
			"topic.locked AS topic_locked, ".
			"topic.hidden AS topic_hidden, ".
			"topic.pinned AS topic_pinned, ".
			"topic.featured AS topic_featured, ".
			"topic.replies AS topic_replies, ".
			"topic.views AS topic_views, ".
			"forum.id AS forum_id, ".
			"forum.name AS forum_name, ".
			"forum.description AS forum_description, ".
			"forum.icon AS forum_icon, ".
			"user.id AS user_id, ".
			"user.email AS user_email, ".
			"user.name AS user_name, ".
			"GROUP_CONCAT(DISTINCT permission.group ORDER BY permission.group) AS permission_groups_defined, ".
			"GROUP_CONCAT(DISTINCT CASE WHEN permission.see = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_see, ".
			"GROUP_CONCAT(DISTINCT CASE WHEN permission.view = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_view, ".
			"GROUP_CONCAT(DISTINCT CASE WHEN permission.read = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_read, ".
			"GROUP_CONCAT(DISTINCT CASE WHEN permission.post = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_post, ".
			"GROUP_CONCAT(DISTINCT CASE WHEN permission.start = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_start ".
			"FROM ".
			$topicTable." AS topic ".
			"LEFT JOIN ".$forumTable." AS forum ON topic.forum = forum.id ".
			"LEFT JOIN ".$forumPermissionsTable." AS permission ON forum.id = permission.forum ".
			"LEFT JOIN ".$userTable." AS user ON topic.owner = user.id ".
			"WHERE topic.id = ?",
			array($args[0])
		);

		if (count($topics) > 0) {
			\BBStandards\PluginManager::hookAction("plugins.forumpage.viewforum.retrieved", array("forum" => $topics[0]));
			$canSee = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canSee", array("forum" => $topics[0]));
			$canView = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canView", array("forum" => $topics[0]));
			$canRead = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canRead", array("forum" => $topics[0]));
			$canPost = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canPost", array("forum" => $topics[0]));
			$canStart = \BBStandards\PluginManager::hookAnd("plugins.forumpage.canStart", array("forum" => $topics[0]));

			if ($canView) {

				if (isset($_POST["content"]) && $canPost) {
					$this->processPostQuickReply($topics[0]);
				}

				$posts = \BBStandards\Database::query(
					"SELECT ".
					"post.id AS post_id, ".
					"post.content AS post_content, ".
					"post.id AS post_views, ".
					"post.parsed AS post_parsed, ".
					"user.id AS user_id, ".
					"user.email AS user_email, ".
					"user.name AS user_name ".
					"FROM ".
					$postTable." AS post ".
					"LEFT JOIN ".$userTable." AS user ON post.poster = user.id ".
					"WHERE post.discussion = ?",
					array($args[0])
				);

				return \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_TopicPage", "topicpage", array("topic" => $topics[0], "posts" => $posts, "canRead" => $canRead, "canPost" => $canPost, "canStart" => $canStart));
			} else {
				return "Page Not Found.";
			}

		} else {
			return "Page Not Found.";
		}

		\BBStandards\PluginManager::hookAction("plugins.topicpage.viewforum.stop");

	}

	public function processPostQuickReply($topic) {
		$content = htmlentities(stripslashes($_POST["content"]));
		$valid = \BBStandards\PluginManager::hookAnd("plugins.topicpage.newreply.validate", array("topic" => $topic, "content" => $content));
		$parsed = \BBstandards\PluginManager::hookModify("plugins.parse.usertext", $content, array("topic" => $topic));

		if ($valid) {
			$discussionId = $topic->topic_id;
			$replyTable = \BBStandards\Database::table("replies");

			\BBStandards\Database::execute(
				"INSERT INTO $replyTable ".
				"(discussion, poster, content, parsed, `created`) VALUES ".
				"(?, ?, ?, ?, ?)",
				array($discussionId, \BBStandards\IdentityManager::getSession()->user_id, $content, $parsed, time())
			);

			header("Location: ".BBSTANDARDS_WEBSITE_LINK."discussion/".$discussionId."/");
		}

	}

	public function validateReply($params) {
		return strlen($params["content"]) > 0;
	}

	public function listPosts($params) {
		$content = "";
		foreach ($params["posts"] as $post)
			$content .= \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_TopicPage", "post", array("topic" => $params["topic"], "post" => $post, "canPost" => $params["canPost"]));
		return $content;
	}
}