<?php
/**
 * @version 1.0
 * @copyright Copyright (C) 2014 rayzzz.com. All rights reserved.
 * @license GNU/GPL2, see LICENSE.txt
 * @website http://rayzzz.com
 * @twitter @rayzzzcom
 * @email rayzexpert@gmail.com
 */
if(!class_exists('RzInit'))
{
	class RzInit {
		var $aRzInfo = array();
		var $aDBTables = array();
		var $aDBInserts = array();
		
		static function getInstance($sModule)
		{
			$sClassName = "Rz" . ucfirst(substr($sModule, 2));
			return new $sClassName();
		}
	}
}

class RzChat extends RzInit {
	function RzChat()
	{
		$this->aRzInfo = array(
			'module' => "rzchat",
			'title' => "Video Chat",
			'desc' => "Video Chat without media server",
			'version' => "1.0.0",
			'author' => "rayzzz.com",
			'email' => "rayzexpert@gmail.com",
			'url' => "http://rayzzz.com/store/chat",
			'min_width' => "800",
			'width' => "100%",
			'height' => "600"
		);
		$this->aDBTables = array(
			'rzchat_profiles' => array(
				'fields' => array(
				  'ID' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'length' => 20
				  ),
				  'Banned' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 4
				  ),
				  'Type' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => 'full',
					'length' => 10
				  ),
				  'Smileset' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 32
				  )
				),
				'primary key' => array('ID')
			),
			
			'rzchat_rooms' => array(
				'fields' => array(
				  'ID' => array(
					'type' => 'int',
					'not null' => TRUE,
					'auto_increment' => TRUE,
					'length' => 11
				  ),
				  'Name' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 255
				  ),
				  'Password' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 255
				  ),
				  'Desc' => array(
					'type' => 'text',
					'not null' => TRUE
				  ),
				  'OwnerID' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 20
				  ),
				  'When' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  ),
				  'Status' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => 'normal',
					'length' => 6
				  )
				),
				'primary key' => array('ID')
			),
			
			'rzchat_rooms_users' => array(
				'fields' => array(
				  'ID' => array(
					'type' => 'int',
					'not null' => TRUE,
					'auto_increment' => TRUE,
					'length' => 11
				  ),
				  'Room' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  ),
				  'User' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 20
				  ),
				  'When' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  ),
				  'Status' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => 'normal',
					'length' => 6
				  )
				),
				'primary key' => array('ID')
			),

			'rzchat_current_users' => array(
				'fields' => array(
				  'ID' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'length' => 20
				  ),
				  'Nick' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 36
				  ),
				  'Sex' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => 'M',
					'length' => 1
				  ),
				  'Age' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  ),
				  'Desc' => array(
					'type' => 'text',
					'not null' => TRUE
				  ),
				  'Photo' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 255
				  ),
				  'Profile' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 255
				  ),
				  'Online' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => 'online',
					'length' => 10
				  ),
				  'Start' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  ),
				  'When' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  ),
				  'Status' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => 'new',
					'length' => 6
				  )
				),
				'primary key' => array('ID')
			),
			
			'rzchat_messages' => array(
				'fields' => array(
				  'ID' => array(
					'type' => 'int',
					'not null' => TRUE,
					'auto_increment' => TRUE,
					'length' => 20
				  ),
				  'Room' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  ),
				  'Count' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  ),
				  'Sender' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 20
				  ),
				  'Recipient' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 20
				  ),
				  'Whisper' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => 'false',
					'length' => 5
				  ),
				  'Message' => array(
					'type' => 'text',
					'not null' => TRUE
				  ),
				  'Style' => array(
					'type' => 'text',
					'not null' => TRUE
				  ),
				  'Type' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => 'text',
					'length' => 10
				  ),
				  'When' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  )
				),
				'primary key' => array('ID')
			),
			
			'rzchat_history' => array(
				'fields' => array(
				  'ID' => array(
					'type' => 'int',
					'not null' => TRUE,
					'auto_increment' => TRUE,
					'length' => 20
				  ),
				  'Room' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  ),
				  'SndRcp' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 40
				  ),
				  'Sender' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 20
				  ),
				  'Recipient' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 20
				  ),
				  'Message' => array(
					'type' => 'text',
					'not null' => TRUE
				  ),
				  'When' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  )
				),
				'primary key' => array('ID')
			),			

			'rzchat_memberships_settings' => array(
				'fields' => array(
				  'ID' => array(
					'type' => 'int',
					'not null' => TRUE,
					'auto_increment' => TRUE,
					'length' => 11
				  ),
				  'Name' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 20
				  ),
				  'Caption' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 255
				  ),
				  'Type' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => 'boolean',
					'length' => 10
				  ),
				  'Default' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 255
				  ),
				  'Range' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 3,
					'length' => 3
				  ),
				  'Error' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 255
				  )
				),
				'primary key' => array('ID')
			),

			'rzchat_memberships' => array(
				'fields' => array(
				  'ID' => array(
					'type' => 'int',
					'not null' => TRUE,
					'auto_increment' => TRUE,
					'length' => 11
				  ),
				  'Setting' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  ),
				  'Value' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 255
				  ),
				  'Membership' => array(
					'type' => 'int',
					'not null' => TRUE,
					'default' => 0,
					'length' => 11
				  )
				),
				'primary key' => array('ID')
			),
		  
			'rzchat_blocked_users' => array(
				'fields' => array(
				  'ID' => array(
					'type' => 'int',
					'not null' => TRUE,
					'auto_increment' => TRUE,
					'length' => 11
				  ),
				  'User' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => 0,
					'length' => 20
				  ),
				  'Blocked' => array(
					'type' => 'varchar',
					'not null' => TRUE,
					'default' => '',
					'length' => 20
				  )
				),
				'primary key' => array('ID')
			)
		);
		$this->aDBInserts = array(
			0 => array(
				'table' => "rzchat_rooms",
				'columns' => array("Name", "Desc", "When", "Status"),
				'values' => array("Lobby", "Welcome to our chat! You are in the Lobby now, but you can pass into any other public room you wish: take a look at the [All rooms] box. If you have any problems with using this chat, there is a Help button on the right of the bottom toolbar.", "0", "normal")
			),
			1 => array(
				'table' => "rzchat_rooms",
				'columns' => array("Name", "Desc", "When", "Status"),
				'values' => array("Friends", "Welcome to the Friends room! This is a public room where you can have a fun chat with existing friends or make new ones! Enjoy!", "1", "normal")
			),
			2 => array(
				'table' => "rzchat_memberships_settings",
				'columns' => array("Name", "Caption", "Type", "Default", "Range", "Error"),
				'values' => array("RoomCreate", "New Rooms Creating:", "boolean", "true", "1", "RayzRoomCreate")
			),
			3 => array(
				'table' => "rzchat_memberships_settings",
				'columns' => array("Name", "Caption", "Type", "Default", "Range", "Error"),
				'values' => array("PrivateRoomCreate", "Private Rooms Creating:", "boolean", "true", "1", "RayzPrivateRoomCreate")
			),
			4 => array(
				'table' => "rzchat_memberships_settings",
				'columns' => array("Name", "Caption", "Type", "Default", "Range", "Error"),
				'values' => array("AVCasting", "Audio/Video Casting:", "boolean", "true", "1", "RayzAVCasting")
			),
			5 => array(
				'table' => "rzchat_memberships_settings",
				'columns' => array("Name", "Caption", "Type", "Default", "Range", "Error"),
				'values' => array("AVLargeWindow", "Enable Large Video Window:", "boolean", "true", "1", "RayzAVLargeWindow")
			),
			6 => array(
				'table' => "rzchat_memberships_settings",
				'columns' => array("Name", "Caption", "Type", "Default", "Range", "Error"),
				'values' => array("FileSend", "Files Sending:", "boolean", "true", "1", "RayzFileSend")
			),
			7 => array(
				'table' => "rzchat_memberships_settings",
				'columns' => array("Name", "Caption", "Type", "Default", "Range", "Error"),
				'values' => array("WhisperMessages", "Whispering Messages:", "boolean", "true", "1", "RayzWhisperMessages")
			),
			8 => array(
				'table' => "rzchat_memberships_settings",
				'columns' => array("Name", "Caption", "Type", "Default", "Range", "Error"),
				'values' => array("DirectMessages", "Addressed Messages:", "boolean", "true", "1", "RayzDirectMessages")
			),
			9 => array(
				'table' => "rzchat_memberships_settings",
				'columns' => array("Name", "Caption", "Type", "Default", "Range", "Error"),
				'values' => array("RoomsNumber", "Maximum Rooms Number:", "number", "100", "3", "RayzRoomsNumber")
			),
			10 => array(
				'table' => "rzchat_memberships_settings",
				'columns' => array("Name", "Caption", "Type", "Default", "Range", "Error"),
				'values' => array("ChatsNumber", "Maximum Private Chats Number:", "number", "100", "3", "RayzChatsNumber")
			),
			11 => array(
				'table' => "rzchat_memberships_settings",
				'columns' => array("Name", "Caption", "Type", "Default", "Range", "Error"),
				'values' => array("AVWindowsNumber", "Maximum Video Windows Number:", "number", "100", "3", "RayzAVWindowsNumber")
			),
			12 => array(
				'table' => "rzchat_memberships_settings",
				'columns' => array("Name", "Caption", "Type", "Default", "Range", "Error"),
				'values' => array("RestrictedRooms", "Restricted Rooms:", "custom", "", "1", "RayzRestrictedRooms")
			)
		);
	}
}