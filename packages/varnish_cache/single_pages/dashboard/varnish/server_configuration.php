<? defined('C5_EXECUTE') or die(_("Access Denied."));
$h = Loader::helper('concrete/dashboard');
print $h->getDashboardPaneHeaderWrapper(t('Configure Server'), false);
?>


<?
print $h->getDashboardPaneFooterWrapper();
?>