At its core, Laravel's authentication facilities are made up of "guards" and "providers". 

Guards define how users are authenticated for each request. For example, Laravel ships 
with a session guard which maintains state using session storage and cookies.

Providers define how users are retrieved from your persistent storage. Laravel ships 
with support for retrieving users using Eloquent and the database query builder. 

# How it works

When using a web browser, a user will provide their username and password via a login form.
If these credentials are correct, the application will store information about the 
authenticated user in the user's session. A cookie issued to the browser contains the 
session ID so that subsequent requests to the application can associate the user with the 
correct session. After the session cookie is received, the application will retrieve the 
session data based on the session ID, note that the authentication information has been 
stored in the session, and will consider the user as "authenticated".

- Auth::user(), Auth::id(), $request->user(), Auth::check()

## Specifying A Guard

When attaching the auth middleware to a route, you may also specify which "guard" 
should be used to authenticate the user. The guard specified should correspond to
one of the keys in the guards array of your auth.php configuration file:

Route::get('/flights', function () {
// Only authenticated users may access this route...
})->middleware('auth:admin');

# Manually Authenticating Users

The attempt method is normally used to handle authentication attempt's from
your application's "login" form. If authentication is successful, you should 
regenerate the user's session to prevent session fixation:

The intended method provided by Laravel's redirector
will redirect the user to the URL they were attempting to access before being intercepted by the authentication middleware. A fallback URI may be given to this method in case the intended destination is not available.

# Accessing Specific Guard Instances

Via the Auth facade's guard method, you may specify which guard instance you would like 
to utilize when authenticating the user. This allows you to manage authentication for 
separate parts of your application using entirely separate 
authenticatable models or user tables.

The guard name passed to the guard method should correspond to one of the guards 
configured in your auth.php configuration file:

if (Auth::guard('admin')->attempt($credentials)) {
// ...
}
