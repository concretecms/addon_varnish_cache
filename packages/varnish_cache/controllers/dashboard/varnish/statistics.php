<? defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardVarnishStatisticsController extends DashboardVarnishBaseController {

	public function view() {
		$statistics = VarnishStatistics::get();
		$this->set('statistics', $statistics);
	}

}