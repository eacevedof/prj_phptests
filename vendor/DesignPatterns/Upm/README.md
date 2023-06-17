- Patrones de Diseño - Universidad Politécnica de Madrid (MIW)
- [Youtube Playlist] (https://www.youtube.com/watch?v=kD1Cr6hp7ow&list=PLj2IVmcP-_QOQcDplVNiLbBQ6OLCXX7fv&index=1&t=5s)
- Composite
  - [Enunciado](https://youtu.be/E85Nu2auOFI?list=PLj2IVmcP-_QOQcDplVNiLbBQ6OLCXX7fv) 
  - composite (Compuesto)

  - **Motivación**
    Enlas aplicaciones gráficas, se permiten realizar dibujos por la agrupación de elementos simples y otros elementos agrupados
  - **Fuentes**:
    - paquete composite, paquete test composite
  - **Árbol de números**
    Se quiere construir una estructura de árbol con valores numéricos.
    Existen nodos con valores numéricos (hojas) y nodos que contienen otros nodos (compuestos)
    Si se intenta añadir a un nodo hoja, se debe lanzar la excepción:
    UnsupportedOperationException. Si se intenta borrar nodos a una hoja no se hace nada
    Si se intenta añadir o borrar con parámetro ll, no hace nat debe dar errores
  - Se deben crear las opreaciones:
    - numberOfNodes
    - sum
    - higher
    sobre si mismo y todos los nodos que dependen de él.