<? defined('C5_EXECUTE') or die(_("Access Denied."));
$h = Loader::helper('concrete/dashboard');
print $h->getDashboardPaneHeaderWrapper(t('Start/Stop Server'), false, 'span8 offset2');
?>

<fieldset>
<form method="post" action="<?=$this->action('submit')?>">
	<legend><?=t('Control Server')?></legend>
	<? if ($socket->status()) { ?>
		<div class="alert alert-success"><?=t('Varnish is currently running.')?></div>
		<div class="form-actions">
			<button type="submit" name="stop" value="1" class="btn btn-warning"><?=t('Stop')?></button>
		</div>
	<? } else { ?>
		<div class="alert alert-info"><?=t('Varnish is not currently running.')?></div>
		<div class="form-actions">
			<button type="submit" name="start" value="1" class="btn btn-primary"><?=t('Start')?></button>
		</div>
	<? } ?>
</form>
</fieldset>

<?
print $h->getDashboardPaneFooterWrapper();
?>