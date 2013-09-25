<? defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardVarnishServerDetailsController extends DashboardBaseController {
	// note can't extend settings because we might have an infinite redirect

	public function view($serverID = NULL) {
		Loader::model('varnish_servers','varnish_cache');
		
		$server = VarnishServer::getByID($serverID);
		if(!$server) {
			$this->redirect('/dashboard/varnish/servers');
		}
		
		$configuration = VarnishConfiguration::getList();
		foreach($configuration as $conf) {
			if($conf->isVarnishConfigurationFileActive($server)) {
				$activeConfiguration = $conf;
				break;
			}
		}
		
		$this->set('server',$server);
		$this->set('activeConfiguration', $activeConfiguration);
	}
	

}
