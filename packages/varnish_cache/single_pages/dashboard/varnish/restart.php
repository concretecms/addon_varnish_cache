<? defined('C5_EXECUTE') or die(_("Access Denied."));
$h = Loader::helper('concrete/dashboard');
print $h->getDashboardPaneHeaderWrapper(t('Start/Stop Server'), false, 'span8 offset2', false);
?>

<form method="post" action="<?=$this->action('submit')?>">
<div class="ccm-pane-body">
	<a href="<?=View::url('/dashboard/varnish/server_details', $server->serverID)?>">&laquo; <?=t('Server Details')?></a>
	<fieldset>
	<?=$form->hidden('serverID',$server->serverID);?>
	<legend><?=t('Control Server')?></legend>
	<? if ($socket->status()) { ?>
		<div class="alert alert-success"><?=t('Varnish is currently running.')?></div>
	<? } else { ?>
		<div class="alert alert-info"><?=t('Varnish is not currently running.')?></div>
	<? } ?>
	</fieldset>
</div>
<div class="ccm-pane-footer">
	<? if ($socket->status()) { ?>
		<button type="submit" name="stop" value="1" class="btn btn-warning  pull-right"><?=t('Stop')?></button>
	<? } else { ?>
		<button type="submit" name="start" value="1" class="btn btn-primary  pull-right"><?=t('Start')?></button>
	<? } ?>
</div>


</form>

<?
print $h->getDashboardPaneFooterWrapper(false);
?>