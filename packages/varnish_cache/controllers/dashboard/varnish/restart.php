<? defined('C5_EXECUTE') or die(_("Access Denied."));


class DashboardVarnishRestartController extends DashboardVarnishBaseController {

	public function submit() {
		Loader::model('varnish_servers','varnish_cache');
		$servers = VarnishServers::get();
		if ($this->post('start')) {
			foreach($servers as $server) {
				$s = $this->cache->getVarnishAdminSocket($server);
				$s->connect(1);
				$s->start();
			}
			$this->redirect('/dashboard/varnish/restart');
		}
		if ($this->post('stop')) {
			foreach($servers as $server) {
				$s = $this->cache->getVarnishAdminSocket($server);
				$s->connect(1);
				$s->stop();
			}
			$this->redirect('/dashboard/varnish/restart');
		}
	}

}
