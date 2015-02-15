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

<?php if ($params["canPost"] && \BBStandards\IdentityManager::isLoggedIn()) { ?>
<div class="bbsp-core-TopicPage-quickreply">

	<form class="bbs-form" action="" method="post">
		<textarea type="text" name="content" class="bbs-form-field-textarea-elastic"></textarea>
		<input type="submit" value="Add Reply" class="bbs-form-submit-button" />
	</form>

</div>
<?php } ?>