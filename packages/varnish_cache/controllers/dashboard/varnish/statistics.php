<? defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardVarnishStatisticsController extends DashboardVarnishBaseController {

	public function view() {
		Loader::model('varnish_servers','varnish_cache');
		$servers = VarnishServers::get();
		foreach($servers as $server) {
			$statistics = VarnishStatistics::get($server);
			if(is_object($statistics)) {
				$statisticsInfo[]['stats'] = $statistics;
			} else {
				$statisticsInfo[]['stats'] = false;
			}
			$statisticsInfo[]['server'] = strlen($server['serverName']) ? $server['serverName'] : $server['ipAddress'];
		}
		$this->set('statisticsInfo',$statisticsInfo);
	}
}
