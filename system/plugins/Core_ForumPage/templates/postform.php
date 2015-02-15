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

<?php echo \BBStandards\PluginManager::hookText("plugins.forumpage.before"); ?>
<?php echo \BBStandards\PluginManager::hookText("plugins.forumpage.postform.before"); ?>

<div class="bbsp-core-ForumPage">
	<div class="bbsp-core-ForumPage-body">
		<?php echo \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_ForumPage", "forumtitle", array("forum" => $params["forum"], "canStart" => $params["canStart"])) ?>
		<div class="bbsp-core-ForumPage-postdiscussion">
			<div class="bbsp-core-ForumPage-postdiscussion-form">
				<form class="bbs-form" action="" method="post">
					<div class="bbs-form-field">
						<label class="bbs-form-label">Discussion Title:</label>
						<input type="text" name="name" class="bbs-form-field-text" />
					</div>
					<div class="bbs-form-field">
						<label class="bbs-form-label">Discussion Text:</label>
						<textarea type="text" name="content" class="bbs-form-field-textarea"></textarea>
					</div>
					<div class="bbs-form-field bbs-form-field-submit">
						<input type="submit" value="Start Discussion" class="bbs-form-submit-button" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php echo \BBStandards\PluginManager::hookText("plugins.postform.after"); ?>
<?php echo \BBStandards\PluginManager::hookText("plugins.forumpage.after"); ?>
