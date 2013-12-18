## This is a basic VCL configuration file for varnish.  See the vcl(7)
## man page for details on VCL syntax and semantics.


## Default backend definition.  Set this to point to your content
## server.

backend web1 {
    .host = "concrete5";
    .port = "8080";
    .probe = {
         .url = "/index.php/tools/poll";
         .interval = 10s;
         .timeout = 1s;
         .window = 5;
         .threshold = 2;
    }
}



## If you redefine any of these subroutines, the built-in logic will be
## appended to your code.

sub vcl_recv {

    ## This sets the host header for your site - you should set this  
    ## because varnish takes host into consideration when caching.
    ## IE - www.foo.com and foo.com will be treated as separate by the cache
    set req.http.host = "concrete5";
    
    ## set the backend to the Catalyst site
    set req.backend = web1;

    if (req.backend.healthy) {
        set req.grace = 15s;
    } else {
        set req.grace = 4h;
    }

    if (req.url ~ "^/login" || req.url ~ "^/dashboard"  || req.url ~ "^/!") {
       set req.url = "/page_not_found/";
    }

    ## this is an example of switching betwen backends based on path
    #if ( req.url ~ "^/static-test") {
    #    set req.backend = staticsite;
    #    set req.http.host = "mystaticsite.com";
    #}

    ## Force lookup if the request is a no-cache request from the client
    ## IE - shift-reload causes cache refresh - We may not want this in 
    ## production but useful during initial deployment and testing
    if (req.http.Cache-Control ~ "no-cache") {
        ban(req.url);
    }
    
    ## Cache based on file path - if it's in /static/, it probably 
    ## doesn't change much.
    # if (req.request == "GET" && req.url ~ "^/static/") {
    #    unset req.http.cookie;
    #    unset req.http.authorization;
    #    lookup;
    #}

    ## If your app has a less predictable layout - you can instead
    ## cache based on file extension - be sure to update vcl_fetch
    ## if you use this method.
    if (req.request == "GET" && req.url ~ "\.(gif|jpg|swf|css|js|png|jpg|jpeg|gif|png|tiff|tif|svg|swf|ico|css|js|vsd|doc|ppt|pps|xls|mp3|mp4|m4a|ogg|mov|avi|wmv|sxw|zip|gz|bz2|tgz|tar|rar|odc|odb|odf|odg|odi|odp|ods|odt|sxc|sxd|sxi|sxw|dmg|torrent|deb|msi|iso|rpm)$") {
        unset req.http.cookie;
        unset req.http.authorization;
        return(lookup);
    }

    ## Chances are that if we are receiving POST data, we don't want to cache 
    ## so we short circuit it here.
    if (req.request == "POST") {
        return(pass);
    }

    ## any unusual requests are passed through.
    if (req.request != "GET" &&
      req.request != "HEAD" &&
      req.request != "PUT" &&
      req.request != "POST" &&
      req.request != "TRACE" &&
      req.request != "OPTIONS" &&
      req.request != "DELETE") {
        # Non-RFC2616 or CONNECT which is weird. #
        return(pass);
    }

    ## if we have an authorization header, we definitely do not want to 
    ## cache 
    if (req.http.Authorization) {
        # Not cacheable by default #
        return(pass);
    }
      return(lookup);
}

sub vcl_fetch {

    #if (req.request == "GET" && req.url ~ "^/static" ) {

    #   unset obj.http.cookie;

        ## We want to force a 30 minute timeout for static content so we
        ## set obj.ttl. If we do not set obj.ttl, though, it would default 
        ## to the varnish default, or the cache-control header if present. 
    #   set obj.ttl = 30m;

    #    deliver;
    #}
    
    set beresp.grace = 4h;

    if (req.request == "GET" && 
        req.url ~ "\.(gif|jpg|swf|css|js|png|jpg|jpeg|gif|png|tiff|tif|svg|swf|ico|css|js|vsd|doc|ppt|pps|xls|mp3|mp4|m4a|ogg|mov|avi|wmv|sxw|zip|gz|bz2|tgz|tar|rar|odc|odb|odf|odg|odi|odp|ods|odt|sxc|sxd|sxi|sxw|dmg|torrent|deb|msi|iso|rpm)$" ) {
            unset beresp.http.cookie;
            return(deliver);
        }

    ## Don't cache anything that is not a 20x response.  We don't want 
    ## to cache errors.  If you want to cache redirects, you 
    ## can set this to be higher than 300 (temporary redirects are 302)
    if (beresp.status >= 300) {
        return(hit_for_pass);
    }

    ## if the object was trying to set a cookie, 
    ## it probably shouldn't be cached.
    # if (beresp.http.cookie) {
    #    return(hit_for_pass);
    # }
    
     ## if the object is specifically saying 'don't cache me' -  
     ## obey it.
     if(beresp.http.Pragma ~ "no-cache" ||  
        beresp.http.Cache-Control ~ "no-cache" || 
        beresp.http.Cache-Control ~ "private")  {       
        return(hit_for_pass);
    } 
    
    ## if the object is saying how long to cache it, you 
    ## can rely on the fact that it is cachable. 
    if (beresp.http.Cache-Control ~ "max-age") {
        unset beresp.http.cookie;
        return(deliver);
    }
    return(hit_for_pass);
}

## If you want a specific error response - you can define it here.
#sub vcl_error {
#    set obj.http.Content-Type = "text/html; charset=utf-8";
#    synthetic {"
#<?xml version="1.0" encoding="utf-8"?>
#<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
# "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
#<html>
#  <head>
#    <title>"} obj.status " " obj.response {"</title>
#  </head>
#  <body>
#    <h1>Error "} obj.status " " obj.response {"</h1>
#    <p>"} obj.response {"</p>
#    <h3>Guru Meditation:</h3>
#    <p>XID: "} req.xid {"</p>
#    <address><a href="http://www.varnish-cache.org/">Varnish</a></address>
#  </body>
#</html>
#"};
#    deliver;
#}