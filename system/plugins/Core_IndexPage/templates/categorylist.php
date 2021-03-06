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

<div class="bbsp-core-IndexPage-categorylist-outer">
	<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.categories.before"); ?>
	<div class="bbsp-core-IndexPage-categorylist-inner">

		<?php foreach ($params["categories"] as $category) { ?>
		<?php echo \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_IndexPage", "category", array("category" => $category)) ?>
		<?php } ?>

	</div>
	<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.categories.after"); ?>
</div>

