$this->run("
	CREATE TABLE IF NOT EXISTS `{$this->getTable('{{module}}/{{entity}}')}` (
		`entity_id` int(10) unsigned NOT NULL auto_increment,
{{attributeSql}}
		`created_at` datetime NULL,
		`updated_at` datetime NULL,
	PRIMARY KEY (`entity_id`){{fks}})
	ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$this->run("
	CREATE TABLE `{$this->getTable('{{module}}/{{entity}}_store')}` (
		`{{entity}}_id` int(10) NOT NULL,
  		`store_id` int(10) unsigned NOT NULL,
  	PRIMARY KEY (`{{entity}}_id`,`store_id`),
	CONSTRAINT `FK_{{MODULE}}_{{ENTITY}}_STORE_{{ENTITY}}` FOREIGN KEY (`{{entity}}_id`) REFERENCES `{$this->getTable('{{module}}/{{entity}}')}` (`entity_id`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `FK_{{MODULE}}_{{ENTITY}}_STORE_STORE` FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}` (`store_id`) ON UPDATE CASCADE ON DELETE CASCADE
	) 
	ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='{{EntitiesLabel}} to Stores';
");
