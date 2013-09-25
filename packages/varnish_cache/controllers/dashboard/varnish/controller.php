<? defined('C5_EXECUTE') or die(_("Access Denied."));


class DashboardVarnishController extends DashboardVarnishBaseController {

	public function view() {
		$this->redirect('/dashboard/varnish/server_configuration');
	}
	
}