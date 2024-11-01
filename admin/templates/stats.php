<?php $stat = new WPP_stat();
?>

<h3>Statistics</h3>
<div>
<h4>Promotional Bar Statistics</h4>
<table>
	<tr>
		<th>Impressions</th>
		<td><?php echo ceil($stat->getImpression('wpp_bar')); ?></td>
	</tr>
	<tr>
		<th>Link Click</th>
		<td><?php echo ceil($stat->getClicks('wpp_bar')); ?></td>
	</tr>
	<tr>
		<th>Link Close Click</th>
		<td><?php echo ceil($stat->getCloseClicks('wpp_bar')); ?></td>
	</tr>
</table>
<h4>Promotional Popup Statistics</h4>
<table>
	<tr>
		<th>Impressions</th>
		<td><?php echo ceil($stat->getImpression('wpp_popup')); ?></td>
	</tr>
	<tr>
		<th>Link Click</th>
		<td><?php echo ceil($stat->getClicks('wpp_popup')); ?></td>
	</tr>
	<tr>
		<th>Link Close Click</th>
		<td><?php echo ceil($stat->getCloseClicks('wpp_popup')); ?></td>
	</tr>
</table>

<a href="#" class="button button-primary" id="reset-stats">Reset Statistics</a>

</div>