<? defined('C5_EXECUTE') or die(_("Access Denied."));
$h = Loader::helper('concrete/dashboard');
$f = Loader::helper('form');
$p = Package::getByHandle('varnish_cache');
print $h->getDashboardPaneHeaderWrapper(t('Varnish Server Settings'), false, 'span8 offset2', false);
?>


<div class="ccm-pane-body">
	<fieldset>
		<legend><?=t('Configured Servers')?></legend>
		<?if (count($servers)) {
			foreach($servers as $server) {?>
				<div class="something-nice">
					<?=t("%s (%s:%s), Terminal Key: %s",
						strlen($server['serverName']) ? $server['serverName'] : t('Unnamed'),
						$server['ipAddress'],
						$server['port'],
						strlen($server['terminalKey']) ? "'{$server['terminalKey']}'" : t('None set'));
					//button edit
					//button delete
					?>
				</div>
			<?}?>
		<?} else {?>
			<div class="alert alert-info"><?=t('You have not yet added any Varnish servers.');?></div>
		<?}
			//add button ?>
	</fieldset>

	<fieldset>
		<legend><?=t('Test Connection')?></legend>

		<h4><?=t('Management Console')?></h4>

		<? 
		$s = $cache->getVarnishAdminSocket();
			//foreach sockets as s {
		try {
		    @$s->connect(1);
		    ?>
				<div class="alert alert-success"><?=t('Successfully connected to control terminal.')?></div>
				<?
		} catch(Exception $e) { ?>
			<div class="alert alert-error"><?=$e->getMessage()?></div>
		<? } ?>
	

		<h4><?=t('Statistics')?></h4>

		<? 
		$statistics = VarnishStatistics::get();
		if (is_object($statistics)) { ?>
			<div class="alert alert-success"><?=t('Successfully connected to Varnish statistics.')?></div>
		<? } else { ?>
			<div class="alert alert-error"><?=t('Unable to retrieve statistics from URL.')?></div>
		<? } ?>

	</fieldset>

</div>
<div class="ccm-pane-footer">
</div>

<?
print $h->getDashboardPaneFooterWrapper(false);
?>
