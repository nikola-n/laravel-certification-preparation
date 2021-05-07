# Requests

### Retrieving The Request Path

The path method returns the request's path information. So, if the incoming request is
targeted at http://example.com/foo/bar, the path method will return foo/bar:

$uri = $request->path();

### Inspecting The Request Path / Route

for typed url
The is method allows you to verify that the incoming request path matches a given pattern. 
You may use the * character as a wildcard when utilizing this method:
if ($request->is('admin/*')) {
//
}
for named route
Using the routeIs method, you may determine if the incoming request has matched a named route:

if ($request->routeIs('admin.*')) {
//
}

### Retrieving The Request URL

To retrieve the full URL for the incoming request you may use the url or fullUrl methods. 
The url method will return the URL without the query string, while the fullUrl 
method includes the query string:

http://example.com/foo/bar?query=nick

$url = $request->url(); http://example.com/foo/bar

$urlWithQueryString = $request->fullUrl(); http://example.com/foo/bar?query=nick

If you want to append query string data to the current url
$request->fullUrlWithQuery(['type' => 'phone']); http://example.com/foo/bar?query=nick&type=phone

### Retrieving The Request Method
Returns the http verb.
$method = $request->method();

for verification
if ($request->isMethod('post')) {
//
}

# Request Headers

Retrieves the header, if it's not present on the request gives null
$value = $request->header('X-Header-Name');

if it's not present you can add default value
$value = $request->header('X-Header-Name', 'default');

checks if contains given header
if ($request->hasHeader('X-Header-Name')) {
//
}

retrieves the token, if authorization header is not present empty string is returned
$token = $request->bearerToken();

# Request IP Address

retrieves ip address of the client that made a request
$ipAddress = $request->ip();

# Content Negotiation

Returns array of all acceptable content types by the request
$contentTypes = $request->getAcceptableContentTypes();

returns true or false 
if ($request->accepts(['text/html', 'application/json'])) {
// ...
}

specify which is preffered content type to be present, if it's not null is given.
$preferred = $request->prefers(['text/html', 'application/json']);


Since many applications only serve HTML or JSON, you may use the expectsJson method 
to quickly determine if the incoming request expects a JSON response:

if ($request->expectsJson()) {
// ...
}


# Retrieving input

You may pass a default value as the second argument to the input method.
This value will be returned if the requested input value is not present on the request:

$name = $request->input('name', 'Sally');

When working with forms that contain array inputs, use "dot" notation to access
the arrays:

$name = $request->input('products.0.name');

$names = $request->input('products.*.name');

You may call the input method without any arguments in order to retrieve 
all of the input values as an associative array:

$input = $request->input();

# Retrieving Input From The Query String

While the input method retrieves values from the entire request payload (including the query string), 
the query method will only retrieve values from the query string:

$name = $request->query('name');

# Retrieving JSON Input Values

When sending JSON requests to your application, you may access the JSON data via 
the input method as long as the Content-Type header of the request is properly set 
to application/json. You may even use "dot" syntax to retrieve values that are 
nested within JSON arrays:

$name = $request->input('user.name');

# Retrieving A Portion Of The Input Data (only, except)

The only method returns all of the key / value pairs that you request; however,
it will not return key / value pairs that are not present on the request.

# Determining If Input Is Present

- has
- has(['one','two']) - checks both
- whenHas

The whenHas method will execute the given closure if a value is present on the request:

$request->whenHas('name', function ($input) {
//
});


- hasAny 

The hasAny method returns true if any of the specified values are present:
if ($request->hasAny(['name', 'email'])) {
//
}

- filled

If you would like to determine if a value is present on the request and is not empty,
you may use the filled method:

if ($request->filled('name')) {
//
}

- whenFilled

The whenFilled method will execute the given closure if a value is present on the request and is not empty:

$request->whenFilled('name', function ($input) {
//
});

- missing 

To determine if a given key is absent from the request, you may use the missing method:

if ($request->missing('name')) {
//
}


# Flashing Input To The Session

The flash method on the Illuminate\Http\Request class will flash the current input to
the session so that it is available during the user's next request to the application:

$request->flash();

You may also use the flashOnly and flashExcept methods to flash a subset of the
request data to the session. These methods are useful for keeping sensitive 
information such as passwords out of the session:

$request->flashOnly(['username', 'email']);

$request->flashExcept('password');

# Flashing Input Then Redirecting

Since you often will want to flash input to the session and then redirect to the 
previous page, you may easily chain input flashing onto a redirect using the 
withInput method:

return redirect('form')->withInput();

return redirect()->route('user.create')->withInput();

return redirect('form')->withInput(
$request->except('password')
);

# Retrieving Old Input

To retrieve flashed input from the previous request

$username = $request->old('username');


# Retrieving Cookies From Requests

All cookies created by the Laravel framework are encrypted and signed with an 
authentication code, meaning they will be considered invalid if they have been 
changed by the client. To retrieve a cookie value from the request, use the cookie 
method on an Illuminate\Http\Request instance:

$value = $request->cookie('name');

# Retrieving Uploaded Files
You may determine if a file is present on the request using the hasFile method:

if ($request->hasFile('photo')) {
//
}

# Validating Successful Uploads

In addition to checking if the file is present, you may verify that there were no 
problems uploading the file via the isValid method:

if ($request->file('photo')->isValid()) {
//
}

# File Paths & Extensions

The UploadedFile class also contains methods for accessing the file's fully-qualified 
path and its extension. The extension method will attempt to guess the file's extension
based on its contents. This extension may be different from the extension that was 
supplied by the client:

$path = $request->photo->path();

$extension = $request->photo->extension();

# Storing files

$path = $request->photo->store('images', 's3');

If you do not want a filename to be automatically generated, you may use the storeAs
method, which accepts the path, filename, and disk name as its arguments:

$path = $request->photo->storeAs('images', 'filename.jpg');

$path = $request->photo->storeAs('images', 'filename.jpg', 's3');

# Laravel 8 new - Configuring Trusted Proxies

When running your applications behind a load balancer that terminates TLS / SSL 
certificates, you may notice your application sometimes does not generate HTTPS links 
when using the url helper. Typically this is because your application is being forwarded
traffic from your load balancer on port 80 and does not know it should generate secure
links.

To solve this, you may use the App\Http\Middleware\TrustProxies middleware that is 
included in your Laravel application, which allows you to quickly customize the load 
balancers or proxies that should be trusted by your application. Your trusted proxies 
should be listed as an array on the $proxies property of this middleware. In addition to
configuring the trusted proxies, you may configure the proxy $headers that should be 
trusted:
protected $proxies = [
'192.168.1.1',
'192.168.1.2',
'*'
];
