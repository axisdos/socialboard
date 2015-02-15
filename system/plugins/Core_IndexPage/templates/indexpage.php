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

<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.before"); ?>

<div class="bbsp-core-IndexPage">
	<div class="bbsp-core-IndexPage-inner bbs-standard-container">
		<div class="bbsp-core-IndexPage-inner-table">
			<div class="bbsp-core-IndexPage-inner-categorylist">
				<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.categories"); ?>
			</div>
			<div class="bbsp-core-IndexPage-inner-userfeed">
				<?php echo \BBStandards\PluginManager::hookText("plugins.alerts.sidebar.show", array()); ?>
			</div>
		</div>
	</div>
</div>

<?php echo \BBStandards\PluginManager::hookText("plugins.indexpage.after"); ?>
