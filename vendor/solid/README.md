#SOLID - Principios

## [Tutorial](https://www.youtube.com/watch?v=j_ZnM8FJcmA)

## [Solid Principles the definitive Guide](https://android.jlelse.eu/solid-principles-the-definitive-guide-75e30a284dea)

1. Single Responsability Principle (SRP)

2. Open / Close Principle (OCP)
    - open for extension: new behaviour can be added to satisfy the new requirements.
    - closed for modification: to extending the new behaviour are not required modify the existing code.

3. Liskov Substitution Principle (LSP):
    - Objects in a program should be replaceable with instances of their subtypes without altering the correctness of that program.

4. Interface Segregation Principle (ISP):
    - Many client-specific interfaces are better than one general-purpose interface

5. Dependency Inversion Principle (DIP)
    - High-level modules should not depend on low-level modules. 
    - Both should depend on abstractions.
    - Abstractions should not depend on details. 
    - Details should depend on abstractions.