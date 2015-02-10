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

<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginpage.before", array()); ?>

<div class="bbsp-core-AuthService-login">

	<?php if ($params["error"] != "") { ?>
		<div class="bbsp-core-AuthService-login-error bbs-standard-container bbs-standard-error-alert">
			<?php echo $params["error"] ?>
		</div>
	<?php } ?>

	<div class="bbsp-core-AuthService-login-inner bbs-standard-container">
		<div class="bbsp-core-AuthService-login-header bbs-standard-header">
			Sign-In to Your Account
		</div>
		<div class="bbsp-core-AuthService-body">
			<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginpage.form.before", array()); ?>
			<form class="bbs-form" action="" method="post">
				<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginpage.form.firstfield", array()); ?>
				<div class="bbs-form-field">
					<label class="bbs-form-label">Email:</label>
					<input type="text" name="email" class="bbs-form-field-text bbs-form-field-text-email" />
				</div>
				<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginpage.form.afteremail", array()); ?>
				<div class="bbs-form-field">
					<label class="bbs-form-label">Password:</label>
					<input type="password" name="password" class="bbs-form-field-text bbs-form-field-text-password" />
				</div>
				<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginpage.form.lastfield", array()); ?>
				<div class="bbs-form-field bbs-form-field-submit">
					<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginpage.form.leftOfSubmit", array()); ?>
					<input type="submit" value="Sign In" class="bbs-form-submit-button" />
					<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginpage.form.rightOfSubmit", array()); ?>
				</div>
				<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginpage.form.aftersubmit", array()); ?>
			</form>
			<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginpage.form.after", array()); ?>
		</div>
	</div>
</div>

<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.loginpage.after", array()); ?>
