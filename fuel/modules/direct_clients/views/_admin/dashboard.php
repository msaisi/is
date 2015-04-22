	<div id="dashboard_siteconfig" class="dashboard_module">
		<h3>Recent site-config Items</h3>
		<ul class="nobullets">
		<?php foreach($posts as $post) : ?>
		<li><a href="<?=$post->url?>" target="_blank"><?=$post->title?></a></li>
		<?php endforeach; ?>
		</ul>
	</div>