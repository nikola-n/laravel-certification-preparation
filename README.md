# Laravel Certification Preparations - Laravel 6.x

## Things that I don't know they appear in docs.

## Routing


Basic

- match, any, options - HTTP verbs.
- Route::redirect('uri', 'destination', 'statusCode'); without need of a controller. It returns 302 by default. To
  change it use third param or use Route::permanentRedirect('uri', 'destination'); to return 301 statusCode.

Route Parameters

- Route parameters may not contain a - character. Instead of using the - character, use an underscore (_)
- Regex Constraints using ->where('column', '[0-9]+');
- Global constraints in the boot method of RouteServiceProvider using Route::pattern('id', 'regex') and parent::boot();
- The Laravel routing component allows all characters except /.

Named Routes

- If you pass additional parameters in the array, those key / value pairs will automatically be added to the generated
  URL's query string:
  $url = route('profile', ['id' => 1, 'photos' => 'yes']); /user/1/profile?photos=yes

Sometimes, you may wish to specify request-wide default values for URL parameters, such as the current locale. To
accomplish this, you may use the URL::defaults method.

Route::get('/{locale}/posts', function () { // })->name('post.index');

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

In the routeMiddleware add this middleware.

Inspecting The Current Route
- named('routeName') helper, used in routeMiddleware in Kernel.php

/**
 * Handle an incoming request.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \Closure  $next
 * @return mixed
 */
public function handle($request, Closure $next)
{
    if ($request->route()->named('profile')) {
        //
    }

    return $next($request);
}

Route Groups
- middlewares
- namespaces
- subdomain routing - Assign them before the domain root routes
Route::domain('{account}.myapp.com')->group(function () {
    Route::get('user/{id}', function ($account, $id) {
        //
    });
});
- route name prefixes
Route::name('admin.')->group(function () {
    Route::get('users', function () {
        // Route assigned name "admin.users"...
    })->name('users');
});

Route Model Binding
- for explicit binding use route::model in RouteServiceProvider boot method

public function boot() {
    parent::boot();
    Route::model('user', App\User::class);
}

- Customizing The Resolution Logic
If you wish to use your own resolution logic, you may use the Route::bind method. 
The Closure you pass to the bind method will receive the value of the URI segment and should return 
the instance of the class that should be injected into the route:
Route::bind('user', function ($value) {
            return User::where('name', $value)->firstOrFail();
        });

        parent::boot();
}

-Alternatively, you may override the resolveRouteBinding method on your Eloquent model. 
This method will receive the value of the URI segment and should return the instance of the
class that should be injected into the route:

public function resolveRouteBinding($value)
{
    return $this->where('name', $value)->firstOrFail();
}

- Fallback routes
Route::fallback(function () {
    //
});
Override the 404 page and do something different. It should be called last.

- Rate Limiting
There is a middleware to rate limit the access to the routes. You can add the middleware 
to the route. It accepts two params: max number of requests and number of minutes. 
Route::middleware('auth:api', 'throttle:60,1')->group(function () {
    Route::get('/user', function () {
        //
    });
});

Dynamic Rate Limiting
based on an attribute of the authenticated User model. 
'throttle:rate_limit,1' 

Distinct Guest & Authenticated User Rate Limits
you may specify a maximum of 10 requests per minute for guests 60 for authenticated users:

Route::middleware('throttle:10|60,1')->group(function () {
    //
});
for the auth users you can still pass the attribute instead of 60.

Rate Limit Segments
- pass third argument as a segment name
Route::middleware('auth:api')->group(function () {
    Route::middleware('throttle:60,1,default')->group(function () {
        Route::get('/servers', function () {
            //
        });
    });

    Route::middleware('throttle:60,1,deletes')->group(function () {
        Route::delete('/servers/{id}', function () {
            //
        });
    });
});
