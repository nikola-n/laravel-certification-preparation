<?php

use App\Utilities\Container;
use App\Utilities\RedisEventPusher;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('user/{id?}', function ($id = 1) {
    echo 'User # ' . $id;

    $route  = Route::current(); // Illuminate\Routing\Route
    $name   = Route::currentRouteName(); // string
    $action = Route::currentRouteAction(); // string
})->name('user.name');

Route::get('/user', function () {
    return 'Default User';
});

Route::get('user/{name?}', function ($name = 'John') {
    return 'User - ' . $name;
});

Route::get('/', function () {
    return view('welcome');
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

//Route::fallback(function () {
//    return 'another 404';
//});

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


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

Route::get('/locations/{location:slug}', [\App\Http\Controllers\AccountController::class, 'show'])
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

//  TODO Real Time Facades Example
// Even if it's not a facade if you add in use the Facade in front of the path
// the class will act like a facade:
// example: App\Payments -> Facade\App\Payments

// It allows to register a class that will be triggered everytime a new
// class is instantiated

// LaracastsFacade\App\Utilities\Payment
use LaracastsFacades\App\Utilities\Payment;

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
//=======================================================================
Route::get('/test', function (\App\Utilities\ReportAggregator $report) {
    dd($report->timezone);
    //dump($transistor->handle());
    //dd($transistor->parser);
});

Route::get('/int', function (\App\Http\Controllers\PhotoController $photo) {
    $photo->handle();
})->name('photo.index');

Route::get('interfaceBinding', function (RedisEventPusher $pusher) {
    $pusher->pusher();
});

Route::get('collections', function () {

    $collection = collect([1, 2, 3]);

    $total = $collection->reduce(function ($carry, $item) {
        // first iteration carry value is null
        // second iteration carry value is null + 1 = 1
        // third iteration carry value is 1 + 2 = 3
        // fourth iteration 3 + 3 = 6
        return $carry + $item;
        //you can modify the starting carry value
    }, null);

    $collection = collect([
        'usd' => 1400,
        'gbp' => 1200,
        'eur' => 1000,
    ]);

    $ratio = [
        'usd' => 1,
        'gbp' => 1.37,
        'eur' => 1.22,
    ];

    $collection->reduce(function ($carry, $value, $key) use ($ratio) {
        // 1. null + (1400 * 1) = 1400
        //2.  1400 + (1200 * 1.37) = 3044
        //3. 3044 + (1000 * 1.22) = 4264
        return $carry + ($value * $ratio[$key]);
    });

    collect([2, 4, 3, 1, 5])
        ->sort()
        ->tap(function ($collection) {
            Log::debug('Values after sorting', $collection->values()->all());
        })
        ->shift();

    $collection = Collection::times(10, function ($number) {
        return $number * 9;
    });

    //return \App\Models\Video::recentByDate();
    return \App\Models\Video::latest()->get()->groupByDate();
});

//Topic URL Generators
// Signed Url, very common for unsubscribe newsletter links
Route::get('/signed', function () {
    if ( ! request()->hasValidSignature()) {
        abort(403);
    }

    return view('welcome');

})->name('route');

// In tinker
//url()->signedRoute('route');
//output:
// "http://certification-preparation.test/signed?signature=20356a264a70b812aaba9fafdb6641341bf058dd9744308ac7a4b0ffd2b6adc1"
//url()->temporarySignedRoute('route', now()->addDay());
//output:
//"http://certification-preparation.test/signed?expires=1620916549&signature=4619af8892c36699660ef27a1e01967a240b903a45da919980145c9707016abe"
//hash_hmac('sha256', 'http://certification-preparation.test/signed?expires=1620916549', env('APP_KEY'));
// the same hash is returned :)

//allow user to update his email.
// - add pending_email field in users table
// - add new route with a given controller and a name
// - when user requests email change generate temporarySignedRoute url with button
// - add ! request()->hasValidSignature() to the controller

// There is also a "signed" middleware that comes with laravel to skipp all of this

//Route Throttle Requests Topic

Route::get('/download/{id}', function ($id) {

})->middleware(['auth', 'throttle:download_limit,1']);

// the first argument of throttle middleware is the number of requests
//which can be customized per user:
//Example: if a user have a basic subscription he can download 3 times,
//user with premium can download 10 times etc.
//The download_limit should be set now as a getter in the user model
//getDownloadLimitAttribute(){
//if($this->premiumUser()) {
//    return 10;
//}
//return 3;
//}

Route::get('/groupBy', function () {

    $collection = collect([1, 2, 3]);

    $total = $collection->reduce(function ($carry, $item) {
        return $carry + $item;
    }, 4);

    dd($total);
    //$collection = collect([
    //    ['product_id' => 'prod-100', 'name' => 'Desk'],
    //    ['product_id' => 'prod-200', 'name' => 'Chair'],
    //]);
    //
    //$keyed = $collection->keyBy('product_id');
    //$groupedBy = $collection->groupBy('product_id');
    //
    //dump($groupedBy->all());
    //dd($keyed->all());
});

Route::get('account', [
    \App\Http\Controllers\AccountController::class,
    'index',
])->name('account.index')->middleware('before.after');
Route::post('account', [\App\Http\Controllers\AccountController::class, 'store'])
    ->name('account.store')
    ->middleware('terminate');

//Route::match('/testetest',function () {
//    return 'something';
//});
//- it generates clasnames aliases
//- it includes the files for you
Route::redirect('/hoho', 301);

Route::redirect('/here', '/ho');

Route::get('carbon', function () {
    $order               = new \App\Models\Order();
    $order->purchaseDate = "2020-10-10 10:10:10";
    //$order->setAttribute('purchase_date', "2020-10-10 10:10:11");
    //$order->purchaseDate = new Carbon("2020-10-10 10:10:12");

    //$order->purchase_date = "2020-10-10 10:10:13";
    $order->save();
    //dd($order->purchase_date);
    $hello = new Nikola\HelloWorld\HelloWorld();
    return $hello->hi('Nikola');
});

//1. What is the first line of executed code in Laravel during web request?
//- In index.php the first line stores the current time in a constant.

//2. Can a collection object be used as array too?
//    $collection = collect(['Tom', 'Jerry']);
//    dd($collection[0]); // Tom
//- Yes.

//3. When you hit the laravel application with the get request which Kernel is
//responsible for creating a response?

//- Http Kernel

//4. Where is the eloquent ::all() method located?
//- The Eloquent Base model

//5. In order to match a route laravel will make use of some validators.
//    Which one?
//    -\Illuminate\Routing\Matching\UriValidator::class,
//\Illuminate\Routing\Matching\HostValidator::class
//\Illuminate\Routing\Matching\SchemeValidator::class
//\Illuminate\Routing\Matching\MethodValidator::class

//6. Lifecycle request from first to last
//- check maintenance mode,
//- register autoloader
//- create application instance,
//-use kernel to create response

//7. Whats the 2nd argument of the pluck collection method for
//-it defines the keys of the names

// For laravel 8.
//When do you want the "scoped" method instead of "signleton" when binding to the service container
//- to let the class only be resolved once during one life-cycle

//Route::get('raw', function () {
//    //$users = DB::select('select * from users', 'repor');
//
//    DB::select('select * from users');
//    DB::table('users')->get();
//    User::query()->get();
//    User::all();
//    $users = User::paginate(5);
//    return view('welcome', compact('users'));
//    $users = DB::table('users')->simplePaginate(3);
//    //DB::table('users')->paginate(3);
//
//    // state a pole na kolona, ne znam so prai
//    $orders = DB::table('orders')
//        ->whereRaw('price > IF(state = "TX", "?", 100)', [200])
//        ->get();
//
//    // mnozi po 1,0825 za sekoj price.
//    $orders = DB::table('orders')
//        ->selectRaw('price * ? as price_with_tax', [1.0825])
//        ->get();
//
//    // group by department, gi sobira sumite na deparment so isto ime.
//    // gi cita samo tie pogolemi od 2500.
//    $orders = DB::table('orders')
//        ->select('department', DB::raw('SUM(price) as total_sales'))
//        ->groupBy('department')
//        ->havingRaw('SUM(price) > ?', [2500])
//        ->get();
//
//    $orders = DB::table('orders')
//        ->orderByRaw('updated_at - created_at DESC')
//        ->get();
//
//    $orders = DB::table('orders')
//        ->select('city', 'state')
//        ->groupByRaw('city, state')
//        ->get();
//
//    // site orders gi spojuva so prviot user
//    // pa site orders gi spojuva so vtoriot user it.n
//    $users = DB::table('orders')
//        ->crossJoin('users')
//        ->get();
//
//    $latestPosts = DB::table('posts')
//        ->select('user_id', DB::raw('MAX(created_at) as last_post_created_at'))
//        ->where('published_at', '<', now())
//        ->groupBy('user_id');
//
//    $users = DB::table('users')
//        ->joinSub($latestPosts, 'latest_posts', function ($join) {
//            $join->on('users.id', '=', 'latest_posts.user_id');
//        })->get();
//
//    $first = DB::table('users')
//        ->whereNull('name');
//
//    $users = DB::table('users')
//        ->whereNotNull('email')
//        ->union($first)
//        ->get();
//
//    $users = DB::table('users')
//        ->where('name', 'like', 'T%')
//        ->get();
//
//    $users = DB::table('users')
//        ->whereColumn('name', 'email')
//        ->get();
//
//    $users = DB::table('users')
//        ->whereExists(function ($query) {
//            $query->select(DB::raw(1))
//                ->from('posts')
//                ->whereRaw('posts.user_id = users.id');
//        })
//        ->get();
//
//    $users = DB::table('users')->skip(5)->take(5)->get();
//    $users = DB::table('users')
//        ->offset(5)
//        ->limit(5)
//        ->get();
//
//    $sortBy = null;
//
//    $users = DB::table('users')
//        ->when($sortBy, function ($query, $sortBy) {
//            return $query->orderBy($sortBy);
//        }, function ($query) {
//            return $query->orderBy('name');
//        })
//        ->get();
//
//
//    $users    = DB::connection('mysql-reports')->select('select * from users');
//    $pdo      = DB::connection()->getPdo();
//    $users    = DB::select('select * from users where active = ?', [1]);
//    $affected = DB::update('update users set votes = 100 where name = ?', ['constance vandervort iii']);
//    dd($affected);
//
//});

action([\App\Http\Controllers\AccountController::class, 'index']);
// generates url: "http://certification-preparation.test/account"

Route::get('retrieveUserName', function () {
    $user = User::updateOrCreate([
        'name'  => 'Nikola',
        'email' => 'najdov@najdov'.rand(1,10).'.com',
        'password' => 'test132323',
        'active' => true,
        'votes' => 100,
        'fuck' => ['hey' => 'you'],
        'subscription_type' => 3,
    ]);

    dd($user->toJson());
//$fuck = $user->fuck;
//$fuck['hey'] = 'kakosi';
//$user->fuck = $fuck;
//$user->save();

//dd($user);
// ['hey' => 'you']

    //$user->makeVisible('email');
//$user->makeVisible('votes');
//$user->makeHidden('email');
//dd($user->toJson());
//    $user->getLowerCasedName();
});


Route::get('/ordership', [\App\Http\Controllers\OrderShipmentController::class, 'index']);
Route::post('/ordership', [\App\Http\Controllers\OrderShipmentController::class, 'store'])->name('order.ship');


//dd(User::with('orders')->get()->toArray());
//dd(request()->method());

