<? defined('C5_EXECUTE') or die(_("Access Denied."));


class DashboardVarnishServerConfigurationController extends DashboardVarnishBaseController {

	public function view() {
		$configuration = VarnishConfiguration::getList();
		$this->set('configuration', $configuration);
	}

	public function configuration_switched() {
		$this->set('message', t("Varnish configuration updated."));
		$this->view();
	}
	
	public function save_configuration() {
		$confHandle = $this->post('configuration');
		try {
			$conf = VarnishConfiguration::getByHandle($confHandle);
			$conf->enable();
			$this->redirect('/dashboard/varnish/server_configuration', 'configuration_switched');
		} catch(Exception $e) {
			$this->error->add($e->getMessage());
		}
		$this->view();

	}

}