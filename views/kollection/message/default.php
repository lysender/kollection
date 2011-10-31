<?php if (isset($messages) && ! empty($messages)): ?>
	<div class="alert-message block-message fade in <?php echo $type ?>">
		<a class="close" href="javascript:void(0)">x</a>
		<p><?php echo $messages ?></p>
	</div>
<?php endif ?>