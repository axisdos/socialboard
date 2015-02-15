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

<div class="bbsp-core-FeedService">
	<div class="bbsp-core-FeedService-items">
		<?php foreach ($params["feed"] as $item) { ?>
		<?php echo \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_FeedService", "topic", array("item" => $item)) ?>
		<?php } ?>
	</div>
</div>