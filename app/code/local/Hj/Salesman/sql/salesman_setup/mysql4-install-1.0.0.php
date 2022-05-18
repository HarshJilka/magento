<?php

$installer = $this;

$installer->startSetup();

/*$installer->run("

    -- DROP TABLE IF EXISTS {$this->getTable('salesman')};
    CREATE TABLE {$this->getTable('salesman')} (
    `salesmanId` int(11) unsigned NOT NULL auto_increment,
    `name` varchar(255) NOT NULL default '',
    `email` varchar(255) NOT NULL default '',
    PRIMARY KEY (`salesmanId`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");*/

$installer->endSetup();
