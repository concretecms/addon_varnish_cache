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
7. Copy /scripts/tools/poll.php to tools/poll.php and make sure that it is accessible through yoursite.com/index.php/tools/poll/
8. Start Varnish with a command similar to this one:

	sudo varnishd -a your.server.com:80 -T 127.0.0.1:6082 -s file,/tmp,500M
	
or

	sudo varnishd -a your.server.com:80 -T 127.0.0.1:6082 -S /opt/local/etc/varnish/secret_key -s file,/tmp,500M

9. Add the relevant admin host information to your server
10. Enable the concrete5 Varnish config file in Dashboard > Varnish > Configuration
11. Start Varnish via the dashboard.