<? defined('C5_EXECUTE') or die(_("Access Denied."));
$h = Loader::helper('concrete/dashboard');
$f = Loader::helper('form');
$p = Package::getByHandle('varnish_cache');
print $h->getDashboardPaneHeaderWrapper(t('Varnish Server Settings'), false, 'span8 offset2', false);
?>

<form method="post" action="<?=$this->action('save')?>" class="form-horizontal">

<div class="ccm-pane-body">
	<fieldset>
		<legend><?=t('Control Terminal')?></legend>
		<div class="control-group">
			<?=$f->label('VARNISH_CONTROL_TERMINAL_HOST', t('Host'))?>
			<div class="controls">
				<?=$f->text('VARNISH_CONTROL_TERMINAL_HOST', $p->config('VARNISH_CONTROL_TERMINAL_HOST'), array('placeholder' => '127.0.0.1'))?>
			</div>
		</div>
		<div class="control-group">
			<?=$f->label('VARNISH_CONTROL_TERMINAL_PORT', t('Port'))?>
			<div class="controls">
				<?=$f->text('VARNISH_CONTROL_TERMINAL_PORT', $p->config('VARNISH_CONTROL_TERMINAL_PORT'), array('placeholder' => '6082'))?>
			</div>
		</div>
		<div class="control-group">
			<?=$f->label('VARNISH_CONTROL_TERMINAL_KEY', t('Key'))?>
			<div class="controls">
				<?=$f->text('VARNISH_CONTROL_TERMINAL_KEY', $p->config('VARNISH_CONTROL_TERMINAL_KEY'))?>
				<a href="#" class="launch-tooltip" title="<?=t('Enter your optional control terminal key here, if you have defined one.')?>"><i class="icon-question-sign"></i></a>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend><?=t('Statistics Proxy')?></legend>
		<div class="control-group">
			<?=$f->label('VARNISH_VARNISHSTATS_PROXY_URL', t('Proxy URL'))?>
			<div class="controls">
				<?=$f->text('VARNISH_VARNISHSTATS_PROXY_URL', $p->config('VARNISH_VARNISHSTATS_PROXY_URL'))?>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend><?=t('Test Connection')?></legend>

		<h4><?=t('Management Console')?></h4>

		<? 
		$s = $cache->getVarnishAdminSocket();
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
	<button type="submit" class="btn btn-primary pull-right"><?=t('Save')?></button>
</div>
</form>

<?
print $h->getDashboardPaneFooterWrapper(false);
?>