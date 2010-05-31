<?php defined('SYSPATH') or die('No direct script access.');

class AddColumn extends Doctrine_Migration_Base
{
	public function up()
	{
		$this->addColumn('projects', 'user_id', 'integer', 8, array('unsigned' => TRUE));

		$definition = array
		(
			'local'         => 'user_id',
			'foreign'       => 'id',
			'foreignTable'  => 'users',
			'onDelete'      => 'cascade'
		);
		$this->createForeignKey('projects', 'projects_user_foreign_key', $definition);
	}

	public function down()
	{
		$this->dropForeignKey('projects', 'projects_user_foreign_key');
		$this->removeColumn('projects', 'user_id');
	}
}
