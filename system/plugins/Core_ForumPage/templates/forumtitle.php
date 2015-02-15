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
<div class="bbsp-core-ForumPage-header bbs-standard-container">
	<div class="bbsp-core-ForumPage-header-icon bbsp-core-ForumPage-header-icon-left">
		<img src="<?php echo $icon ?>" />
	</div>
	<div class="bbsp-core-ForumPage-header-menu">
		<div class="bbsp-core-ForumPage-header-menu-item">
			<a href="forum/<?php echo $params["forum"]->forum_id ?>/">
				<div class="bbsp-core-ForumPage-header-menu-item-image"><img src="system/public/list.png" /></div>
				<div class="bbsp-core-ForumPage-header-menu-item-link">Forum</div>
			</a>
		</div>
		<div class="bbsp-core-ForumPage-header-menu-item">
			<a href="forum/<?php echo $params["forum"]->forum_id ?>/feed/">
				<div class="bbsp-core-ForumPage-header-menu-item-image"><img src="system/public/chat.png" /></div>
				<div class="bbsp-core-ForumPage-header-menu-item-link">Activity</div>
			</a>
		</div>
		<div class="bbsp-core-ForumPage-header-menu-item">
			<a href="forum/<?php echo $params["forum"]->forum_id ?>/rules/">
				<div class="bbsp-core-ForumPage-header-menu-item-image"><img src="system/public/rules.png" /></div>
				<div class="bbsp-core-ForumPage-header-menu-item-link">Rules</div>
			</a>
		</div>
		<?php if ($params["canStart"]) { ?>
		<div class="bbsp-core-ForumPage-header-menu-item bbsp-core-ForumPage-header-menu-item-create">
			<a href="forum/<?php echo $params["forum"]->forum_id ?>/post/">
				<div class="bbsp-core-ForumPage-header-menu-item-image"><img src="system/public/add.png" /></div>
				<div class="bbsp-core-ForumPage-header-menu-item-link">Create</div>
			</a>
		</div>
		<?php } ?>
	</div>
	<a href="forum/<?php echo $params["forum"]->forum_id ?>"><h1><?php echo $params["forum"]->forum_name ?></h1>
		<h2><?php echo $params["forum"]->forum_description ?></h2></a>
</div>