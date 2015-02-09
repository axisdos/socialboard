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
		<title><?php echo BBSTANDARDS_WEBSITE_NAME ?></title>

		<?php echo \BBStandards\TemplateManager::parseTemplate("htmlincludes") ?>
	</head>
	<body>
		<?php echo \BBStandards\TemplateManager::parseTemplate("header") ?>
		<?php echo \BBStandards\TemplateManager::parseTemplate("wrap", $params) ?>
		<?php echo \BBStandards\TemplateManager::parseTemplate("footer") ?>
	</body>
</html>