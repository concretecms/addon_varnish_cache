<? defined('C5_EXECUTE') or die(_("Access Denied."));


class DashboardVarnishRestartController extends DashboardVarnishBaseController {

	public function submit() {
		$s = $this->cache->getVarnishAdminSocket();
		$s->connect(1);
		if ($this->post('start')) {
			$s->start();
			$this->redirect('/dashboard/varnish/restart');
		}
		if ($this->post('stop')) {
			$s->stop();
			$this->redirect('/dashboard/varnish/restart');
		}
	}


}