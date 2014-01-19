<h1>商品分类</h1>
<ul>
<?php

	$catsql = "SELECT * FROM categories;";
	$catres = mysql_query($catsql);

	//while查询商品分类并生成有序列表和相应的链接
	while ($catrow = mysql_fetch_assoc($catres)) {
		# code...
			echo "<li><a href='" . $config_basedir . "products.php?id=" . $catrow['id'] . "'>" . $catrow['name'] . "</a></li>";

	}

 ?>
 </ul>
<!-- 列表结束 -->