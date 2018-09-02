# [Youtube - Arquitectura Hexagonal con Adoración González](https://www.youtube.com/watch?v=mttFVrUBh3w)
- [speakerdeck.com - Diapositivas](https://speakerdeck.com/gtoboso/arquitectura-hexagonal-phpmad)
- [Twitter: @srtaDeveloper](https://twitter.com/srtaDeveloper)
- [Github - Este repo](https://github.com/eacevedof/prj_phptests/tree/master/vendor/DesignPatterns/SrtaDeveloper)
- [Behat - PHP Framework for testing](http://behat.org/en/latest/index.html)

## Charla del 23 de septiembre de 2015. Grupo desarrolladores PHP - PHPMad
### Que ofrece la Arq Hex?
- Los cambios en un area de app deberian tener el menor número posible de efectos colaterales.
- Agregar nuevas funcionalidades o formas de interactuar con la app no deberia requerir grandes cambios de código.
- Los procesos de depuración y testeo deberian requerir el menor número de soluciones temporales como sea posible y ser relativamente fáciles.

### Que es?
- Patrón de arquitectura de software.
- Versión ampliada de la arq en 3 capas.

### [Puertos y adaptadores](https://youtu.be/mttFVrUBh3w?t=315)
- Identificamos puertos de E/S
- Usamos **adaptadores** para transformar inputs y outputs
- Organizamos y diseñamos clase para desacoplar (**interfaces**)

### [Esquema](https://youtu.be/mttFVrUBh3w?t=347)
- <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b8bf24a217c8e0d0c69973e/622db0fe57d98923053cbee633501933/image.png" width="300" height="250"/>
-
```yalm
- Inputs
    - Http          adaptador1
    - Cli           adaptador2
    - Integracion   adaptador3
- hexagono
    - puertos de entrada
    - aplicación
    - dominio
    - puertos de salida
- Outputs
    - Notificación
        - adaptador5    Cola de mensajes
        - adaptador6    Email
    - Persistencia
        - adaptador7    Alguna BD
```
- [Clean Architecture - Esquema](https://youtu.be/mttFVrUBh3w?t=472)
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b8bf24a217c8e0d0c69973e/a49fb63d3f59c785e2ce1fcb08fdb26f/image.png" width="300" height="250"/>
    - Tiene un concepto similar

### [Héxagono de Aplicación](https://youtu.be/mttFVrUBh3w?t=489)
- Lo que tiene
- Modelo de dominio
    - Clases, interfaces y servicios del dominio
- Servicios propios de la app
- Subscribers y listeners de eventos del dominio
    - @to-do Que son eventos de dominio?
- Eventos de la app
    - @to-do Que son los eventos de la app?
- Comandos
    - [Acciones a realizar a partir de la inyección de un objeto](https://www.arquitecturajava.com/command-pattern-tareas/)
    - Ejemplo: validarProducto,imprimirProducto,enviarPorCorreo

- Bus de comandos
    - Enrutador de comandos

### [Antes de descubir la arq hex](https://youtu.be/mttFVrUBh3w?t=528)
- 






