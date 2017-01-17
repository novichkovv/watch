<html>
	<head>
		<title>Корзина</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?php echo SITE_DIR; ?>templates/frontend/cart/assets/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo SITE_DIR; ?>templates/frontend/cart/assets/css/custom.css"/>
	</head>

	<body>
		
		<nav class="navbar">
			<div class="container">
				<a class="navbar-brand" href="#">Корзина</a>
				<div class="navbar-right">
					<div class="container minicart"></div>
				</div>
			</div>
		</nav>
		<br>
		
<!--		<div class="container-fluid breadcrumbBox text-center">-->
<!--			<ol class="breadcrumb">-->
<!--				<li><a href="#">Review</a></li>-->
<!--				<li class="active"><a href="#">Order</a></li>-->
<!--				<li><a href="#">Payment</a></li>-->
<!--			</ol>-->
<!--		</div>-->
		
		<div class="container text-center">

			<div class="col-md-5 col-sm-12">
				<h1 class="h1">Выберите модель и цвет</h1>
				<h1 class="h2">Добавьте к заказу любой чехол всего за <?php echo round($product['price_discount_2']); ?> рублей!</h1>
			</div>
			<div class="col-md-7 col-sm-12 text-left">
				<table class="table" style="width: 100%;">
					<thead>
					<tr>
						<th>Товар</th>
						<th>Цена</th>
						<th></th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($product_goods as $good): ?>
						<tr class="bg-white good" data-id="<?php echo $good['id']; ?>">
							<td class="itemName">
								<?php echo $good['short_name']; ?>
							</td>
							<td data-price="<?php echo round($product['price_discount_1']); ?>" class="price1"><?php echo round($product['price_discount_1']); ?>р</td>
							<td class="quantity"><?php echo (isset($order_goods[$good['id']]['quantity']) ? $order_goods[$good['id']]['quantity'] : 0); ?></td>
							<td class="remove"><?php echo (isset($order_goods[$good['id']]['quantity']) ? '<i class="glyphicon glyphicon-minus"></i>' : ''); ?></td>
						</tr>
						<tr class="bg-none">
							<td class="bg-none-td" colspan="3"></td>
						</tr>
					<?php endforeach; ?>
