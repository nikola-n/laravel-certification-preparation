# Controllers 

Request handling classes.

### Single Action Controllers

public function __invoke()
{
// ...
}

Route::post('/server', ProvisionServer::class);

php artisan make:controller ProvisionServer --invokable

Controller stubs may be customized using stub publishing

### Controller Middleware

Middleware within the controller class construct method:

public function __construct()
{
$this->middleware('auth');
$this->middleware('log')->only('index');
$this->middleware('subscribed')->except('store');
}

They can be registered in a closure too so you dont need to write dedicated class:
$this->middleware(function ($request, $next) {
return $next($request);
});

### Resource Controllers

php artisan make:controller PhotoController --resource / -r

You may even register many resource controllers at once by passing an array to the resources method:

Route::resources([
'photos' => PhotoController::class,
'posts' => PostController::class,
]);

# Specifying The Resource Model

php artisan make:controller PhotoController --resource --model=Photo

Route::apiResource('photos', PhotoController::class); 
automatically excludes create and edit views methods

You may register many API resource controllers at once by passing an array to the apiResources method:

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PostController;

Route::apiResources([
'photos' => PhotoController::class,
'posts' => PostController::class,
]);

php artisan make:controller PhotoController --api
generate api resource controller

# Nested Resources

se App\Http\Controllers\PhotoCommentController;

Route::resource('photos.comments', PhotoCommentController::class);
/photos/{photo}/comments/{comment}

### Scoping Nested Resources
It's automatically scoped with the implicit route model binding. If you want to change the
child resource route model binding field you can use scoped method.

Route::resource('photos.comments', PhotoCommentController::class)->scoped([
'comment' => 'slug',
]);
/photos/{photo}/comments/{comment:slug}


### Shallow Nesting
Often, it is not entirely necessary to have both the parent and the child IDs
within a URI since the child ID is already a unique identifier.

Route::resource('photos.comments', CommentController::class)->shallow();

specific route names:
photos.comments.index
photos.comments.create
photos.comments.store
comments.show
comments.edit
comments.update
comments.destroy

### Naming Resource Routes

to override the defaults use the names method:
use App\Http\Controllers\PhotoController;

Route::resource('photos', PhotoController::class)->names([
'create' => 'photos.build'
]);

### Naming Resource Route Parameters
to override the defaults (a signular model name) use parameters:

use App\Http\Controllers\AdminUserController;

Route::resource('users', AdminUserController::class)->parameters([
'users' => 'admin_user'
]);

generated uri: /users/{admin_user}

### Localizing Resource URIs

public function boot()
{
Route::resourceVerbs([
'create' => 'crear',
'edit' => 'editar',
]);
}
in RouteServiceProvider boot method

### Supplementing Resource Controllers

If you need to add additional routes to a resource controller beyond the default set 
of resource routes, you should define those routes before your call to the Route::resource 
method; otherwise, the routes defined by the resource method may unintentionally 
take precedence over your supplemental routes:

Route::get('/photos/popular', [PhotoController::class, 'popular']);
Route::resource('photos', PhotoController::class);

Remember to keep your controllers focused. If you find yourself routinely needing methods
outside of the typical set of resource actions, consider splitting your controller into two,
smaller controllers.

# Dependency Injection & Controllers
### Constructor and Method Injection

