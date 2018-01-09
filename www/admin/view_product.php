<?php
		$pagetitle ="View Product";
		session_start();
		include '../include/functions.php';
		include '../include/dashboard_header.php';
		include '../include/db.php';

		checkLogin();
?>


<div class="wrapper">
		<div id="stream">
			<table id="tab">
				<thead>
					<tr>
						<th>title</th>
						<th>author</th>
						<th>price</th>
						<th>category</th>
						<th>Publication Year</th>
						<th>image</th>
						<th>edit</th>
						<th>delete</th>
					</tr>
				</thead>
				<tbody>
					<?php 

					$info = viewProducts($conf);
					echo $info;

					 ?>
					
					
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