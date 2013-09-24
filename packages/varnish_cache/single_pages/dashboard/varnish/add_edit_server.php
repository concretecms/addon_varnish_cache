<? defined('C5_EXECUTE') or die(_("Access Denied."));
$h = Loader::helper('concrete/dashboard');
$f = Loader::helper('form');
$p = Package::getByHandle('varnish_cache');
$paneTitle = $newServer ? t('Add A Varnish Server') : t('Edit Varnish Server Settings');
print $h->getDashboardPaneHeaderWrapper($paneTitle, false, 'span8 offset2', false);
//TODO make this work for an individual server. Add controller
?>

<form method="post" action="<?=$this->action('save')?>" class="form-horizontal">
<?if (!$newServer) {
	echo $f->hidden('serverID',$serverID);
} ?>

<div class="ccm-pane-body">
	<fieldset>
		<legend><?=t('Control Terminal')?></legend>
		<div class="control-group">
			<?=$f->label('serverName', t('Server Name'))?>
			<div class="controls">
				<?=$f->text('serverName', $data['serverName'], array('placeholder' => t('Optional')))?>
			</div>
		</div>
		<div class="control-group">
			<?=$f->label('ipAddress', t('Host'))?>
			<div class="controls">
				<?=$f->text('ipAddress', $data['ipAddress'], array('placeholder' => '127.0.0.1'))?>
			</div>
		</div>
		<div class="control-group">
			<?=$f->label('port', t('Port'))?>
			<div class="controls">
				<?=$f->text('port', $data['port'], array('placeholder' => '6082'))?>
			</div>
		</div>
		<div class="control-group">
			<?=$f->label('terminalKey', t('Key'))?>
			<div class="controls">
				<?=$f->text('terminalKey', $data['terminalKey'])?>
				<a href="#" class="launch-tooltip" title="<?=t('Enter your optional control terminal key here, if you have defined one.')?>"><i class="icon-question-sign"></i></a>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend><?=t('Statistics Proxy')?></legend>
		<div class="control-group">
			<?=$f->label('statsProxyURL', t('Proxy URL'))?>
			<div class="controls">
				<?=$f->text('statsProxyURL', $data['statsProxyURL'])?>
			</div>
		</div>
	</fieldset>

</div>
<div class="ccm-pane-footer">
	<button type="submit" class="btn btn-primary pull-right"><?=t('Save')?></button>
</div>
</form>

<?
print $h->getDashboardPaneFooterWrapper(false);
?>
