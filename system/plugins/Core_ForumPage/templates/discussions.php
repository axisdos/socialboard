<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

?>

<?php foreach ($params["discussions"] as $discussion) if (\BBStandards\PluginManager::hookAnd("plugins.forumpage.topic.canRead", array("forum" => $params["forum"], "discussion" => $discussion))) { ?>
<div class="bbsp-core-ForumPage-body-threadlist-thread-outer">
	<a href="discussion/<?php echo $discussion->discussion_id ?>/"><div class="bbsp-core-ForumPage-body-threadlist-thread">
		<div class="bbsp-core-ForumPage-body-threadlist-thread-latest"><div>Latest post</div><div>by <?php echo $discussion->latest_user_name ?></div></div>
		<div class="bbsp-core-ForumPage-body-threadlist-thread-latest-avatar"><img src="<?php echo \BBStandards\get_gravatar($discussion->latest_user_email, 36) ?>" /></div>
		<div class="bbsp-core-ForumPage-body-threadlist-thread-views"><div class="bbsp-core-ForumPage-body-threadlist-thread-stat-number"><?php echo $discussion->discussion_views ?></div><div class="bbsp-core-ForumPage-body-threadlist-thread-stat-label">Views</div></div>
		<div class="bbsp-core-ForumPage-body-threadlist-thread-replies"><div class="bbsp-core-ForumPage-body-threadlist-thread-stat-number"><?php echo $discussion->discussion_replies ?></div><div class="bbsp-core-ForumPage-body-threadlist-thread-stat-label">Replies</div></div>
		<div class="bbsp-core-ForumPage-body-threadlist-thread-image"><img src="<?php echo \BBStandards\get_gravatar($discussion->user_email, 36) ?>" /></div>
		<div class="bbsp-core-ForumPage-body-threadlist-thread-name"><?php echo $discussion->discussion_name ?></div>
		<div class="bbsp-core-ForumPage-body-threadlist-thread-meta">Posted by <?php echo $discussion->user_name ?></div>
	</div></a>
</div>
<?php } ?>