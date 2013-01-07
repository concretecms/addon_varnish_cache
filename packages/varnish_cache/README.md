# Installation Notes

## Requirements

1. A server running Varnish 3.x. and management console enabled.
2. PHP with sockets enabled.
3. Copy scripts/etc/varnish/ into the /etc/varnish/ directory on your Varnish server. This directory might be /opt/local/etc/varnish, or somewhere else.
4. Copy scripts/site\_post\_autoload.php into config/. Make any changes to the config to match any new or updated Varnish config files in etc/varnish/
5. Add this to your config/site.php file:

	define('PAGE_CACHE_LIBRARY', 'varnish');
	define('VARNISH_CACHE_VERSION', 'version'); // e.g. 3.0.2
	
6. Copy /scripts/varnishstats.xml.php to your Varnish server. Make sure it is accessible somewhere. Make sure it is pointing to the right binary in the script itself. This script is optional.
7. Start Varnish with a command similar to this one:

	sudo varnishd -a your.server.com:80 -T 127.0.0.1:6082 -s file,/tmp,500M
	
You can also start varnishd with a secret key file if you'd like.

8. Add the relevant admin host information to your server
9. Enable the concrete5 Varnish config file in Dashboard > Varnish > Configuration
10. Start Varnish via the dashboard.