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
<!DOCTYPE html>
<html>
	<head>
		<title>Administrator Control Panel</title>
		<base href="<?php echo BBSTANDARDS_WEBSITE_LINK ?>" />
		<?php echo \BBStandards\PluginManager::hookText("html.admin.includes", array()); ?>

		<link rel="stylesheet" type="text/css" href="system/plugins/Core_AdminService/public/styles/style.css" />
	</head>
	<body>
		<?php echo \BBStandards\PluginManager::hookText("html.admin.start", array()); ?>
		<div class="admin-header">
			<div class="admin-menu">
				<?php echo \BBStandards\PluginManager::hookText("html.admin.menu.first.priority", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.admin.menu.first", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.admin.menu", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.admin.menu.last", array()); ?>
				<?php echo \BBStandards\PluginManager::hookText("html.admin.menu.last.priority", array()); ?>
			</div>
			<div class="admin-logo">
				Administrator Control Panel
			</div>
		</div>
		<div class="admin-body">
			<?php echo $params["content"] ?>
		</div>
		<div class="admin-footer">

		</div>
		<?php echo \BBStandards\PluginManager::hookText("html.admin.stop", array()); ?>
	</body>
</html>