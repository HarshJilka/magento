<?php

    $installer = $this;

    $installer->startSetup();

    $installer->run("

    -- DROP TABLE IF EXISTS {$this->getTable('process')};
    CREATE TABLE {$this->getTable('process')} (
      `process_id` int(11) unsigned NOT NULL auto_increment,
      `group_id` int(11) NOT NULL,
      `type_id` int(11) NOT NULL,
      `name` varchar(255) NOT NULL default '',
      `request_model` varchar(255) NOT NULL default '',
      `file_name` varchar(255) NOT NULL default '',
      `per_request_count` int(11) NOT NULL default '0',
      `request_interval` int(11) NOT NULL default '0',
      PRIMARY KEY (`process_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        ");

    $installer->endSetup();