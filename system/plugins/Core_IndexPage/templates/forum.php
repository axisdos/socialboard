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

<div class="bbsp-core-IndexPage-forum">
	<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.forum.before", array("forum" => $params["forum"])); ?>
	<a href="forum/<?php echo $params["forum"]->id ?>/" class="bbsp-core-IndexPage-forum-link"><div class="bbsp-core-IndexPage-forum-inner">
		<div class="bbsp-core-IndexPage-forum-inner-name"><?php echo $params["forum"]->name ?></div>
		<div class="bbsp-core-IndexPage-forum-inner-description"><?php echo $params["forum"]->description ?></div>
	</div></a>
	<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.forum.before", array("forum" => $params["forum"])); ?>
</div>