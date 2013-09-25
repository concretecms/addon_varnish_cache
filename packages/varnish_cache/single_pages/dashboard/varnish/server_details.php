<? defined('C5_EXECUTE') or die(_("Access Denied."));
$h = Loader::helper('concrete/dashboard');
$f = Loader::helper('form');
$p = Package::getByHandle('varnish_cache');
$delete_token = Loader::helper('validation/token')->generate('delete_varnish_server');
print $h->getDashboardPaneHeaderWrapper(t('Varnish Server Details'), false, 'span8 offset2', false);
?>


<div class="ccm-pane-body">
	<fieldset>
		<legend><?=t('Server Info')?></legend>
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
					<a href="<?=View::url('/dashboard/varnish/add_edit_server',$server->serverID)?>" class="btn btn-primary"><?=t('Edit')?></a>
					<a href="<?=View::url('/dashboard/varnish/servers/delete/',$server->serverID,$delete_token)?>" class="btn btn-danger"><?=t('Delete')?></a>
				</div>
			</div>
			
		
	</fieldset>

	<fieldset>
		<legend><?=t('Status')?></legend>

		<h4><?=t('Management Console')?></h4>

		<?
		
		$s = $server->getSocket();

		try {
			 @$s->connect(1);
			 ?>
				<div class="alert alert-success"><?=t('Successfully connected to control terminal for %s.', strlen($server->serverName) ? $server->serverName:$server->ipAddress)?></div>
				<?
		} catch(Exception $e) { ?>
			<div class="alert alert-error"><?=$e->getMessage()?></div>
		<? } ?>
	

		<h4><?=t('Statistics')?></h4>

		<?
		if (strlen($server->statsProxyURL)) {
			$statistics = VarnishStatistics::get($server);
			if (is_object($statistics)) { ?>
				<div class="alert alert-success"><?=t('Successfully connected to Varnish statistics for %s.', strlen($server['serverName']) ? $server['serverName']:$server['ipAddress'])?></div>
			<? } else { ?>
				<div class="alert alert-error"><?=t('Unable to retrieve statistics for %s.',strlen($server['serverName']) ? $server['serverName']:$server['ipAddress'])?></div>
			<? }
		} else { ?>
			<div class="alert alert-info"><?=t('No statistics URL set for %s.',strlen($server->serverName) ? $server->serverName:$server->ipAddress)?></div>
		<? } ?>
		
		<h4><?=t('Start / Stop Server')?></h4>
		

	</fieldset>

	<fieldset>
		<legend><?=t('Server Configuration')?></legend>
		<h4><?=t('Active Configuration')?></h4>
		<div class="well">
			<?php
			if($activeConfiguration) {
				echo $activeConfiguration->getVarnishConfigurationName();
			} else {
				echo t('No configuration set');	
			}
			?>
			<div class="btn-group pull-right">
					<a href="<?=View::url('/dashboard/varnish/server_configuration',$server->serverID)?>" class="btn btn-primary"><?=t('Edit Configuration')?></a>
			</div>
		</div>
	</fieldset>
</div>
<div class="ccm-pane-footer">
</div>

<?
print $h->getDashboardPaneFooterWrapper(false);
?>
