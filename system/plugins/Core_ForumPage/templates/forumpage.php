<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

//$icon = $params["forum"]->forum_icon;
//if ($icon == "") $icon = "system/public/ForumIcon.png";

?>

<?php echo \BBStandards\PluginManager::hookText("plugins.forumpage.before"); ?>

<div class="bbsp-core-ForumPage">
	<div class="bbsp-core-ForumPage-body">
		<div class="bbsp-core-ForumPage-body-table">
			<div class="bbsp-core-ForumPage-body-threadlist">
				<?php echo \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_ForumPage", "forumtitle", array("forum" => $params["forum"], "canStart" => $params["canStart"])) ?>
				<div class="bbsp-core-ForumPage-body-threadlist-inner">
					<div class="bbsp-core-ForumPage-body-threadlist-inner-list">
						<?php echo \BBStandards\PluginManager::hookText("plugins.forumpage.discussionlist", array("forum" => $params["forum"])); ?>
					</div>
				</div>

			</div>
			<div class="bbsp-core-ForumPage-body-sidebar">
				<!--<div class="bbsp-core-ForumPage-body-feed-header">
					Activity Feed
				</div>-->
				<?php //echo \BBStandards\PluginManager::hookText("plugins.feed.show", array("forum" => $params["forum"])); ?>
			</div>
		</div>
	</div>
</div>

<?php echo \BBStandards\PluginManager::hookText("plugins.forumpage.after"); ?>
