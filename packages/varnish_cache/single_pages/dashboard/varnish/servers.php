<? defined('C5_EXECUTE') or die(_("Access Denied."));
$h = Loader::helper('concrete/dashboard');
$f = Loader::helper('form');
$p = Package::getByHandle('varnish_cache');
$delete_token = Loader::helper('validation/token')->generate('delete_varnish_server');
print $h->getDashboardPaneHeaderWrapper(t('Varnish Server Settings'), false, 'span8 offset2', false);
?>


<div class="ccm-pane-body">
	<fieldset>
		<legend><?=t('Configured Servers')?></legend>
		<?if (count($servers)) {
			foreach($servers as $server) {?>
				<div class="well clearfix">
					<ul class="span4 unstyled">
						<li>
						<strong>
						<?= t("%s (%s : %s)",
								strlen($server->serverName) ? $server->serverName : t('Unnamed'),
								$server->ipAddress,
								$server->port)
								?>
						</strong>
						</li>
						<li>
							<?= t("Terminal Key: %s",strlen($server->terminalKey) ? "'{$server->terminalKey}'" : t('None set'));?>
						</li>
						<li>
							<?= t("Statistics Proxy URL: %s",strlen($server->statsProxyURL) ? $server->statsProxyURL : t('None set'));?>
						</li>
					</ul>
					<div class="btn-group pull-right">
						<a href="<?=View::url('/dashboard/varnish/server_details',$server->serverID)?>" class="btn"><?=t('Details')?></a>
					</div>
				</div>
			<?}?>
		<?} else {?>
			<div class="alert alert-info"><?=t('You have not yet added any Varnish servers.');?></div>
		<? } ?>
		<a href="<?=View::url('/dashboard/varnish/add_edit_server')?>" class="btn btn-primary pull-right"><?=t('New Server')?></a>
	</fieldset>
<? /*
	<fieldset>
		<legend><?=t('Test Connection')?></legend>

		<h4><?=t('Management Console')?></h4>

		<?
		foreach ($servers as $server) {

			$s = $cache->getVarnishAdminSocket($server);
				//foreach sockets as s {
			try {
				 @$s->connect(1);
				 ?>
					<div class="alert alert-success"><?=t('Successfully connected to control terminal for %s.', strlen($server['serverName']) ? $server['serverName']:$server['ipAddress'])?></div>
					<?
			} catch(Exception $e) { ?>
				<div class="alert alert-error"><?=$e->getMessage()?></div>
			<? }
		} ?>
	

		<h4><?=t('Statistics')?></h4>

		<?
		//TODO : add statistics check
		//if strlen statsURL >>> this stuff, otherwise "No url set for servnername"
		foreach($servers as $server) {
			if (strlen($server['statsProxyURL'])) {
				$statistics = VarnishStatistics::get($server);
				if (is_object($statistics)) { ?>
					<div class="alert alert-success"><?=t('Successfully connected to Varnish statistics for %s.', strlen($server['serverName']) ? $server['serverName']:$server['ipAddress'])?></div>
				<? } else { ?>
					<div class="alert alert-error"><?=t('Unable to retrieve statistics for %s.',strlen($server['serverName']) ? $server['serverName']:$server['ipAddress'])?></div>
				<? }
			} else { ?>
				<div class="alert alert-info"><?=t('No statistics URL set for %s.',strlen($server['serverName']) ? $server['serverName']:$server['ipAddress'])?></div>
			<?}
		}?>

	</fieldset>
	*/ ?>
</div>
<div class="ccm-pane-footer">
</div>

<?
print $h->getDashboardPaneFooterWrapper(false);
?>
