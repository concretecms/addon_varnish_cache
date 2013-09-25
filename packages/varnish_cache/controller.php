<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));

class VarnishCachePackage extends Package {
   
    protected $pkgHandle = 'varnish_cache';
    protected $appVersionRequired = '5.6.1a1';
    protected $pkgVersion = '0.8.3dev';

    public function getPackageDescription() {
        return t('Adds administrative hooks into Varnish and provides a concrete5 full page caching library for it.');
    }

    public function getPackageName() {
        return t('Varnish Cache');
    }

    public function on_start() {
        $classes = array(
            'DashboardVarnishBaseController' => array('library', '/dashboard/controller', 'varnish_cache'),
            'VarnishStatisticRecord' => array('library', 'varnish/statistic_record', 'varnish_cache'),
            'VarnishStatistics' => array('library', 'varnish/statistics', 'varnish_cache')
        );
        Loader::registerAutoload($classes);
    }


    public function install() {
        $pkg = parent::install();
        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/install.xml');
    }

    public function upgrade() {
        $pkg = Package::getByHandle('varnish_cache');
        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/install.xml');
		
		//@TODO change settings to servers
		
    }
    
}
