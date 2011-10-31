<?php if (isset($messages) && ! empty($messages)): ?>
	<div class="alert-message block-message fade in <?php echo $type ?>">
		<a class="close" href="javascript:void(0)">x</a>
		<p><?php echo $title ?></p>
		<ul>
			<?php foreach ($messages as $msg): ?>
			<li><?php echo HTML::chars($msg) ?></li>
			<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>