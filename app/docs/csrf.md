# Cross-site request forgery

Laravel automatically generates a CSRF "token" for
each active user session managed by the application.

This token is used to verify that the authenticated user is the person actually 
making the requests to the application. 
Since this token is stored in the user's session and changes each time the session is regenerated,
a malicious application is unable to access it.
