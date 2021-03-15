# Service containers

The Laravel service container is a powerful tool for managing class dependencies 
and performing dependency injection. 
Dependency injection is a fancy phrase that essentially means this: class dependencies are 
"injected" into the class via the constructor or, in some cases, "setter" methods.

### Zero Configuration Resolution
If a class has no dependencies or only depends on other concrete classes (not interfaces), 
the container does not need to be instructed on how to resolve that class.

Two cases when you will need to bind or resolve anything from a container.

First, if you write a class that implements an interface and you wish to type-hint that interface on a route or class constructor, 
you must tell the container how to resolve that interface.
Secondly, if you are writing a Laravel package.

### Binding



# Facades

__callStatic php magic method exits in the root Facade class.
This method is called every time you call a static method
on a class that it has not been defined.

getFacadeRoot static method located in the magic method returns
resolveFacadeInstance static method which accepts the getFacadeAccessor method that is
located in every facade class that returns the key for that facades
that is resolved in the service container.

# Real-Time Facades

Just add Facades\App\Payment; in the use of the class and it works like
real time facade.

This is done by:
spl_autoload_register() method. This function allows you to register
a function that will be triggered anytime a new class is referenced or
instantiated.
