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

<div class="bbsp-core-IndexPage-category">
	<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.category.before", array("category" => $params["category"])); ?>
	<div class="bbsp-core-IndexPage-category-header bbs-standard-header">
		<?php echo $params["category"][0]->parent_name ?>
	</div>
	<div class="bbsp-core-IndexPage-category-forums">
		<?php foreach ($params["category"] as $forum) { ?>
			<?php echo \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_IndexPage", "forum", array("forum" => $forum)) ?>
		<?php } ?>
	</div>
	<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.category.before", array("category" => $params["category"])); ?>
</div>