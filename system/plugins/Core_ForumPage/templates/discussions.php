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
<div class="bbsp-core-ForumPage-body-threadlist-thread">
	<div class="bbsp-core-ForumPage-body-threadlist-thread-name"><?php echo $discussion->discussion_name ?></div>
	<div class="bbsp-core-ForumPage-body-threadlist-thread-meta">Posted by <?php echo $discussion->user_name ?></div>
</div>
<?php } ?>