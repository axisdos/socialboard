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

<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.before"); ?>

<div class="bbsp-core-IndexPage">
	<div class="bbsp-core-IndexPage-inner bbs-standard-container">
		<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.categories"); ?>
		<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.userfeed"); ?>
	</div>
</div>

<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.after"); ?>
