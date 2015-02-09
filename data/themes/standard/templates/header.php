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
<?php echo \BBStandards\PluginManager::hookText("html.header.before", array()); ?>
<div class="bbs-header">
	<div class="bbs-header-inner bbs-standard-container">
		<div class="bbs-login">
			<?php echo \BBStandards\PluginManager::hookText("html.menu.login.before", array()); ?>
			<?php echo \BBStandards\PluginManager::hookText("html.menu.login", array()); ?>
			<?php echo \BBStandards\PluginManager::hookText("html.menu.login.after", array()); ?>
		</div>
		<div class="bbs-logo">
			<?php echo \BBStandards\PluginManager::hookText("html.logo.after", array()); ?>
			<a href=""><?php echo BBSTANDARDS_WEBSITE_NAME ?></a>
			<?php echo \BBStandards\PluginManager::hookText("html.logo.before", array()); ?>
		</div>
		<div class="bbs-menu">
			<?php echo \BBStandards\PluginManager::hookText("html.menu.before", array()); ?>
			<?php echo \BBStandards\TemplateManager::parseTemplate("menu") ?>
			<?php echo \BBStandards\PluginManager::hookText("html.menu.after", array()); ?>
		</div>
	</div>
</div>
<div class="bbs-header-push">

</div>
<?php echo \BBStandards\PluginManager::hookText("html.header.after", array()); ?>