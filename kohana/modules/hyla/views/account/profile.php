<div>
<?php print '<pre>' . htmlspecialchars(print_r($_SERVER, true)) . '</pre>';?>
<?php print_r(get_defined_vars()); ?>
<hr />
<?php echo Kohana::debug(Auth::instance()); ?>
<hr />
<?php echo Kohana::debug(Session::instance()); ?>
</div>