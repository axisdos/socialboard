<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

$post = $params["post"];
?>

<div class="bbsp-core-TopicPage-post">
	<div class="bbsp-core-TopicPage-post-table">
		<div class="bbsp-core-TopicPage-post-table-user">
			<img src="<?php echo \BBStandards\get_gravatar($post->user_email, 96) ?>" />
		</div>
		<div class="bbsp-core-TopicPage-post-table-content">
			<div class="bbsp-core-TopicPage-post-table-content-controls">
				<div class="bbsp-core-TopicPage-post-table-content-controls-item">
					<a href="profile/<?php echo $post->user_id ?>">profile</a>
				</div>
				<div class="bbsp-core-TopicPage-post-table-content-controls-item">
					<a href="">reply</a>
				</div>
			</div>
			<div class="bbsp-core-TopicPage-post-table-content-speaker">
				<a href="profile/<?php echo $post->user_id ?>"><?php echo $post->user_name ?></a> says...
			</div>
			<div class="bbsp-core-TopicPage-post-table-content-text">
				<?php echo $post->post_parsed ?>
			</div>
		</div>
	</div>
</div>