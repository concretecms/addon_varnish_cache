<? defined('C5_EXECUTE') or die(_("Access Denied."));
$h = Loader::helper('concrete/dashboard');
print $h->getDashboardPaneHeaderWrapper(t('Varnish Server Statistics'), false, 'span8 offset2');
?>
<? foreach($statisticsInfo as $info) {?>
	<h2><?=$info['server']?></h2>
<?   if (is_object($info['stats'])) {
	$statistics = $info['stats'];
 ?>
	
	<fieldset>
		<legend><?=t('Connections')?></legend>

		<table class="table">
		<tr>
			<th><?=t('Accepted')?></th>
			<th><?=t('Requested')?></th>
			<th><?=t('Dropped')?></th>
		</tr>
		<tr>
			<td width="33%"><span class="badge badge-success"><?=$statistics->getByKey('client_conn')?></span></td>
			<td width="34%"><span class="badge"><?=$statistics->getByKey('client_req')?></span></td>
			<td width="33%"><span class="badge badge-important"><?=$statistics->getByKey('client_drop')?></span></td>
		</tr>
		</table>

	</fieldset>

	<fieldset>
		<legend><?=t('Cache Hits & Misses')?></legend>

		<table class="table">
		<tr>
			<th><?=t('Hits')?></th>
			<th><?=t('Hits/Pass')?></th>
			<th><?=t('Misses')?></th>
		</tr>
		<tr>
			<td width="33%"><span class="badge badge-success"><?=$statistics->getByKey('cache_hit')?></span></td>
			<td width="34%"><span class="badge"><?=$statistics->getByKey('cache_hitpass')?></span></td>
			<td width="33%"><span class="badge badge-important"><?=$statistics->getByKey('cache_miss')?></span></td>
		</tr>
		</table>

	</fieldset>

	<fieldset>
		<legend><?=t('Backend')?></legend>

		<table class="table">
		<tr>
			<th><?=t('Conn. Success')?></th>
			<th><?=t('Busy')?></th>
			<th><?=t('Unhealthy')?></th>
			<th><?=t('Failure')?></th>
		</tr>
		<tr>
			<td width="25%"><span class="badge badge-success"><?=$statistics->getByKey('backend_conn')?></span></td>
			<td width="25%"><span class="badge badge-warning"><?=$statistics->getByKey('backend_busy')?></span></td>
			<td width="25%"><span class="badge badge-important"><?=$statistics->getByKey('backend_unhealthy')?></span></td>
			<td width="25%"><span class="badge badge-important"><?=$statistics->getByKey('backend_fail')?></span></td>
		</tr>
		<tr>
			<th><?=t('Reuse')?></th>
			<th><?=t('Retry')?></th>
			<th><?=t('Recycle')?></th>
			<th><?=t('Too Late')?></th>
		</tr>
		<tr>
			<td width="25%"><span class="badge"><?=$statistics->getByKey('backend_reuse')?></span></td>
			<td width="25%"><span class="badge"><?=$statistics->getByKey('backend_retry')?></span></td>
			<td width="25%"><span class="badge"><?=$statistics->getByKey('backend_recycle')?></span></td>
			<td width="25%"><span class="badge badge-important"><?=$statistics->getByKey('backend_toolate')?></span></td>
		</tr>
		</table>

	</fieldset>

<style type="text/css">
table.table	th, table.table td {
	border: 0px !important;
	text-align: center !important;	
}
</style>

<? } else { ?>
	<p><?=t('Statistics currently unavailable.')?></p>
<? }
} ?>

<?
print $h->getDashboardPaneFooterWrapper();
?>
