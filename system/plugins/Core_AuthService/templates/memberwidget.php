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

<div class="bbsp-core-AuthService-memberwidget">
	<div class="bbsp-core-AuthService-memberwidget-inner">
		<div class="bbsp-core-AuthService-memberwidget-avatar">
			<img src="<?php echo \BBStandards\get_gravatar($params["session"]->user_email, 64) ?>" />
		</div>
		<div class="bbsp-core-AuthService-memberwidget-main">
			<div class="bbsp-core-AuthService-memberwidget-user">
				<a href="profile"><?php echo $params["session"]->user_name ?></a>
			</div>
			<div class="bbsp-core-AuthService-memberwidget-options">
				<div class="bbsp-core-AuthService-memberwidget-button">
					<a href="settings">Settings</a>
				</div>
				<div class="bbsp-core-AuthService-memberwidget-button">
					<a href="profile">Profile</a>
				</div>
				<div class="bbsp-core-AuthService-memberwidget-button">
					<a href="admin">Admin</a>
				</div>
			</div>
		</div>
	</div>
</div>
