# Installation Notes

## Requirements

1. A server running Varnish 3.x. and management console enabled.
2. PHP with sockets enabled.
3. Add this to config/autoload.php in your site's config directory:

	<?php
	$classes = array(
		'VarnishPageCache' => array('library', 'page_cache/types/varnish', 'varnish_cache'),
	);
	Loader::registerAutoload($classes);
	
4. Add this to your config/site.php file:

	define('PAGE_CACHE_LIBRARY', 'varnish');
	define('VARNISH_CACHE_VERSION', 'version'); // e.g. 3.0.2
	
5. Copy /scripts/varnishstats.xml.php to your Varnish server. Make sure it is accessible somewhere. Make sure it is pointing to the right binary in the script itself.
