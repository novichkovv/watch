<!DOCTYPE html>
<html>
	<head>
		<title>Shopping Cart</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="assets/css/custom.css"/>		
	</head>

	<body>
		
		<nav class="navbar">
			<div class="container">
				<a class="navbar-brand" href="#">Your online store</a>
				<div class="navbar-right">
					<div class="container minicart"></div>
				</div>
			</div>
		</nav>
		
		<div class="container-fluid breadcrumbBox text-center">
			<ol class="breadcrumb">
				<li><a href="#">Review</a></li>
				<li class="active"><a href="#">Order</a></li>
				<li><a href="#">Payment</a></li>
			</ol>
		</div>
		
		<div class="container text-center">

			<div class="col-md-5 col-sm-12">
				<div class="bigcart"></div>
				<h1>Your shopping cart</h1>
				<p>
					This is a free and <b><a href="http://tutorialzine.com/2014/04/responsive-shopping-cart-layout-twitter-bootstrap-3/" title="Read the article!">responsive shopping cart layout, made by Tutorialzine</a></b>. It looks nice on both desktop and mobile browsers. Try it by resizing your window (or opening it on your smartphone and pc).
				</p>
			</div>
			
			<div class="col-md-7 col-sm-12 text-left">
				<ul>
					<li class="row list-inline columnCaptions">
						<span>QTY</span>
						<span>ITEM</span>
						<span>Price</span>
					</li>
					<li class="row">
						<span class="quantity">1</span>
						<span class="itemName">Birthday Cake</span>
						<span class="popbtn"><a class="arrow"></a></span>
						<span class="price">$49.95</span>
					</li>
					<li class="row">
						<span class="quantity">50</span>
						<span class="itemName">Party Cups</span>
						<span class="popbtn"><a class="arrow"></a></span>
						<span class="price">$5.00</span>
					</li>
					<li class="row">
						<span class="quantity">20</span>
						<span class="itemName">Beer kegs</span>
						<span class="popbtn"><a class="arrow"></a></span>
						<span class="price">$919.99</span>				
					</li>
					<li class="row">
						<span class="quantity">18</span>
						<span class="itemName">Pound of beef</span>
						<span class="popbtn"><a class="arrow"></a></span>
						<span class="price">$269.45</span>
					</li>
					<li class="row">
						<span class="quantity">1</span>
						<span class="itemName">Bullet-proof vest</span>
						<span class="popbtn"  data-parent="#asd" data-toggle="collapse" data-target="#demo"><a class="arrow"></a></span>
						<span class="price">$450.00</span>				
					</li>
					<li class="row totals">
						<span class="itemName">Total:</span>
						<span class="price">$1694.43</span>
						<span class="order"> <a class="text-center">ORDER</a></span>
					</li>
				</ul>
			</div>

		</div>

		<!-- The popover content -->

		<div id="popover" style="display: none">
			<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="#"><span class="glyphicon glyphicon-remove"></span></a>
		</div>
		
		<!-- JavaScript includes -->

		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> 
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/customjs.js"></script>

	</body>
</html>