<?php defined('C5_EXECUTE') or die("Access Denied.");

class VarnishPageCache extends PageCache {

	//this needs to be changed to be per-server.
	//we can probably just pass in a serverID.
	public function getVarnishAdminSocket(VarnishServer $server) {
		return $server->getAdminSocket();
	}

	public function getRecord($mixed) {
		$ur = new UnknownPageCacheRecord();
		return $ur;
	}

	/**
	 * functionality not supported by varnish
	*/
	public function purgeByRecord(PageCacheRecord $rec) { }
	

	/**
	 * Flushes cache for all servers
	 * @return void
	*/ 
	public function flush() {
		Loader::model('varnish_servers','varnish_cache');
		$sl = new VarnishServerList();
		$servers = $sl->get();
		foreach($servers as $s) {
			$s->flush();
		}
	}

	
	/**
	 * Flushes cache for a page on all varnish servres
	 * @param Page $c
	 * @return void
	*/
	public function purge(Page $c) {
		Loader::model('varnish_servers','varnish_cache');
		$sl = new VarnishServerList();
		$servers = $sl->get();
		foreach($servers as $s) {
			$s->purgeURL($c->getCollectionPath());
		}
	}

	/**
	 * functionality not supported by varnish
	*/
	public function set(Page $c, $content) {}

}
