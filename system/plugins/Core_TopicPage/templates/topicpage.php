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

<?php echo \BBStandards\PluginManager::hookText("plugins.topicpage.before"); ?>

<div class="bbsp-core-TopicPage">
	<?php echo \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_ForumPage", "forumtitle", array("forum" => $params["topic"], "canStart" => $params["canStart"])) ?>
	<div class="bbsp-core-TopicPage-inner bbs-standard-container">
		<div class="bbsp-core-TopicPage-header bbs-standard-header">
			<?php echo $params["topic"]->topic_name ?>
		</div>
		<div class="bbsp-core-TopicPage-posts">
			<?php echo \BBStandards\PluginManager::hookText("plugins.topicpage.posts", array("topic" => $params["topic"], "posts" => $params["posts"], "canPost" => $params["canPost"])); ?>
		</div>

		<?php echo \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_TopicPage", "quickreply", array("topic" => $params["topic"], "canPost" => $params["canPost"])) ?>
	</div>
</div>

<?php echo \BBStandards\PluginManager::hookText("plugins.topicpage.after"); ?>
