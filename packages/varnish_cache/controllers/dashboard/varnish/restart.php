<? defined('C5_EXECUTE') or die(_("Access Denied."));


class DashboardVarnishRestartController extends DashboardVarnishBaseController {

	public function submit() {
			
		Loader::model('varnish_servers','varnish_cache');
		$server = VarnishServer::getByID($this->post('serverID'));
		
		if(!$server) {
			$this->redirect('/dashboard/varnish/servers');
		}
		
		if ($this->post('start')) {
			$s = $server->getSocket();
			$s->connect(1);
			$s->start();
			$this->redirect('/dashboard/varnish/restart',$server->serverID);
		}
		
		if ($this->post('stop')) {
			$s = $server->getSocket();
			$s->connect(1);
			$s->stop();
			$this->redirect('/dashboard/varnish/restart',$server->serverID);
		}
	}
	
	
	public function view($serverID) {
		Loader::model('varnish_servers','varnish_cache');
		$server = VarnishServer::getByID($serverID);
		if(!$server) {
			$this->redirect('/dashboard/varnish/servers');
		}
		$this->set('server',$server);
		$this->set('socket',$server->getSocket());
	}

}
