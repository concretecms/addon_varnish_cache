## This is a sample file that might handle an emergency situation.

## Default backend definition.  Set this to point to your content
## server.

backend web1 {
    .host = "concrete5";
    .port = "8080";
}

## If you redefine any of these subroutines, the built-in logic will be
## appended to your code.

sub vcl_recv {
   set req.url = "/maintenance/";
   return(lookup);
}

sub vcl_fetch {

    unset beresp.http.Cookie;
    return(deliver);

}
