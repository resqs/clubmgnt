CREATE TABLE `#__nokCM_persons` (
  `id` integer NOT NULL auto_increment,
  `salutation` varchar(25) default NULL,
  `firstname` varchar(50) default NULL,
  `middlename` varchar(50) default NULL,
  `name` varchar(50) NOT NULL default '',
  `birthname` varchar(50) default NULL,
  `nickname` varchar(50) default NULL,
  `address` varchar(100) default NULL,
  `city` varchar(50) NOT NULL default '',
  `zip` varchar(10) default NULL,
  `state` varchar(100) default NULL,
  `country` varchar(100) NOT NULL default '',
  `telephone` varchar(25) default NULL,
  `mobile` varchar(25) default NULL,
  `url` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `user_id` integer default NULL,
  `description` text default NULL,
  `image` varchar(255) default NULL,
  `birthday` date default NULL,
  `deceased` date default NULL,
  `custom1` varchar(255) default NULL,
  `custom2` varchar(255) default NULL,
  `custom3` varchar(255) default NULL,
  `custom4` varchar(255) default NULL,
  `custom5` varchar(255) default NULL,
  `hh_person_id` integer default NULL,
  `hh_salutation_override` varchar(50) default NULL,
  `hh_name_override` varchar(255) NULL default NULL,
  `createdby` varchar(50) NULL default NULL,
  `createddate` datetime NULL default NULL,
  `modifiedby` varchar(50) NOT NULL default '',
  `modifieddate` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_hh_person_id` (`hh_person_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_remote` (`name`,`firstname`,`address`,`city`,`birthday`)
)  DEFAULT CHARSET=utf8;

CREATE TABLE `#__nokCM_memberships` (
  `id` integer NOT NULL auto_increment,
  `person_id` integer NOT NULL,
  `type` varchar(25) NOT NULL,
  `begin` date NOT NULL,
  `end` date NULL default NULL,
  `published` int(1) NOT NULL default 0,
  `catid` int(11) NOT NULL DEFAULT '0',
  `createdby` varchar(50) NULL default NULL,
  `createddate` datetime NULL default NULL,
  `modifiedby` varchar(50) NOT NULL default '',
  `modifieddate` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_person_id` (`person_id`),
  KEY `idx_remote` (`person_id`,`type`,`begin`)
)  DEFAULT CHARSET=utf8;

CREATE TABLE `#__nokCM_board` (
  `id` integer NOT NULL auto_increment,
  `person_id` integer NOT NULL,
  `job` varchar(25) NOT NULL,
  `begin` date NOT NULL,
  `end` date NULL default NULL,
  `published` int(1) NOT NULL default 0,
  `sortorder` varchar(50) NULL default NULL,
  `catid` int(11) NOT NULL DEFAULT '0',
  `createdby` varchar(50) NULL default NULL,
  `createddate` datetime NULL default NULL,
  `modifiedby` varchar(50) NOT NULL default '',
  `modifieddate` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_person_id` (`person_id`),
  KEY `idx_remote` (`person_id`,`job`,`begin`)
)  DEFAULT CHARSET=utf8;

