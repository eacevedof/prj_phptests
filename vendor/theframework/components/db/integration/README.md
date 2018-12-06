# TheFramework\Components\Db\Integration

[]()

## Example
```php
<?php
ini_set("max_execution_time",3000);
require_once "vendor/theframework/components/autoload.php";

use TheFramework\Components\Db\Integration\ComponentExpImpMssql;

$arConn["server"] = "localhost\MSSQLSERVER2014";
$arConn["database"] = "theframework";
$arConn["user"] = "sa";
$arConn["password"] = "some-password";

$oExImp = new ComponentExpImpMssql($arConn);
$arSchema = $oExImp->get_schema();
$arInserts = $oExImp->get_insert_bulk("app_order_line");

echo "<pre>";
print_r($arSchema);
print_r($arInserts);
```