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

<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.registerpage.before", array()); ?>

<div class="bbsp-core-AuthService-register">

	<?php if ($params["error"] != "") { ?>
	<div class="bbsp-core-AuthService-register-error bbs-standard-container bbs-standard-error-alert">
		<?php echo $params["error"] ?>
	</div>
	<?php } ?>

	<div class="bbsp-core-AuthService-register-inner bbs-standard-container">
		<div class="bbsp-core-AuthService-register-header bbs-standard-header">
			Create an Account
		</div>
		<div class="bbsp-core-AuthService-body">
			<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.registerpage.form.before", array()); ?>
			<form class="bbs-form" action="" method="post">
				<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.registerpage.form.firstfield", array()); ?>
				<div class="bbs-form-field">
					<label class="bbs-form-label">Username:</label>
					<input type="text" name="username" class="bbs-form-field-text bbs-form-field-text-username" />
				</div>
				<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.registerpage.form.afteruser", array()); ?>
				<div class="bbs-form-field">
					<label class="bbs-form-label">Email:</label>
					<input type="text" name="email" class="bbs-form-field-text bbs-form-field-text-email" />
				</div>
				<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.registerpage.form.afteremail", array()); ?>
				<div class="bbs-form-field">
					<label class="bbs-form-label">Password:</label>
					<input type="password" name="password" class="bbs-form-field-text bbs-form-field-text-password" />
				</div>
				<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.registerpage.form.afterpassword", array()); ?>
				<div class="bbs-form-field">
					<label class="bbs-form-label">Password Again:</label>
					<input type="password" name="confirm" class="bbs-form-field-text bbs-form-field-text-password bbs-form-field-text-password-confirm" />
				</div>
				<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.registerpage.form.lastfield", array()); ?>
				<div class="bbs-form-field bbs-form-field-submit">
					<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.registerpage.form.leftOfSubmit", array()); ?>
					<input type="submit" value="Create Account" class="bbs-form-submit-button" />
					<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.registerpage.form.rightOfSubmit", array()); ?>
				</div>
				<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.registerpage.form.aftersubmit", array()); ?>
			</form>
			<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.registerpage.form.after", array()); ?>
		</div>
	</div>
</div>

<?php echo \BBStandards\PluginManager::hookText("plugins.authservice.registerpage.after", array()); ?>
