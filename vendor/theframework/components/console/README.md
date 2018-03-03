# namespace TheFramework\Components\Console

```
php run.php $argv[1]                $argv[2]                    $argv[3]    $argv[4..n]
php run.php <path_file_to_include>  <class_name_case_sensitive> <method>    <rest-of-arguments>
```

## Example
```
php run.php C:\Proyectos\...\phplibs\component_download.php ComponentDownload get_file 
```

```
D:\xampp\php\php.exe D:\xampp\htdocs\prj_phptests\vendor\theframework\components\console\run.php D:\xampp\htdocs\prj_phptests\vendor\theframework\components\component_getter.php ComponentGetter go >>  D:\xampp\htdocs\prj_phptests\vendor\theframework\components\console\console.log
```