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
$topic = $params["topic"];
?>

<div class="bbsp-core-FeedService-post">
	<div class="bbsp-core-FeedService-post-table">
		<div class="bbsp-core-FeedService-post-table-user">
			<img src="<?php echo \BBStandards\get_gravatar($post->user_email, 48) ?>" />
		</div>
		<div class="bbsp-core-FeedService-post-table-content">
			<div class="bbsp-core-FeedService-post-table-content-controls">
				<div class="bbsp-core-FeedService-post-table-content-controls-item">
					<a href="profile/<?php echo $post->user_id ?>">profile</a>
				</div>
				<div class="bbsp-core-FeedService-post-table-content-controls-item">
					<a href="">reply</a>
				</div>
			</div>
			<div class="bbsp-core-FeedService-post-table-content-speaker">
				<a href="profile/<?php echo $post->user_id ?>"><?php echo $post->user_name ?> says...</a>
			</div>
			<div class="bbsp-core-FeedService-post-table-content-text">
				<?php echo $post->post_parsed ?>
			</div>
		</div>
	</div>
</div>