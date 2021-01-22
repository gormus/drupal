# PHP_CodeSniffer & PHP Code Beautifier and Fixer

PHPCS and PHPCBF CLI tools are installed and enabled with multiple standards using a configuration file in the project root: `phpcs.xml`

 * Drupal
 * DrupalPractise

## Composer

composer run-script phpcs web/modules/custom/my_module

composer run-script phpcbf web/modules/custom/my_module/my_module.module



## DDEV 

`ddev phpcs`: Run PHP Code Beautifier and Fixer inside the web container

`ddev phpcbf`: Run PHP CodeSniffer inside the web container

**Examples:**  
ddev phpcs modules/custom/my_module
ddev phpcbf modules/custom/my_module/my_module.module


## PhpStorm

