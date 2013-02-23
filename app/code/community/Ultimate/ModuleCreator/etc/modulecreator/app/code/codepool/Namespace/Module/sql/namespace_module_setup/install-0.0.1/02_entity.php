$this->run("
	CREATE TABLE IF NOT EXISTS `{$this->getTable('{{module}}/{{entity}}')}` (
		`entity_id` int(10) unsigned NOT NULL auto_increment,
{{attributeSql}}
		`created_at` datetime NULL,
		`updated_at` datetime NULL,
	PRIMARY KEY (`entity_id`){{fks}})
	ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
