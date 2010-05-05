<?php defined('SYSPATH') or die('No direct script access.');

class Projects_Plugins extends Doctrine_Migration_Base
{
    public function up()
    {

        $this->createTable('projects', array(
											'id' => array(
															'type' 		    => 'integer',
											 				'length' 		=> 11,
															'notnull' 		=> true, 
											                'unsigned' 		=> true,
															'primary' 		=> true,
															'autoincrement' => true
											            ), 
											'name' => array(
															'type' 		=> 'string', 
															'length' 	=> 32
															),
											'title' => array(
															'type' 		=> 'string', 
															'length' 	=> 64
															),
											'description' => array(
															'type' => 'text'
															)
											),
										array(
											'type'     => 'INNODB',
											'charset'  => 'utf8'
												)
										);
										

		$this->createTable('plugins', array(
											'id' => array(
														'type' 			=> 'integer',
														'length' 		=> 11,
														'notnull' 		=> true, 
														'unsigned' 		=> true,
														'primary' 		=> true,
														'autoincrement' => true
														),
											'name' => array(
														'type' 		=> 'string', 
														'length' 	=> 32
														),
											'title' => array(
														'type'		=> 'string', 
														'length' 	=> 64
														),
											'enabled' => array(
																'type' 		=> 'integer', 
																'length' 	=> 1,
																'notnull' 	=> true, 
		                										'unsigned' 	=> true,
																'default' 	=> 0
																),
											),
										array(
												'type'     => 'INNODB',
												'charset'  => 'utf8'
										)
							);											
											
    }

    public function down()
    {
        $this->dropTable('projects');
		$this->dropTable('plugins');
    }
}