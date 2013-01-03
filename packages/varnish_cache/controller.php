<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));

class VarnishCachePackage extends Package {
    protected $pkgHandle = 'varnish_cache';
    protected $appVersionRequired = '5.6.1a1';
    protected $pkgVersion         = '0.8.0';

    public function getPackageDescription() {
        return t('Adds administrative hooks into Varnish and provides a concrete5 full page caching library for it.');
    }

    public function getPackageName() {
        return t('Varnish Cache');
    }


    public function on_start() {

    }
   
    public function install() {
        $pkg = parent::install();
    }
    
}