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

