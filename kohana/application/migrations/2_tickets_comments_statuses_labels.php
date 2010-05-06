<?php defined('SYSPATH') or die('No direct script access.');

class TicketsCommentsStatusesLabels extends Doctrine_Migration_Base
{
	public function up()
	{
		// Types
		$int     = array('type' => 'integer', 'length' => 8);
		$varchar = array('type' => 'varchar', 'length' => 255);
		$text    = array('type' => 'text');

		// Attributes
		$notnull  = array('notnull' => TRUE);
		$unsigned = array('unsigned' => TRUE);
		$pk       = array('primary' => TRUE);
		$ai       = array('autoincrement' => TRUE);
		
		parent::setDefaultTableOptions(array('type' => 'INNODB', 'charset' => 'utf8'));
		
		$this->createTable('tickets', array
		(
			'id'          => $int + $notnull + $unsigned + $ai + $pk,
			'user_id'     => $int + $notnull + $unsigned,
			'project_id'  => $int + $notnull + $unsigned,
			'status_id'   => $int + $notnull + $unsigned,
			'title'       => $varchar,
			'description' => $text,
			'created_on'  => $int + $notnull + $unsigned,
			'last_update' => $int + $notnull + $unsigned,
		));

		$this->createTable('comments', array
		(
			'id' => $int + $notnull + $unsigned + $ai + $pk,
			'ticket_id' => $int + $notnull + $unsigned,
			'user_id' => $int + $notnull + $unsigned,
			'content' => $text,
			'created_on' => $int + $notnull + $unsigned,
			'last_update' => $int + $notnull + $unsigned,
		));

		$this->createTable('statuses', array
		(
			'id' => $int + $notnull + $unsigned + $ai + $pk,
			'name' => $varchar
		));

		$this->createTable('labels', array
		(
			'id' => $int + $notnull + $unsigned + $ai + $pk,
			'name' => $varchar,
			'color' => $varchar
		));

		$this->createTable('tickets_labels', array
		(
			'ticket_id' => $int + $notnull + $unsigned,
			'label_id' => $int + $notnull + $unsigned
		));

    }

    public function down()
    {
      $this->dropTable('tickets');
      $this->dropTable('statuses');
      $this->dropTable('comments');
      $this->dropTable('labels');
      $this->dropTable('tickets_labels');
    }
}
