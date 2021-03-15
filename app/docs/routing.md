# Basic Routing

### Default Route Files

- RouteServiceProvider
- web.php has web middleware group providers features like session state and csrf protection.
- api.php api middleware group, stateless.

### Available Router Methods

- basic HTTP verbs (get,post,put,patch,delete) + options
- match method for registering a route that responds to more HTTP verbs. Route::match(['get', 'post'], '/', function())
  {}
- any method for registering a route that responds to all HTTP verbs. Route::any('/', function()){}

### Dependency Injection - only in Laravel 8 doc

- type-hint any dependencies in the callback and it will be resolved by the laravel service container. ex. Route::get('
  /users', function (Request $request) {});

### Cross-site request forgery

@csrf directive CSRF - Tricking the users into submitting a request that they did not intend. 419 failed csrf auth -
laravel status code, throws token mismatch exception.

### Redirect Routes

- Route::redirect('uri', 'destination', 'statusCode'); without need of a controller.
- It returns 302 status code by default.
- To change it use third param or use Route::permanentRedirect('uri', 'destination'); to return 301 statusCode.

### View Routes

Route::view('/welcome', 'welcome', ['name' => 'Taylor']);

# Route Parameters

### Required parameters

- Route parameters may not contain a - character. Instead of using the - character, use an underscore (_)

### Parameters & Dependency Injection - only in Laravel 8 doc

### Optional Parameters
- Make sure to give the route's corresponding variable a default value:
  Route::get('user/{name?}', function ($name = null) {
  return $name;
  });
  
### Regular Expression Constraints
- Regex Constraints using ->where('column', '[0-9]+');
  
#### only In laravel 8
->whereNumber('id')->whereAlpha('name');
->whereAlphaNumeric('name');
->whereUuid('id');

#### Global constraints - applied on all routes
- defined in the boot method of RouteServiceProvider using Route::pattern('id', 'regex') and parent::boot();

#### Encoded Forward Slashes
- The Laravel routing component allows all characters except /.
- To allow explicitly should be added with:
  ->where('search', '.*');
  
# Named Routes

### Generating URLs To Named Routes
->name('profile');
route('profile', ['id' => 1, 'photo' => 'yes']);

### Default values
- default values for URL parameters, such as the current locale.
URL::defaults(['locale' => $request->user()->locale]);
You need to add a middleware.
  
Route::get('/{locale}/posts', function () { // })->name('post.index');

In the routeMiddleware add this middleware.

<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class SetDefaultLocaleForUrls
{
    public function handle($request, Closure $next)
    {
        URL::defaults(['locale' => $request->user()->locale]);

        return $next($request);
    }
}

?>

### Inspecting The Current Route
- to determine if the current request was routed to a given named route, 
  you may use the named method on a Route instance.
  
public function handle($request, Closure $next) {
  if ($request->route()->named('profile')) {
  //
  }

  return $next($request); 
}

# Route Groups
