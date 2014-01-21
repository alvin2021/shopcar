<?php
session_start();

require 'header.php';
require 'functions.php';

echo "<h1>我的购物车</h1>";

showcart();

//检测是否存在订单号
if (isset($_SESSION['SESS_ORDERNUM']) ==TRUE) {
	$sql = "select * from orderitems where order_id = " . $_SESSION['SESS_ORDERNUM'] . ";";
	$result =mysql_query($sql);
	$numrows = mysql_num_rows($result);

	//订单号对应的数量大于等于1时显示结账按钮
	if ($numrows >=1) {
		echo "<h2><a href='checkout-address.php'>去结账</a></h2>";
	}
}

require 'footer.php';

?>