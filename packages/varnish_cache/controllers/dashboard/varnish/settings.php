<? defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardVarnishSettingsController extends DashboardVarnishBaseController {

	public function save() {

		$p = Package::getByHandle('varnish_cache');
		$p->saveConfig('VARNISH_CONTROL_TERMINAL_HOST', $this->post('VARNISH_CONTROL_TERMINAL_HOST'));
		$p->saveConfig('VARNISH_CONTROL_TERMINAL_PORT', $this->post('VARNISH_CONTROL_TERMINAL_PORT'));
		$p->saveConfig('VARNISH_CONTROL_TERMINAL_KEY', $this->post('VARNISH_CONTROL_TERMINAL_KEY'));		
		$p->saveConfig('VARNISH_VARNISHSTATS_PROXY_URL', $this->post('VARNISH_VARNISHSTATS_PROXY_URL'));
		$this->redirect('/dashboard/varnish/settings', 'saved');

	}

	public function saved() {
		$this->set('success', t('Varnish settings saved successfully.'));
	}

}