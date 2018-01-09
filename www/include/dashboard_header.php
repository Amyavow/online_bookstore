
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $pagetitle; ?></title>
	<link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>

<body>
	<section>
		<div class="mast">
			<h1>T<span>SSB</span></h1>
			<nav>
				<ul class="clearfix">
					<li><a href="add_category.php" <?php selectPage('add_category.php'); ?>>add category</a></li>
					<li><a href="view_category.php" <?php selectPage('view_category.php');?> >view category</a></li>
					<li><a href="add_product.php" <?php selectPage('add_product.php');?>>add products</a></li>
					<li><a href="view_product.php" <?php selectPage('view_product.php');?>>view products</a></li>
					<li><a href="admin_logout.php" <?php selectPage('admin_logout.php');?>>logout</a></li>
				</ul>
			</nav>
		</div>
	</section>