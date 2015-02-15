<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

$topic = $params["item"][0];
$posts = $params["item"][1];


if (count($posts) > 0) { $post = $posts[0]; array_shift($posts);
?>

<div class="bbsp-core-FeedService-topic">
	<div class="bbsp-core-FeedService-topic-firstpost">
		<div class="bbsp-core-FeedService-topic-table">
			<div class="bbsp-core-FeedService-topic-table-user">
				<img src="<?php echo \BBStandards\get_gravatar($post->user_email, 96) ?>" />
			</div>
			<div class="bbsp-core-FeedService-topic-table-content">
				<div class="bbsp-core-FeedService-topic-table-content-controls">
					<div class="bbsp-core-FeedService-topic-table-content-controls-item">
						<a href="profile/<?php echo $post->user_id ?>"><?php echo $post->user_name ?></a>
					</div>
					<div class="bbsp-core-FeedService-topic-table-content-controls-item">
						<a href="">reply</a>
					</div>
				</div>
				<div class="bbsp-core-FeedService-topic-table-content-speaker">
					<a href="profile/<?php echo $post->user_id ?>"><?php echo $topic->discussion_name ?></a>
				</div>
				<div class="bbsp-core-FeedService-topic-table-content-text">
					<?php echo $post->post_parsed ?>
				</div>
			</div>
		</div>
	</div>
	<div class="bbsp-core-FeedService-topic-replies">
		<?php foreach ($posts as $reply) { ?>
		<?php echo \BBStandards\TemplateManager::parseSystemPluginTemplate("Core_FeedService", "post", array("post" => $reply, "topic" => $topic)); ?>
		<?php } ?>
	</div>
</div>

<?php } ?>