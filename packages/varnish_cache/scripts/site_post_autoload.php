<?php
$classes = array(
    'VarnishPageCache' => array('library', 'page_cache/types/varnish', 'varnish_cache'),
    'VarnishConfiguration' => array('library', 'varnish/configuration', 'varnish_cache'),
);
Loader::registerAutoload($classes);

VarnishConfiguration::register('concrete5 Varnish', 'This is your standard concrete5 Varnish configuration file.', 'concrete5', 'concrete5.vcl');
VarnishConfiguration::register('Maintenance', 'Enable this file to put your site into full Varnish-enabled maintenance mode.', 'maintenance', 'maintenance.vcl');