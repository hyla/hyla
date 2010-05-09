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
            
            $this->createTable('user_tokens', array
			(
				'id' => $int + $notnull + $unsigned + $ai + $pk,
				'user_id' => $int + $notnull + $unsigned,
				'user_agent' => $varchar + $notnull,
				'token' => $varchar + $notnull,
				'created' => $int + $notnull + $unsigned,
				'expires' => $int + $notnull + $unsigned,
			));
            
			$this->createTable('roles', array
			(
				'id' => $int + $notnull + $unsigned + $ai + $pk,
				'name' => $varchar + $notnull,
				'description' => $varchar
			));

			$this->createTable('roles_users', array
			(
				'user_id' => $int + $notnull + $unsigned,
				'role_id' => $int + $notnull + $unsigned
			));
			
			$definition = array
			(
				'fields' => array
				(				
					'token' => array()
				),
				'unique' => true
			);

			$this->createConstraint('user_tokens', 'user_tokens_uniq_token', $definition);
			
			$definition = array
			(
				'local'         => 'user_id',
				'foreign'       => 'id',
				'foreignTable'  => 'users',
				'onDelete'     =>  'cascade'
			);

			$this->createForeignKey('user_tokens', 'user_tokens_user_foreign_key', $definition);
			
			$definition = array
			(
				'local'         => 'user_id',
				'foreign'       => 'id',
				'foreignTable'  => 'users',
				'onDelete'     =>  'cascade'
			);

			$this->createForeignKey('roles_users', 'roles_users_user_foreign_key', $definition);
		
			$definition = array
			(
				'local'         => 'role_id',
				'foreign'       => 'id',
				'foreignTable'  => 'roles',
				'onDelete'     =>  'cascade'
			);

			$this->createForeignKey('roles_users', 'roles_users_role_foreign_key', $definition);			
				
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
        
        public function postUp()
            {
                $models = APPPATH.'migration_models';
                
                Doctrine_Core::generateModelsFromDb($models);
                Doctrine_Core::loadModels($models.'/generated');
                Doctrine_Core::loadModels($models);
                $roles = new Roles();
                $roles->name = 'login';
                $roles->description = "Role to login";
                $roles->save();
                $roles = new Roles();
                $roles->name = 'admin';
                $roles->description = "Role to administer";
                $roles->save();
                Doctrine_Lib::removeDirectories($models);
                
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
			$this->dropTable('roles_users');
			$this->dropTable('user_tokens');
			$this->dropTable('users');
			$this->dropTable('roles');
		}
		
  }