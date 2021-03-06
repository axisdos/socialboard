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
<div class="bbs-wrap">
	<?php echo \BBStandards\PluginManager::hookText("html.wrap.before", array()); ?>
	<?php echo \BBStandards\TemplateManager::parseTemplate("guestbox") ?>
	<?php echo $params["content"] ?>
	<?php echo \BBStandards\PluginManager::hookText("html.wrap.after", array()); ?>
</div>