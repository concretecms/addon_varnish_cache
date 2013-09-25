<? defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardVarnishStatisticsController extends DashboardVarnishBaseController {

	public function view($serverID = NULL) {
		Loader::model('varnish_servers','varnish_cache');
		$serverList = new VarnishServerList();
		$servers = $serverList->get();
		
		foreach($servers as $key=>$server) {
			$statistics = VarnishStatistics::get($server);
			if(is_object($statistics)) {
				$statisticsInfo[$key]['stats'] = $statistics;
			} else {
				$statisticsInfo[$key]['stats'] = false;
			}
			$statisticsInfo[$key]['server'] = strlen($server->serverName) ? $server->serverName : $serve->ipAddress;
		}
		$this->set('statisticsInfo',$statisticsInfo);
	}
}
