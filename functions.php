<?php


//检测传入参数是否合法
function pf_validate_number($value, $function, $redirect ) {
	if (isset($value) == TRUE) {
		# code...
		if(is_numeric($value) == FALSE) {
			$error = 1;
		}

		if ($error == 1) {
			# code...
			header("Location: " . $redirect);
		}
		else {
			$final = $value;
		}
	}
	else {
		if($function == 'redirect') {
			header("Location: " . $redirect);
		}

		if($function == "value") {
			$final = 0;
		}
	}


	return $final;

}


//showcart函数
function showcart() {
	if($_SESSION['SESS_ORDERNUM']) {
// 		上层if检测是否有订单号
		if($_SESSION['SESS_LOGGEDIN']){
// 			上层if检测用户是否登陆 如果已经登陆，就从orders表中选出符合用户id等于当前用户并且status等于0或1条件的那些行
			$custsql = "SELECT id, status FROM orders WHERE customer_id = " . $_SESSION['SESS_USERID'] . " AND status < 2;";
			$custres = mysql_query($custsql);
			$custrow = mysql_fetch_assoc($custrow);

// 			执行主查询，获取已选商品的详细内容
			$itemssql = "select products.*, orderitems.*, orderitems.id AS itemid FROM products, orderitems WHERE orderitems.product_id = products.id AND order_id = " . $custrow['id'];

			$itemsres = mysql_query($itemssql);
			$itemnumrows = mysql_num_rows($itemsres);
		} else {
			/* 如果用户尚未登陆，则执行一个类似的select查询以获取订单号，但
			 * 这次是通过当前会话id进行匹配。
			 * 查询执行后，返回一系列已经选择的商品。 */
			$custsql = "SELECT id, status FROM orders WHERE session = '" . session_id() . "' AND status < 2;";
			//var_dump($custsql);
			//echo "****<br />";
			$custres = mysql_query($custsql);
			//var_dump($custres);
			//echo "****<br />";
			$custrow = mysql_fetch_assoc($custres);
			//var_dump($custrow);
			//echo "****<br />";


			//执行主查询，获取已选商品的详细内容
			$itemssql = "select products.*, orderitems.*, orderitems.id AS itemid FROM products, orderitems WHERE orderitems.product_id = products.id AND order_id = " . $custrow['id'];
			//var_dump($itemssql);
			$itemsres = mysql_query($itemssql);
			$itemnumrows = mysql_num_rows($itemsres);

		}
	}else {
		//首次if结束 else开始
		$itemnumrows = 0;

	}//第一层的else结束

/*新的if语句开始 这个if else用于设定$itemnumroes 变量，如果为0则还没有往购物车添加商品就显示您还没有添加商品
* 不为零是，生成整个要显示的表单
*/
	if($itemnumrows == 0) {
		echo "您还没有往购物车添加商品！";
	}else {
// 		生成表单

		echo "<table cellpadding='10'>";
		echo "<tr>";
			echo "<td></td>";
			echo "<td><strong>商品</strong></td>";
			echo "<td><strong>数量</strong></td>";
			echo "<td><strong>单价</strong></td>";
			echo "<td><strong>总价</strong></td>";
			echo "<td></td>";
		echo "</tr>";
		//while循环开始
		while( $itemsrow = mysql_fetch_assoc($itemsres)) {
			$quantitytotal = $itemsrow['price'] * $itemsrow['quantity'];
			echo "<tr>";
				// 				判断商品是否有图片，没有用默认图片代替
				if(empty($itemsrow['image'])) {
					echo "<td><img src='./productimages/dummy.jpg' alt='" . $itemsrow['name'] . "'></td>";
				}
				else {
					echo "<td><img src='./productimages/" . $itemsrow['image'] . "' alt={$itemsrow['name']}></td>";
				}
				// 				关于商品图片的显示到此结束
				echo "<td>" . $itemsrow['name'] . "</td>";
				echo "<td>" . $itemsrow['quantity'] . "</td>";
				echo "<td><strong>" . sprintf('%.2f', $itemsrow['price']) . "元</strong></td>";
				echo "<td><strong>" . sprintf('%.2f', $quantitytotal) . "元</strong></td>";
				echo "<td>[<a href='" . $config_basedir . "delete.php?id=" . $itemsrow['itemid'] . "'>X</a>]</td>";
			echo "</tr>";
// 				计算总价并插入到数据库orders表total字段
				$total = $total +$quantitytotal;
				$totalsql ="UPDATE orders SET total = ". $total . "WHERE id = " . $_SESSION['SESS_ORDERNUM'];
				$totalres = mysql_query($totalsql);
		} //while 结束

		echo "<tr>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td>总价</td>";
			echo "<td><strong>" . sprintf('%.2f', $total) . "元</strong></td>";
			echo "<td></td>";
		echo "</tr>";

		echo "</table>";

		echo "<p><a href='checkout-address.php'>去结账</a></p>";
	}


} //函数结束
?>