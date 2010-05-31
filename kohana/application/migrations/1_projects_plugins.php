<?php defined('SYSPATH') or die('No direct script access.');

class Projects_Plugins extends Doctrine_Migration_Base
{
	public function up()
	{
		// Types
		$int      = array('type' => 'integer', 'length' => 8);
		$varchar  = array('type' => 'varchar', 'length' => 255);
		$string32 = array('type' => 'string' , 'length' => 32);
		$string64 = array('type' => 'string' , 'length' => 64);
		$text     = array('type' => 'text');
		$bool     = array('type' => 'integer', 'length' => 1, 'default' => 0);

		// Attributes
		$notnull  = array('notnull'       => TRUE);
		$unsigned = array('unsigned'      => TRUE);
		$pk       = array('primary'       => TRUE);
		$ai       = array('autoincrement' => TRUE);

		// Table Attributes
		$innodb = array('type'     => 'INNODB');
		$utf8   = array('charset'  => 'utf8');

		$this->createTable('projects', array
		(
			'id'          => $int + $notnull + $unsigned + $ai + $pk,
			'name'        => $string32,
			'title'       => $string64,
			'description' => $text
		), $innodb + $utf8);

		$this->createTable('plugins', array(
			'id'      => $int + $notnull + $unsigned + $ai + $pk,
			'name'    => $string32,
			'title'   => $string64,
			'enabled' => $bool + $notnull + $unsigned,
		), $innodb + $utf8);
	}

	public function down()
	{
		$this->dropTable('projects');
		$this->dropTable('plugins');
	}
}
