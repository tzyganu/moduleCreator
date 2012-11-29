ULTIMATE MODULE CREATOR

Before installing the exetension disable the cache and the compiler.
To install the module copy the 'app' folder over the app folder of your magento instance and the 'skin' folder over the skin folder of your Mangento instance.

If you are logged in the admin then logout and login again to have access to the configuration settings of the module.

If you want to uninstall the extension delete the following:

app/code/local/Ultimate/ModuleCreator/ - folder
app/design/adminhtml/default/default/layout/ultimate_modulecreator.xml - file
app/design/adminhtml/default/default/template/ultimate_modulecreator/ - folder
app/etc/modules/Ultimate_ModuleCreator.xml - file
app/locale/en_US/Ultimate_ModuleCreator.csv - file
skin/adminhtml/default/default/ultimate_modulecreator.css - file
LICENSE_UMC.txt - file
readme_UMC.txt - file (the one you are reading)

Also run the following query on the database (add table prefix if you have one) to remove any config settings for the module:
"DELETE FROM `core_config_data` where `path` LIKE 'modulecreator/%'";

For questions, thanks or criticism send an e-mail to <marius.strajeru@gmail.com>

To report bugs or/and add feature requests refer to https://github.com/tzyganu/moduleCreator
 