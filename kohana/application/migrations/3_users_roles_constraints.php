<?php defined('SYSPATH') or die('No direct script access.');

	class UsersRolesConstraints extends Doctrine_Migration_Base
	{

		public function up()
		{
			
			
			// Types
			$int = array('type' => 'integer', 'length' => 8);
			$varchar = array('type' => 'varchar', 'length' => 255);
			$text = array('type' => 'text');

			// Attributes
			$notnull = array('notnull' => TRUE);
			$unsigned = array('unsigned' => TRUE);
			$pk = array('primary' => TRUE);
			$ai = array('autoincrement' => TRUE);
			
			parent::setDefaultTableOptions(array('type' => 'INNODB', 'charset' => 'utf8'));

			$this->createTable('users', array
			(
				'id' => $int + $notnull + $unsigned + $ai + $pk,
				'username' => $varchar + $notnull,
				'email' => $varchar + $notnull,
				'password' => $varchar + $notnull,
				'created_on' => $int + $notnull + $unsigned,
				'last_update' => $int + $notnull + $unsigned,
			));

			$this->createTable('roles', array
			(
				'id' => $int + $notnull + $unsigned + $ai + $pk,
				'name' => $varchar + $notnull
			));

			$this->createTable('users_roles', array
			(
				'user_id' => $int + $notnull + $unsigned,
				'role_id' => $int + $notnull + $unsigned
			));
			
			
			$definition = array
			(
				'fields' => array
				(				
					'user_id' => array(),
					'role_id' => array()
				),
				'unique' => true
			);

			$this->createConstraint('users_roles', 'users_roles_unique_key', $definition);
			
			$definition = array
			(
				'local'         => 'user_id',
				'foreign'       => 'id',
				'foreignTable'  => 'users',
				'onDelete'     =>  'cascade'
			);

			$this->createForeignKey('users_roles', 'users_roles_user_foreign_key', $definition);
		
			$definition = array
			(
				'local'         => 'role_id',
				'foreign'       => 'id',
				'foreignTable'  => 'roles',
				'onDelete'     =>  'cascade'
			);

			$this->createForeignKey('users_roles', 'users_roles_role_foreign_key', $definition);			
			
			$definition = array
			(
				'fields' => array
				(
					'ticket_id' => array(),
					'label_id' => array()
				),
				'unique' => true
			);

			//$this->createConstraint('tickets_labels', 'tickets_labels_unique_key', $definition);
				
			$definition = array
			(
				'local'        => 'project_id',
				'foreign'      => 'id',
				'foreignTable' => 'projects',
				'onDelete'     =>  'cascade'
			);

			$this->createForeignKey('tickets', 'tickets_project_foreign_key', $definition);
		
			$definition = array
			(
				'local'        => 'user_id',
				'foreign'      => 'id',
				'foreignTable' => 'users'
			);

			$this->createForeignKey('tickets', 'tickets_user_foreign_key', $definition);			
		
			$definition = array
			(
				'local'        => 'status_id',
				'foreign'      => 'id',
				'foreignTable' => 'statuses'
			);

			$this->createForeignKey('tickets', 'tickets_status_foreign_key', $definition);
			
			$definition = array
			(
				'local'        => 'ticket_id',
				'foreign'      => 'id',
				'foreignTable' => 'tickets'
			);

			$this->createForeignKey('comments', 'comments_ticket_foreign_key', $definition);
			
			$definition = array
			(
				'local'        => 'user_id',
				'foreign'      => 'id',
				'foreignTable' => 'comments'
			);

			$this->createForeignKey('comments', 'comments_user_foreign_key', $definition);
			
			$definition = array
			(
				'local'        => 'ticket_id',
				'foreign'      => 'id',
				'foreignTable' => 'tickets',
				'onDelete'     =>  'cascade'
			);

			$this->createForeignKey('tickets_labels', 'tickets_labels_ticket_foreign_key', $definition);
			
			$definition = array
			(
				'local'        => 'label_id',
				'foreign'      => 'id',
				'foreignTable' => 'labels',
				'onDelete'     =>  'cascade'
			);

			$this->createForeignKey('tickets_labels', 'tickets_labels_label_foreign_key', $definition);										

		}

		public function down()
		{
			
		//	$this->dropConstraint('tickets_labels', 'tickets_labels_unique_key');
			$this->dropForeignKey('tickets', 'tickets_project_foreign_key');
			$this->dropForeignKey('tickets', 'tickets_user_foreign_key');
			$this->dropForeignKey('tickets', 'tickets_status_foreign_key');
			$this->dropForeignKey('comments', 'comments_ticket_foreign_key');
			$this->dropForeignKey('comments', 'comments_user_foreign_key');
			$this->dropForeignKey('tickets_labels', 'tickets_labels_ticket_foreign_key');
			$this->dropForeignKey('tickets_labels', 'tickets_labels_label_foreign_key');
			$this->dropTable('users_roles');
			$this->dropTable('users');
			$this->dropTable('roles');
		}
		
  }