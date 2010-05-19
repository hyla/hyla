<div>
<?php print '<pre>' . htmlspecialchars(print_r($_SERVER, true)) . '</pre>';?>
<?php echo Kohana::debug(Session::instance()); ?>
</div>