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

<?php echo \BBStandards\PluginManager::hookText("html.includes.before", array()); ?>

<base href="<?php echo BBSTANDARDS_WEBSITE_LINK ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo \BBStandards\TemplateManager::resource("styles/style.css") ?>" />

<?php echo \BBStandards\PluginManager::hookText("html.includes.after", array()); ?>
