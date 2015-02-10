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
	<?php echo \BBStandards\PluginManager::hookText("html.header.before.inner", array()); ?>
	<div class="bbs-header-outer">
		<div class="bbs-header-inner bbs-standard-container">
			<div class="bbs-login">
				<?php echo \BBStandards\PluginManager::hookText("html.menu.login.before", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.menu.login", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.menu.login.after", array()); ?>
			</div>
			<div class="bbs-logo">
				<?php echo \BBStandards\PluginManager::hookText("html.logo.after", array()); ?>
				<a href="">
					<div class="bbs-logo-icon">
						<img src="<?php echo BBSTANDARDS_WEBSITE_ICON ?>" />
					</div>
					<div class="bbs-logo-text">
						<div class="bbs-logo-name">
							<?php echo BBSTANDARDS_WEBSITE_NAME ?>
						</div>
						<div class="bbs-logo-tagline">
							<?php echo BBSTANDARDS_WEBSITE_TAGLINE ?>
						</div>
					</div>
				</a>
				<?php echo \BBStandards\PluginManager::hookText("html.logo.before", array()); ?>
			</div>
		</div>
	</div>
	<div class="bbs-header-menu">
		<div class="bbs-header-menu-inner bbs-standard-container">
			<div class="bbs-menu bbs-menu-right">
				<?php echo \BBStandards\PluginManager::hookText("html.rightmenu.before", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.rightmenu.first", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.rightmenu", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.rightmenu.last", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.rightmenu.after", array()); ?>
			</div>

			<div class="bbs-menu">
				<?php echo \BBStandards\PluginManager::hookText("html.menu.before", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.menu.first", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.menu.second", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.menu.third", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.menu", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.menu.fourth", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.menu.fifth", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.menu.last", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.menu.after", array()); ?>
			</div>
		</div>
	</div>
	<?php echo \BBStandards\PluginManager::hookText("html.header.after.inner", array()); ?>
</div>
<div class="bbs-header-push">

</div>
<?php echo \BBStandards\PluginManager::hookText("html.header.after", array()); ?>