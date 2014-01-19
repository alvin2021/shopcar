<?php
	require("db.php");
	require("functions.php");

	$validid = pf_validate_number($_GET['id'], "redirect", $config_basedir);

	require("header.php");

	// 从数据库中选取于网页get到的id一致的分类下所有商品  并将取到的结果赋给变量$numrows
	$prodcatsql = "SELECT * FROM products WHERE cat_id = " . $_GET['id'] . ";";
	$prodcatres = mysql_query($prodcatsql);
	$numrows = mysql_numrows($prodcatres);
	
	/* if语句判断$numrows取值，为0显示没有商品，
	else为其他值时通过while循环显示商品的信息。 */
	if ($numrows == 0) {
		echo "<h1>没有商品</h1>";
		echo "该分类暂无商品";
	}
	
	else {
		echo "<table cellpadding='10'>";
// 		while循环显示商品详细信息
		while ($prodrow = mysql_fetch_assoc($prodcatres)) {
			echo "<tr>";
// 				判断商品是否有图片，没有用默认图片代替
				if(empty($prodrow['image'])) {
					echo "<td><img src='./productimages/dummy.jpg' alt='" . $prodrow['name'] . "'></td>";
				}
				else {
					echo "<td><img src='./productimages/" . $prodrow['image'] . "' alt='" . $prodrow['name'] . "'></td>";
				}
// 				关于商品图片的显示到此结束		
// 				新建单元格显示商品名称
				echo "<td>";
// 				显示商品名称
				echo "<h2>" . $prodrow['name'] . "</h2>";
// 				显示商品描述
				echo "<p>" . $prodrow['description'];
// 				显示商品价格和购买链接
				echo "<p><strong>本网价格:" . sprintf('%.2f', $prodrow['price']) . "元</strong>";
				echo "<p>[<a href='addtobasker.php?id=" . $prodrow['id'] . "'>购买</a>]";
				echo "</td>";
				echo "</tr>";
				
		} 
// 		while循环结束
// 关闭表格
		echo "</table>";
		
	}
require 'footer.php';
	
	
	
?>