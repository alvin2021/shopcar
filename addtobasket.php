<?php
session_start();

require 'db.php';
require 'functions.php';
$validid = pf_validate_number($_GET['id'], "redirect", $config_basedir);

// 从数据库中选取和传入商品id一致的数据
$prodsql = "select * FROM products WHERE id = " . $_GET['id'] . ";";
$prodres = mysql_query($prodsql);
$numrows = mysql_num_rows($prodres);
$prodrow = mysql_fetch_assoc($prodres);

//判断是否有商品
if($numrows == 0) {
	//没有商品则将网页重定向到首页
	header("Location: " . $config_basedir);
} else{
// 	有商品先检查是否提交

	if($_POST['submit']) {

		//判断用户定单号是否存在 存在就把购买商品数量插入到数据库orderitems表单中
		if ($_SESSION['SESS_ORDERNUM']) {
				$itemsql = "INSERT INTO orderitems(order_id, product_id, quantity) VALUES(". $_SESSION['SESS_ORDERNUM'] . ", " . $_GET['id'] . ", " . $_POST['amountBox'] . ")";
				mysql_query($itemsql);
		} else {
			/*用户订单号不存在就判断用户是否登陆
			 * 1、用户登陆  则执行  将 $_SESSION['SESS_USERID']作为用户customer——id插入到orders表中，将产生的值赋值给$_session['SESS_ORDERNUM']然后添加购买数量
			 * 2、用户未登录 则执行 session_id()获取一个唯一的会话id 将商品添加到orderitems表中
			 */
			if ($_SESSION['SESS_LOGGEDIN']) {
				//用户已登录
				$sql = "INSERT INTO orders(customer_id, registered, date) VALUES(" . $_SESSION['SESS_USERID'] . ", 1, NOW())";
				mysql_query($sql);
				$_SESSION['SESS_ORDERNUM'] = mysql_insert_id();
				$itemsql = "INSERT INTO orderitems(order_id, product_id, quantity) VALUES(". $_SESSION['SESS_ORDERNUM'] . ", " . $_GET['id'] . ", " . $_POST['amountBox'] . ")";
				mysql_query($itemsql);

			} else {
// 				用户未登录
				$sql = "INSERT INTO orders(registered, date, session) VALUES(" . "0, NOW(), '" . session_id() . "')";
				//echo "<br />***************<br />";
				//var_dump($sql);
				mysql_query($sql);
				$_SESSION['SESS_ORDERNUM'] = mysql_insert_id();
				//echo "<br />***************<br />";
				//var_dump($_SESSION['SESS_ORDERNUM']);
				$itemsql = "INSERT INTO orderitems(order_id, product_id, quantity) VALUES(" . $_SESSION['SESS_ORDERNUM'] . ", " . $_GET['id'] . ", " . $_POST['amountBox'] . ")";
				//echo "<br />***************<br />";
				//var_dump($itemsql);
				//echo "<br />***************<br />";
				mysql_query($itemsql);

			}
		}

		//计算添加的商品价格 单价X数量
		$totalprice = $prodrow['price'] * $_POST['amountBox'] ;
		//更新orders表单中商品总价
		$upsql = "UPDATE orders SET total = total + " . $totalprice . " WHERE id = " . $_SESSION['SESS_ORDERNUM'] . ";";

		//echo $upsql;
		mysql_query($upsql);
		//var_dump($abc);


// 		将网页定向到showcart.php页面
		header("Location: ". $config_basedir . "showcart.php");
	} else {
		//没有submit提交信息，就显示
		require 'header.php';

		echo "<form action='addtobasket.php?id=" . $_GET['id'] . "' method='POST'>";
		echo "<table cellpadding='10'>";

			echo "<tr>";
					//判断商品是否有图片，没有用默认图片代替
					if(empty($prodrow['image'])) {
						echo "<td><img src='./productimages/dummy.jpg' width ='50' alt='" . $prodrow['name'] . "'></td>";
					}else {
						echo "<td><img src='./productimages/" . $prodrow['image'] . "' width ='50' alt='" . $prodrow['name'] . "'></td>";
					} //关于商品图片的显示到此结束
					//echo "<td>" . $prodrow['name'] . "</td>";
					//生成选择数量的单元格和数量选单
					//var_dump($prodrow['name']);
					echo "<td>选择数量<select name='amountBox'>";

					for($i=1;$i<=100;$i++)
					{
						echo "<option>" . $i . "</option>";

					}
					echo "</select></td>"; //关闭选择数量单元格
					echo "<td><strong>" . sprintf('%.2f', $prodrow['price']) . "</strong></td>";
					echo "<td><input type='submit' name='submit' value='添加到购物车'></td>";

			echo "</tr>";
		echo "</table>";
		echo "</form>";
	}
}
	require 'footer.php';
?>
