﻿<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/templates/_functions.php');

//Change page name here:
$PageName = 'Latest Releases';

require_once($_SERVER['DOCUMENT_ROOT'].'/templates/_header.php');
?>

		<div id="Content">
<!-- ================================= Content starts here ============================== -->
		
			<h1><?php echo "$PageName";?></h1>
			<p>The following table shows releases of all openEHR specification components. Note that RM and BASE Release 1.0.2 are conversions of the original 'Release 1.0.2' specifications, available on the <a href="/historical_releases">historical releases page</a>.</p>
			
			<table class="TableBasic">
				<tbody>
					<tr>
						<th> Release </th>
						<th> Date</th>
					</tr>
					<tr>
						<td> <a href="/releases/RM/Release-1.0.4" target="_blank">RM Release 1.0.4</a></td>
						<td> 04 January 2019 </td>
					</tr>

					<tr>
						<td> <a href="/releases/PROC/Release-1.0.0" target="_blank">PROC Release 1.0.0</a></td>
						<td> 1 December 2017 </td>
					</tr>

					<tr>
						<td> <a href="/releases/QUERY/Release-1.0.0" target="_blank">QUERY Release 1.0.0</a></td>
						<td> 15 November 2017 </td>
					</tr>

					<tr>
						<td> <a href="/releases/TERM/Release-2.1.0" target="_blank">TERM Release 2.1.0</a></td>
						<td> 08 November 2017 </td>
					</tr>

					<tr>
						<td> <a href="/releases/AM/Release-2.0.6" target="_blank">AM Release 2.0.6</a></td>
						<td> 07 January 2017 </td>
					</tr>

					<tr>
						<td> <a href="/releases/RM/Release-1.0.3" target="_blank">RM Release 1.0.3</a></td>
						<td> 15 December 2015 </td>
					</tr>

					<tr>
						<td> <a href="/releases/BASE/Release-1.0.3" target="_blank">BASE Release 1.0.3</a></td>
						<td> 15 December 2015 </td>
					</tr>

					<tr>
						<td> <a href="/releases/RM/Release-1.0.2" target="_blank">RM Release 1.0.2</a></td>
						<td> 20 December 2008 </td>
					</tr>

					<tr>
						<td> <a href="/releases/BASE/Release-1.0.2" target="_blank">BASE Release 1.0.2</a></td>
						<td> 20 December 2008 </td>
					</tr>

				</tbody>
			</table>

<!-- =========================================== Content ends here =============================================== -->
		</div>	
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/_footer.php');?>
