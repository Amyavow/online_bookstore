	<?php
		$pagetitle ="View Category";
		session_start();
		include '../include/functions.php';
		include '../include/dashboard_header.php';
		include '../include/db.php';
		
		


	?>
	<div class="wrapper">
		<div id="stream">
			<table id="tab">
				<thead>
					<tr>
						<th>category id</th>
						<th>category name</th>
						<th>edit</th>
						<th>delete</th>
					</tr>
				</thead>
				<tbody>
					<?php $info= viewCategory($conf);
					echo $info;  ?>
					
          		</tbody>
			</table>
		</div>

		<div class="paginated">
			<a href="#">1</a>
			<a href="#">2</a>
			<span>3</span>
			<a href="#">2</a>
		</div>
	</div>

	<section class="foot">
		<div>
			<p>&copy; 2016;
		</div>
	</section>
<?php include '../include/footer.php';  ?>
