<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

namespace BBStandards\Core_FeedService;

class Core_FeedService extends \BBStandards\Plugin {
	public function getHooks() {
		return array(
			"plugins.feed.show" => "openFeed"
		);
	}

	public function openFeed($params) {

		if (array_key_exists("forum", $params)) {
			$feed = $this->openFeedForum($params["forum"]);
		} else {
			$feed = $this->openFeedUser();
		}

		return $this->showFeed($feed);

	}

	public function openFeedForum($forum) {
		$discussionTable = \BBStandards\Database::table("discussions");
		$userTable = \BBStandards\Database::table("users");
		$forumTable = \BBStandards\Database::table("forums");
		$forumPermissionsTable = \BBStandards\Database::table("forums_permissions");

		$discussions = \BBStandards\Database::query(
			"SELECT ".
				"discussion.id AS discussion_id, ".
				"discussion.name AS discussion_name, ".
				"discussion.locked AS discussion_locked, ".
				"discussion.hidden AS discussion_hidden, ".
				"discussion.pinned AS discussion_pinned, ".
				"discussion.owner AS discussion_owner, ".
				"user.name AS user_name, ".
				"user.email AS user_email ".
			"FROM $discussionTable AS discussion ".
				"LEFT JOIN $userTable AS user ON user.id = discussion.owner ".
			"WHERE discussion.forum = ? ".
			"ORDER BY discussion.pinned DESC",
			array($forum->forum_id)
		);

		$feed = array();

		foreach ($discussions as $discussion) {
			// Set the properties which are already in the forum row
			foreach ($forum as $key => $value) {
				$discussion->$key = $value;
			}

			// Add the item to the feed
			array_push($feed, array($discussion, $this->openPosts($discussion)));
		}

		return $feed;
	}

	public function openFeedUser() {
		$discussionTable = \BBStandards\Database::table("discussions");
		$userTable = \BBStandards\Database::table("users");
		$forumTable = \BBStandards\Database::table("forums");
		$forumPermissionsTable = \BBStandards\Database::table("forums_permissions");

		$discussions = \BBStandards\Database::query(
			"SELECT ".
				"discussion.id AS discussion_id, ".
				"discussion.name AS discussion_name, ".
				"discussion.locked AS discussion_locked, ".
				"discussion.hidden AS discussion_hidden, ".
				"discussion.pinned AS discussion_pinned, ".
				"discussion.owner AS discussion_owner, ".
				"forum.id AS forum_id, ".
				"forum.name AS forum_name, ".
				"forum.description AS forum_description, ".
				"forum.icon AS forum_icon, ".
				"user.name AS user_name, ".
				"user.email AS user_email, ".
				"GROUP_CONCAT(DISTINCT permission.group ORDER BY permission.group) AS permission_groups_defined, ".
				"GROUP_CONCAT(DISTINCT CASE WHEN permission.see = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_see, ".
				"GROUP_CONCAT(DISTINCT CASE WHEN permission.view = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_view, ".
				"GROUP_CONCAT(DISTINCT CASE WHEN permission.read = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_read, ".
				"GROUP_CONCAT(DISTINCT CASE WHEN permission.post = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_post, ".
				"GROUP_CONCAT(DISTINCT CASE WHEN permission.start = 1 THEN permission.group ELSE NULL END ORDER BY permission.group) AS permission_groups_start ".
			"FROM $discussionTable AS discussion ".
				"LEFT JOIN $userTable AS user ON user.id = discussion.owner ".
				"LEFT JOIN $forumTable AS forum ON discussion.forum = forum.id ".
				"LEFT JOIN $forumPermissionsTable AS permission ON forum.id = permission.forum ".
			"WHERE 1=1 ".
			"ORDER BY discussion.pinned DESC",
			array()
		);

		$feed = array();

		foreach ($discussions as $discussion) {
			array_push($feed, array($discussion, $this->openPosts($discussion)));
		}

		return $feed;
	}

	public function openPosts($discussion) {
		$discussionTable = \BBStandards\Database::table("discussions");
		$userTable = \BBStandards\Database::table("users");
		$postTable = \BBStandards\Database::table("replies");

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
			array($discussion->discussion_id)
		);

		return $posts;
	}

	public function showFeed($feed) {
		return \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_FeedService", "feed", array("feed" => $feed));
	}
}