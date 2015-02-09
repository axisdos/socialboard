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
<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.guest.before", array()); ?>

<div class="bbsp-core-AuthService-loginwidget bbsp-core-AuthService-loginwidget-guest">

	<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.firstbutton", array()); ?>
	<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.guest.firstbutton", array()); ?>

	<div class="bbsp-core-AuthService-loginwidget-guest-login">
		<a href="login">Sign in</a>
	</div>

	<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.middle1", array()); ?>
	<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.guest.middle1", array()); ?>

	<div class="bbsp-core-AuthService-loginwidget-guest-spacer">
		or
	</div>

	<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.middle2", array()); ?>
	<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.guest.middle2", array()); ?>

	<div class="bbsp-core-AuthService-loginwidget-guest-register">
		<a href="register">Register</a>
	</div>

	<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.guest.lastbutton", array()); ?>
	<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.lastbutton", array()); ?>

</div>

<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.guest.after", array()); ?>
<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginwidget.after", array()); ?>