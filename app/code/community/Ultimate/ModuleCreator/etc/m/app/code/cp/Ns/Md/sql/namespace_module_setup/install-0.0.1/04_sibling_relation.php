$this->run("
	CREATE TABLE {$this->getTable('{{module}}/{{entity}}_{{sibling}}')} (
		`rel_id` int(11) unsigned NOT NULL auto_increment,
		`{{entity}}_id` int(11) unsigned NOT NULL,
		`{{sibling}}_id` int(11) unsigned NOT NULL,
		`position` int(11) unsigned NOT NULL default '0',
	PRIMARY KEY  (`rel_id`),
	UNIQUE KEY `UNIQUE_{{ENTITY}}_{{SIBLING}}` (`{{entity}}_id`,`{{sibling}}_id`),
	CONSTRAINT `{{MODULE}}_{{ENTITY}}_{{ENTITY}}_{{SIBLING}}` FOREIGN KEY (`{{entity}}_id`) REFERENCES {$this->getTable('{{module}}/{{entity}}')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT `{{MODULE}}_{{ENTITY}}_{{SIBLING}}_{{ENTITY}}` FOREIGN KEY (`{{sibling}}_id`) REFERENCES {$this->getTable('{{module}}/{{sibling}}')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
	)
	ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
