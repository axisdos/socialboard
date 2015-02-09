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
<div class="bbs-header">
	<div class="bbs-header-inner bbs-standard-container">
		<div class="bbs-logo">
			<?php echo BBSTANDARDS_WEBSITE_NAME ?>
		</div>
		<div class="bbs-login">
			<?php echo \BBStandards\TemplateManager::parseTemplate("menulogin") ?>
		</div>
		<div class="bbs-menu">
			<?php echo \BBStandards\TemplateManager::parseTemplate("menu") ?>
		</div>
	</div>
</div>
<div class="bbs-header-push">

</div>