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

<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.before", array()); ?>
<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.member.before", array()); ?>

	<div class="bbsp-core-AuthService-loginwidget bbsp-core-AuthService-loginwidget-member">

		<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.firstbutton", array()); ?>
		<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.member.firstbutton", array()); ?>

		<div class="bbs-menu-item">
			<?php echo $params["session"]->user_name ?>
		</div>

		<div class="bbs-menu-item">
			<a href="logout">Sign Out</a>
		</div>

		<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.member.lastbutton", array()); ?>
		<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.lastbutton", array()); ?>

	</div>

<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.member.after", array()); ?>
<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.after", array()); ?>