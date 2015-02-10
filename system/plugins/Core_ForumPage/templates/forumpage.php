<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

$icon = $params["forum"]->forum_icon;
if ($icon == "") $icon = "system/public/ForumIcon.png";

?>

<?php echo \BBStandards\PluginManager::hookText("plugins.forumpage.before"); ?>

<div class="bbsp-core-ForumPage">
	<div class="bbsp-core-ForumPage-header bbs-standard-container">
		<div class="bbsp-core-ForumPage-header-icon bbsp-core-ForumPage-header-icon-left">
			<img src="<?php echo $icon ?>" />
 		</div>
		<div class="bbsp-core-ForumPage-header-icon bbsp-core-ForumPage-header-icon-right">
			<img src="<?php echo $icon ?>" />
		</div>
		<h1><?php echo $params["forum"]->forum_name ?></h1>
		<h2><?php echo $params["forum"]->forum_description ?></h2>
	</div>
	<div class="bbsp-core-ForumPage-body bbs-standard-container">
		<div class="bbsp-core-ForumPage-body-table">
			<div class="bbsp-core-ForumPage-body-threadlist">

				<div class="bbsp-core-ForumPage-body-threadlist-inner">
					<div class="bbsp-core-ForumPage-body-threadlist-header">
						Recent Discussions
					</div>
					<div class="bbsp-core-ForumPage-body-threadlist-inner-list">
						<?php echo \BBStandards\PluginManager::hookText("plugins.forumpage.discussionlist", array("forum" => $params["forum"])); ?>
					</div>
				</div>

			</div>
			<div class="bbsp-core-ForumPage-body-feed">
				<div class="bbsp-core-ForumPage-body-threadlist-header">
					Activity Feed
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo \BBStandards\PluginManager::hookText("plugins.forumpage.after"); ?>
