<?defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardVarnishAddEditServerController extends DashboardBaseController {
	public function save() {
		$e = Loader::helper('validation/error');
		$required = array(
					'ipAddress',
					'port'
			);
		foreach($required as $setting) {
			if (!strlen($this->post($setting))) {
				$e->add(t('a server needs at least an IP address and port.'));
				$this->set('error',$e);
				break;
			}
		}
		if(!$e->has()) {
			Loader::model('varnish_servers','varnish_cache');
			VarnishServers::save($this->post());
			$this->redirect('/dashboard/varnish/settings/');
		}
	}

	public function view($serverID=null) {
		$e = Loader::helper('validation/error');
		if (is_numeric($serverID)) {
			Loader::model('varnish_servers','varnish_cache');
			$data = VarnishServers::getByID($serverID);
			if(is_array($data) && count($data)) {
				$this->set('data',$data);
				$this->set('newServer',false);
			} else {
				$e->add(t('Not a valid entry'));
				$this->set('error',$e);
				$this->set('newServer',true);
			}
		} else {
			$this->set('newServer',true);
		}
	}
}
