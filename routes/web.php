<?php

use App\Utilities\Container;
use App\Utilities\Transistor;
use Illuminate\Support\Facades\App;
use LaracastsFacades\App\Utilities\Payment;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/{user}', function (User $user) {
    return $user;
});

// Optional parameters
//Route::get('user/{name?}', function ($name = 'John') {
//    return $name;
//});

//Regular Expression Constraints
Route::get('profile/{id}/{name}', function () {
    $route = Route::current();

    $name   = Route::currentRouteName();
    $action = Route::currentRouteAction();

    dump($route, $name,
        $action);
    return 'hh';
})->where(['id' => '[0-9]+', 'name' => '[a-z]+'])->name('profile.name');

//In Laravel 8.x
Route::get('/user/{id}/{name}', function ($id, $name) {
    //
})->whereNumber('id')->whereAlpha('name');

Route::get('/user/{name}', function ($name) {
    //
})->whereAlphaNumeric('name');

Route::get('/user/{id}', function ($id) {
    //
})->whereUuid('id');

//If you pass additional parameters in the array, those key / value pairs will automatically be added
// to the generated URL's query string:

Route::get('user/{id}/profile', function ($id) {
    //
})->name('profile');

//$url = route('profile', ['id' => 1, 'photos' => 'yes']);

// /user/1/profile?photos=yes

//Route::middleware(['first', 'second'])->group(function () {
//    Route::get('/', function () {
//        // Uses first & second Middleware
//    });
//
//    Route::get('user/profile', function () {
//        // Uses first & second Middleware
//    });
//});

//Not in laravel 8 doc
Route::namespace('Admin')->group(function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
});

Route::fallback(function () {
    return 'another 404';
});

//In Laravel 8.x
Route::get('/posts/{post:slug}', function (Post $post) {
    return $post;
});

//to change the default binding column

//Custom Keys & Scoping

//When implicitly binding multiple Eloquent models in a single route definition,
// you may wish to scope the second Eloquent model such that it must be a child of the previous Eloquent model.
// For example, consider this route definition that retrieves a blog post by slug for a specific user:

use App\Models\Post;
use App\Models\User;

Route::get('/users/{user}/posts/{post:slug}', function (User $user, Post $post) {
    return $post;
});

//When using a custom keyed implicit binding as a nested route parameter, Laravel will automatically scope
// the query to retrieve the nested model by its parent using conventions to guess the relationship name on the parent.
// In this case, it will be assumed that the User model has a relationship named posts
// (the plural form of the route parameter name) which can be used to retrieve the Post model.

//Customizing Missing Model Behavior
//The missing method accepts a closure that will be invoked if an implicitly bound model can not be found:

use App\Http\Controllers\LocationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

Route::get('/locations/{location:slug}', [LocationsController::class, 'show'])
    ->name('locations.view')
    ->missing(function (Request $request) {
        return Redirect::route('locations.index');
    });

//Explicit binding
//If a route is utilizing implicit binding scoping, the resolveChildRouteBinding method will
// be used to resolve the child binding of the parent model:
//In the model

///**
// * Retrieve the child model for a bound value.
// *
// * @param  string  $childType
// * @param  mixed  $value
// * @param  string|null  $field
// * @return \Illuminate\Database\Eloquent\Model|null
// */
//public function resolveChildRouteBinding($childType, $value, $field)
//{
//    return parent::resolveChildRouteBinding($childType, $value, $field);
//}

app()->bind('example', function () {
    return new User();
});

Route::get('/container', function () {

    resolve('example');
    $container = new Container();

    $container->bind('example', function () {
        return new User();
    });

    $user = $container->resolve('example');
});

spl_autoload_register(function ($name) {
    if (Str::startsWith($name, 'LaracastsFacade')) {
        $stub      = file_get_contents(app_path('facade.stub'));
        $className = class_basename($name);
        $namespace = str_replace('/', '\\', dirname(str_replace('\\', '/', $name)));
        $accessor  = str_replace('LaracastsFacades', '', $namespace) . '\\' . $className;
        $stub      = str_replace([
            '{namespace}',
            '{className}',
            '{accessor}',
        ], [
            $namespace,
            $className,
            $accessor,
        ],
            $stub
        );

        file_put_contents($path = app_path($className . 'Facade.php'), $stub);
        require $path;
    }
});

Route::get('/payments', function () {
    return Payment::process();
});


Route::get('/test', function (\App\Utilities\ReportAggregator $report) {
dd($report->timezone);
   //dump($transistor->handle());
   //dd($transistor->parser);
});

Route::get('/int', function(\App\Http\Controllers\PhotoController $photo) {
    dd($photo);
})->name('photo.index');

//App::bind(Transistor::class, function ($app) {
//    dd($app);
//});
