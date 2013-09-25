<? defined('C5_EXECUTE') or die(_("Access Denied."));
$h = Loader::helper('concrete/dashboard');
print $h->getDashboardPaneHeaderWrapper(t('Configure Server'), false, 'span8 offset2', false);
?>

<form method="post" action="<?=$this->action('save_configuration')?>">
<?=$form->hidden('serverID',$server->serverID);?>
<div class="ccm-pane-body">
	<h1><?=$server->serverName?></h1>

<table class="table table-striped">
<?
$i = 1;
foreach($configuration as $conf) { ?>
<tr>
	<td style="vertical-align: middle"><input type="radio" <? if ($conf->isVarnishConfigurationFileActive($server)) { ?>checked="checked" <? } ?> id="conf<?=$i?>" name="configuration" value="<?=$conf->getVarnishConfigurationHandle()?>" /></td>
	<td style="vertical-align: middle"><label for="conf<?=$i?>">
		<h4><?=$conf->getVarnishConfigurationName()?></h4>
		<?=$conf->getVarnishConfigurationDescription()?>
	</label>
	</td>
</tr>
	<? $i++; ?>
<? } ?>
</table>

</div>
<div class="ccm-pane-footer">
	<button type="submit" name="submit" class="btn btn-primary pull-right"><?=t('Enable Selected Configuration')?></button>
</div>

</form>

<?
print $h->getDashboardPaneFooterWrapper(false);
?>