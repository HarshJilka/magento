<?php

$installer = $this;

$installer->startSetup();

$installer->run("

    -- DROP TABLE IF EXISTS {$this->getTable('category')};

    CREATE TABLE {$this->getTable('category')} ( 
        `categoryId` int(11) unsigned NOT NULL auto_increment, 
        `name` varchar(128) default '', 
        `status` tinyint(2) default '2', 
        `path` varchar(64) default '', 
        `parentid` int(11), 
        `created_date` datetime, 
        `updated_date` datetime, 
        PRIMARY KEY (`categoryId`) 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();