<!--					<tr class="bg-white good" data-id="1">-->
<!--						<td class="itemName">-->
<!--							Черный для-->
<!--							IPhone 5,5s-->
<!--						</td>-->
<!--						<td data-price="--><?php //echo round($product['price_discount_1']); ?><!--" class="price1">--><?php //echo round($product['price_discount_1']); ?><!--р</td>-->
<!--						<td class="quantity">--><?php //echo (isset($order_goods[1]['quantity']) ? $order_goods[1]['quantity'] : 0); ?><!--</td>-->
<!--						<td class="remove">--><?php //echo (isset($order_goods[1]['quantity']) ? '<i class="glyphicon glyphicon-minus"></i>' : ''); ?><!--</td>-->
<!--					</tr>-->
<!--					<tr class="bg-none">-->
<!--						<td class="bg-none-td" colspan="3"></td>-->
<!--					</tr>-->
<!--					<tr class="bg-white good" data-id="2">-->
<!--						<td class="itemName">-->
<!--							Белый для-->
<!--							IPhone 5,5s-->
<!--						</td>-->
<!--						<td data-price="--><?php //echo round($product['price_discount_1']); ?><!--" class="price1">--><?php //echo round($product['price_discount_1']); ?><!--р</td>-->
<!--						<td class="quantity">--><?php //echo (isset($order_goods[2]['quantity']) ? $order_goods[2]['quantity'] : 0); ?><!--</td>-->
<!--						<td class="remove">--><?php //echo (isset($order_goods[2]['quantity']) ? '<i class="glyphicon glyphicon-minus"></i>' : ''); ?><!--</td>-->
<!--					</tr>-->
<!--					<tr class="bg-none">-->
<!--						<td class="bg-none-td" colspan="3"> </td>-->
<!--					</tr>-->
<!--					<tr class="bg-white good" data-id="3">-->
<!--						<td class="itemName">-->
<!--							Черный для-->
<!--							IPhone 6,6s-->
<!--						</td>-->
<!--						<td data-price="--><?php //echo round($product['price_discount_1']); ?><!--" class="price1">--><?php //echo round($product['price_discount_1']); ?><!--р</td>-->
<!--						<td class="quantity">--><?php //echo (isset($order_goods[3]['quantity']) ? $order_goods[3]['quantity'] : 0); ?><!--</td>-->
<!--						<td class="remove">--><?php //echo (isset($order_goods[3]['quantity']) ? '<i class="glyphicon glyphicon-minus"></i>' : ''); ?><!--</td>-->
<!--					</tr>-->
<!--					<tr class="bg-none">-->
<!--						<td class="bg-none-td" colspan="3"></td>-->
<!--					</tr>-->
<!--					<tr class="bg-white good" data-id="4">-->
<!--						<td class="itemName">-->
<!--							Белый для-->
<!--							IPhone 6,6s-->
<!--						</td>-->
<!--						<td data-price="--><?php //echo round($product['price_discount_1']); ?><!--" class="price1">--><?php //echo round($product['price_discount_1']); ?><!--р</td>-->
<!--						<td class="quantity">--><?php //echo (isset($order_goods[4]['quantity']) ? $order_goods[4]['quantity'] : 0); ?><!--</td>-->
<!--						<td class="remove">--><?php //echo (isset($order_goods[4]['quantity']) ? '<i class="glyphicon glyphicon-minus"></i>' : ''); ?><!--</td>-->
<!--					</tr>-->
<!--					<tr class="bg-none">-->
<!--						<td class="bg-none-td" colspan="3"></td>-->
<!--					</tr>-->
					<?php if ($product['price_delivery']): ?>
						<tr class="bg-blue">
							<td class="itemName">
								Доставка
							</td>
							<td data-price="<?php echo round($product['price_delivery']); ?>" class="price1"><?php echo round($product['price_delivery']); ?>р</td>
							<td class="quantity">1</td>
							<td></td>
						</tr>
					<?php endif; ?>
					<tr>
						<td>
							Всего:
						</td>
						<td class="price1 total"><?php echo (isset($total_sum) ? $total_sum : round($product['price_delivery'])); ?></td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<form method="post" action="">
			<button id="next_btn" name="save_cart_btn" type="submit" class="btn btn-success btn-lg"
			<?php if (!$order_goods): ?>
				disabled
			<?php endif; ?>>ДАЛЕЕ</button>
			<div id="error-message">
				Для продолжения выберите модель и цвет чехла!
			</div>

			<input type="hidden" name="good[1]" value="<?php echo $order_goods[1]['quantity']; ?>" class="hidden_good" data-id="">
			<input type="hidden" name="good[2]" value="<?php echo $order_goods[2]['quantity']; ?>" class="hidden_good" data-id="2">
			<input type="hidden" name="good[3]" value="<?php echo $order_goods[3]['quantity']; ?>" class="hidden_good" data-id="3">
			<input type="hidden" name="good[4]" value="<?php echo $order_goods[4]['quantity']; ?>" class="hidden_good" data-id="4">
			<input type="hidden" name="order_id" value="<?php echo $_GET['id']; ?>">
		</form>
		<div id="popover" style="display: none">
			<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="#"><span class="glyphicon glyphicon-remove"></span></a>
		</div>
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="<?php echo $dir; ?>js/jquery.min.js"></script>
		<script src="<?php echo SITE_DIR; ?>templates/frontend/cart/assets/js/bootstrap.min.js"></script>
		<script src="<?php echo SITE_DIR; ?>templates/frontend/cart/assets/js/customjs.js"></script>
		<script type="text/javascript">
			$ = jQuery.noConflict();
			$(document).ready(function () {
				var price_1 = <?php echo round($product['price_discount_1']); ?>;
				var price_2 = <?php echo round($product['price_discount_2']); ?>;
				var delivery = <?php echo round($product['price_delivery']); ?>;
				$("body").on("click", ".good td:not(.remove, .bg-none-td)", function () {
					$("#next_btn").removeAttr('disabled');
					$('.h1').hide();
					$('.h2').show();
					var $tr = $(this).closest('.good');
                    var id = $tr.attr('data-id');
					var $quantity = $tr.find('.quantity');
					var $price = $tr.find('.price1');
					var $remove = $tr.find('.remove');
					$remove.html('<i class="glyphicon glyphicon-minus"></i>');
					var price = parseInt($price.attr('data-price'));
					var $all_price = $(".good .price1");
					$all_price.attr('data-price', price_2);
					$all_price.html(price_2 + 'р');
					var html = $quantity.html();
					var qty = parseInt(html ? html : 0);
					qty ++;
					$('[name="good[' + id + ']"]').val(qty);
					$quantity.html(qty);
					var total_qty = 0;
					$(".quantity").each(function() {
						total_qty += parseInt($(this).html());
					});
					var $total = $('.total');
					var total_price = price_1 + (total_qty - 2) * price_2 + delivery;
					$total.html(total_price);
				});

				$("body").on("click", ".remove", function () {
					var $tr = $(this).closest('tr');
                    var id = $tr.attr('data-id');
					var $quantity = $tr.find('.quantity');
					var html = $quantity.html();
					var qty = parseInt(html ? html : 0);
					if(qty == 0) {
						return;
					}
					var $price = $tr.find('.price1');
					var $remove = $tr.find('.remove');

					var price = parseInt($price.attr('data-price'));


					if(qty == 0) {
						$remove.html('<i class="glyphicon glyphicon-minus"></i>');
					}
					qty --;
					$('[name="good[' + id + ']"]').val(qty);
					if(qty === 0) {
						$remove.html('');
					}
					$quantity.html(qty);
					var total_qty = 0;
					$(".quantity").each(function() {
						total_qty += parseInt($(this).html());
					});
					var total_price = price_1 + (total_qty - 2) * price_2 + delivery;
					if(total_qty === 1) {
						var $all_price = $(".good .price1");
						$all_price.attr('data-price', price_1);
						$all_price.html(price_1 + 'р');
						$('.h1').show();
						$('.h2').hide();
						total_price = 0;
						$("#next_btn").attr('disabled', 'disabled');
					}
 					var $total = $('.total');
					$total.html(total_price);
				});
			});
		</script>
	</body>
</html>
