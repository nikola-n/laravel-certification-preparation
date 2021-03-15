# Middleware

A convenient mechanism for inspecting and filtering HTTP requests entering your application.

To pass the request deeper into the application (allowing the middleware to "pass"), 
you should call the $next callback with the $request.

It's best to envision middleware as a series of "layers"HTTP requests must pass through
before they hit your application. 
Each layer can examine the request and even reject it entirely.

All middleware are resolved via the service container, 
so you may type-hint any dependencies you need within a middleware's constructor.

### Middleware & Responses

A middleware can perform tasks before or after passing the request deeper into the application.

- Before
First perform action, then return $next($request);
  
- After
First $response = $next($request); then perform action, then return $response;


# Registering Middleware

### Global Middleware
If you want a middleware to run during every HTTP request to your application, 
list the middleware class in the $middleware property of your app/Http/Kernel.php class.

### Assigning Middleware To Routes

If you would like to assign middleware to specific routes, you should first assign the 
middleware a key in your application's app/Http/Kernel.php in the $routeMiddleware array.

In the route ->middleware(['one', 'two']), ->middleware('one'), or pass the whole Middleware::class.

In a group middleware you may need to remove the group middleware for some route. To do that use
->withoutMiddleware([EnsureTokenIsValid::class]);

The withoutMiddleware method can only remove route middleware and does not apply to global middleware.

# Middleware Groups

$middlewareGroups array in the Kernel.php. Already done for web and api.
Route::middleware(['web'])->group(function () {});

# Sorting Middleware

$middlewarePriority array 

# Middleware Parameters

Middleware can also receive additional parameters.

I may contain aditional parameter in the handle method  

public function handle($request, Closure $next, $role)
{
if (! $request->user()->hasRole($role)) {
// Redirect...
}
        return $next($request);
}
The aditional parameters may be specified on the route  by 
separating the middleware name and parameters with a : .
Multiple parameters should be delimited by commas.

Route::put('/post/{id}', function ($id) {
//
})->middleware('role:editor');

# Terminable Middleware

Sometimes a middleware may need to do some work after the HTTP 
response has been sent to the browser.
If you define a terminate method on your middleware and your web server is using FastCGI,
the terminate method will automatically be called after the response is sent to the browser:

public function handle($request, Closure $next)
{
return $next($request);
}

/**
 * Handle tasks after the response has been sent to the browser.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \Illuminate\Http\Response  $response
 * @return void
 */
public function terminate($request, $response)
{
    // ...
} 
   
When calling the terminate method on your middleware, Laravel will resolve a fresh instance of
the middleware from the service container.

If you would like to use the same middleware instance when the handle and terminate methods
are called, register the middleware with the container using the container's singleton method. 
Typically this should be done in the register method of your AppServiceProvider:

public function register()
{
$this->app->singleton(TerminatingMiddleware::class);
}
