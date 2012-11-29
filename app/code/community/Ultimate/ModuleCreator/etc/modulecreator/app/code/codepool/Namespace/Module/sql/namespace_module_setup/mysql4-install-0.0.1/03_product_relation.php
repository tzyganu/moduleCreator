
$this->run("
	CREATE TABLE {$this->getTable('{{module}}/{{entity}}_product')} (
		`rel_id` int(11) unsigned NOT NULL auto_increment,
		`{{entity}}_id` int(11) unsigned NOT NULL,
		`product_id` int(11) unsigned NOT NULL,
		`position` int(11) unsigned NOT NULL default '0',
	PRIMARY KEY  (`rel_id`),
	UNIQUE KEY `UNIQUE_{{ENTITY}}_PRODUCT` (`{{entity}}_id`,`product_id`),
	CONSTRAINT `{{MODULE}}_{{ENTITY}}_{{ENTITY}}_PRODUCT` FOREIGN KEY (`{{entity}}_id`) REFERENCES {$this->getTable('{{module}}/{{entity}}')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT `{{MODULE}}_{{ENTITY}}_PRODUCT_{{ENTITY}}` FOREIGN KEY (`product_id`) REFERENCES {$this->getTable('catalog_product_entity')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
	)
	ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
