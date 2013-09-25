<? defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardVarnishStatisticsController extends DashboardVarnishBaseController {

	public function view() {
		Loader::model('varnish_servers','varnish_cache');
		$servers = VarnishServers::get();
		foreach($servers as $server) {
			$statistics = VarnishStatistics::get($server);
			if(is_object($statistics)) {
				$statsChunk['stats'] = $statistics;
			} else {
				$statsChunk['stats'] = false;
			}
			$statsChunk['server'] = strlen($server['serverName']) ? $server['serverName'] : $server['ipAddress'];
			$statisticsInfo[] = $statsChunk;
		}
		$this->set('statisticsInfo',$statisticsInfo);
	}
}
