<?php defined('SYSPATH') or die('No direct script access.');

class RenameColumn extends Doctrine_Migration_Base
{
	public function up()
	{
		$this->renameColumn('users', 'last_update', 'last_login');
		$this->addColumn('users', 'logins', 'integer', 8, array('unsigned' => TRUE));
	}

	public function down()
	{
		$this->renameColumn('users', 'last_login', 'last_update');
		$this->removeColumn('users', 'logins');
	}
}