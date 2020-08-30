# prj_phptests - (30/08/2020)
- Es un "miniframework" tipo sandbox donde tengo varias pruebas
- **arrancar la app** 
```js
php -S localhost:1024 -t ./public
```
- **configuracion**
- Crear paquete en vendor
- Dar de alta este paquete en composer.json [opcional]
    ```json
    //<this-project>/composer.json
    {
        "require": {
            "theframework/helpers": "^0.1.0",
            "php-di/php-di": "^6.0",
            "monolog/monolog": "^2.0",
            "ocramius/proxy-manager": "^2.2"
        },
        "autoload":{
            "psr-4":{
                "DesignPatterns\\":"vendor/DesignPatterns"  <-- AQUI
            }
        },
        "require-dev": {
            "phpunit/phpunit": "^7"
        }
    }
    ```
    - Recargar el autoload de composer
        - `composer dump-autoload`
- Crear el fichero que utilizará este paquete en **`examples/<carpeta-correspondiente>`** debe llevar @file e @info.
```php
//examples/designpatterns/gof_factory.php
/**
 * @file: gof_factory.php
 * @info: https://github.com/eacevedof/prj_phptests/tree/master/vendor/DesignPatterns/Gof
 *        [Curso de Patrones de diseño - 2 factory by MitoCode](https://www.youtube.com/watch?v=gocJeOHtj9w&list=PLvimn1Ins-41Uiugt1WbpyFo1XT1WOquL&index=2)
 */
include(TFW_PATHROOTDS."vendor/autoload.php");

use DesignPatterns\Gof\factory\Main;
Main::main();
```

## Indice de paquetes con pruebas
- DesignPatterns:
    - [Dddinphp (Carlos Buenosvinos)](https://github.com/eacevedof/prj_phptests/tree/master/vendor/DesignPatterns/Dddinphp)
        - Incompleto, empecé pero no he continuado por falta de tiempo y pq el libro es un poco denso ya que se usa jerga de UML
    - [Gof by MitoCode](https://github.com/eacevedof/prj_phptests/tree/master/vendor/DesignPatterns/Gof)
        - Faltan algunos patrones, no he seguido porque con únicamente teoria no se como aplicarlo a casos de uso 
        - Para esto hay un curso de escuela.it que indica cuando como y porque en casos de uso
    - [Gof Factory](https://github.com/eacevedof/prj_phptests/tree/master/vendor/DesignPatterns/Gof/Factory)
        - Ejemplo de una factoria de conexiones según un motor de bd
    - [Gof Sourcemaking](https://github.com/eacevedof/prj_phptests/tree/master/vendor/DesignPatterns/Gof/FactorySM)
        - Ejemplo de factoria partiendo de fuente de código de [sourcemaking](https://sourcemaking.com/design_patterns/abstract_factory/php/2)
    - [Gof Singleton](https://github.com/eacevedof/prj_phptests/tree/master/vendor/DesignPatterns/Gof/Singleton)
        - Ejemplo básico de una clase de conexión singleton
    - [Observer](https://github.com/eacevedof/prj_phptests/tree/master/vendor/DesignPatterns/Observer)
        - Tutorial: [Análisis de los patrones de diseño con larave](https://youtu.be/SCpigk7UToM?t=1037)
        - Ejemplo: [El interfaz SplSubject](http://php.net/manual/es/class.splsubject.php)
    - [ObserverPO](https://github.com/eacevedof/prj_phptests/tree/master/vendor/DesignPatterns/ObserverPO)
        - Ejemplo [Youtube Post Office](https://www.youtube.com/watch?v=rWvXJo3OAzs)
    - [Repositories](https://github.com/eacevedof/prj_phptests/tree/master/vendor/DesignPatterns/Repositories)
        - La explicación se basa en como usa laravel el patrón repositorio
        - [Escuela It - Repositorio](https://www.youtube.com/watch?v=SCpigk7UToM&feature=youtu.be&t=1680)
        - [Laravel doc - IoC - Inversion of control container](https://laravel.com/docs/4.2/ioc)
            - Configuración del contenedor del inyector de dependencias con repositorios
    - [SrtaDeveloper](https://github.com/eacevedof/prj_phptests/tree/master/vendor/DesignPatterns/SrtaDeveloper)
        - [Youtube - Arquitectura hexagonal](https://youtu.be/mttFVrUBh3w)
        - [Diapositivas](https://speakerd.s3.amazonaws.com/presentations/16c77c47111a4b7b8ba68d1a0bf9bd4d/DIAPOSITIVAS_Hexagonal_Architecture.pdf)
    - [Youtube - UPM - Master Patrones de Diseño](https://www.youtube.com/playlist?list=PLj2IVmcP-_QOQcDplVNiLbBQ6OLCXX7fv) **To-do**
        - [Repo original - Github](https://github.com/miw-upm/apaw/tree/develop/src/main/java/es/upm/miw/pd)
- [solid](https://github.com/eacevedof/prj_phptests/tree/master/vendor/solid)
    - Explicación de SOLID en Java que traduzco a PHP
    - [Youtube - SOLID - Principios de diseño de software y patrones de diseño by 
Video Tutoriales Android](https://www.youtube.com/watch?v=j_ZnM8FJcmA)

## Indice de ficheros instanciadores 
```js
examples
    ├───components
    │    comp_applepush.php
    │    comp_dts_auxrepl.php
    │    comp_dts_connrep.php
    │    comp_dts_extract.php
    │    comp_dts_queryrep.php
    │    comp_gd2.php
    │    comp_hydra_logs.php
    │    comp_hydra_pk.php
    │    comp_mssql.php
    │    comp_mssql_export.php
    │    comp_mysql.php
    │
    ├───designpatterns
    │    gof_factory.php
    │    gof_factorysm.php
    │    gof_singleton.php
    │    pattern_observer.php
    │    pattern_observerpo.php
    │
    ├───helpers
    │    help_date.php
    │    help_gmapsv3.php
    │    help_hidden.php
    │    help_input_text.php
    │
    └───mixed
          ip_banned.php
          phpinfo.php
          php_globals.php
          preg_match.php
          usererrorhandler_1and1.php
```

## Ejecución en vivo
- [live test.theframework.es](http://test.theframework.es)

## Notas
- Aqui he dejado a medias el refactor de los Helpers ^^ 2.0
- Hay que aplicar esto en **autoload_real.php**
```php
//@eaf
if(stream_resolve_include_path($file))    
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
```

## To-Do
- Está dando muchos errores por cambios de ruta y refactor
- Errores de ejemplos con MSSQL
- He dejado un prototipo de helpers.theframework.es 