# The Framework Helpers Version 0.1.0
PHP view helpers for rendering html elements using objects

* [helpers.theframework.es](http://helpers.theframework.es/){:target="_blank"}
* [https://packagist.org/packages/theframework/helpers](https://packagist.org/packages/theframework/helpers){:target="_blank"}

## Installing with composer
```bash
    composer require theframework/helpers
```

Let's suppose you have your root folder "myphpsite":
```bash
    PCALEX@MSI MINGW64 /d/temp/myphpsite

    $ composer require theframework/helpers

    Using version ^0.0.2 for theframework/helpers
    ./composer.json has been created
    Loading composer repositories with package information
    Updating dependencies (including require-dev)
    Package operations: 1 install, 0 updates, 0 removals
      - Installing theframework/helpers (0.0.2): Loading from cache
    Writing lock file
    Generating autoload files

    PCALEX@MSI MINGW64 /d/temp/myphpsite
```

Once it is installed with composer this structure is created:
```
    myphpsite/
        vendor/
            composer/
            theframework/
                helpers/
                    autoload.php
                    ...
            autoload.php
        composer.json
        composer.lock

        index.php  --> your index file
```

## Including autoload.php
The autoload.php file enables you to instantiate classes (in this case, helpers) using namespaces paths (**use** operator) in place of
using **require** or **include** operators

```php
<?php
//this is index.php  path: myphpsite/index.php
//notice that including autoload.php path using composer is not the same as downloading the package. 

include_once("vendors/autoload.php");//if installed with composer
include_once("theframework/helpers/autoload.php");//if downloaded from http://helpers.theframework.es/versions/
include_once("<anyfolder-you-create>/autoload.php");//downloaded from https://github.com/eacevedof/prj_theframework_helpers/releases

use TheFramework\Helpers\HelperInputText;
$oInput = new HelperInputText();
$oInput->set_name("txtMiFirstInput");
$oInput->set_value("Hello World");
$oInput->add_class("form-control");
$oInput->is_readonly();
$oInput->required();
$oInput->set_maxlength(35);
$oInput->show();

```
<!--
https://getcomposer.org/doc/04-schema.md#psr-0
-->