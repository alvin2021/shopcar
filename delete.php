<?php
/* 包含基本文件 */
require 'config.php';
require 'db.php';;
require 'functions.php';
/* 文件包含结束 */

/* 验证传输参数是否合法 */
$validid = pf_validate_number($_GET['id'], "redirect", $config_basedir . "showcart.php");
/* 验证传输参数结束 */

/* 根据传入商品id从orderitems中选取符合的序列 */
$itemsql = "SELECT * FROM orderitems WHERE id = " . $_GET['id'] . ";";
$itemres = mysql_query($itemsql);
$numrows = mysql_num_rows($itemres);
/* 操作数据库选取商品结束 */

if ($numrows == 0) {
	//如果返回的序列为空，则重定向到购物车网页
	header("Location: " . $config_basedir . "showcart.php");
}

/* 首先选出商品的价格，然后通过另一个查询从orderitems中删除商品 */
$itemrow = mysql_fetch_assoc($itemres);
$prodsql= "SELECT price FROM products WHERE id = ". $itemrow['product_id'] . ";";
$prodres = mysql_query($prodsql);
$prodrow = mysql_fetch_assoc($prodres);

//删除商品
$sql = "DELETE FROM orderitems WHERE id = ". $_GET['id'];
mysql_query($sql);

//更新总价
$totalprice = $prodrow['price'] * $itemrow['quantity'] ;

$upsql = "update orders set total = total - " . $totalprice . "where id = " . $_SESSION['SESS_ORDERNUM'] . ";";

mysql_query($upsql);

//页面重定向到购物车
header("Location: " . $config_basedir . "/showcart.php");
?>


