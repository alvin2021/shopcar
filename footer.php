<?php
	echo "<p><i>本网站所有内容版权属于&copy; " . $config_sitename . "</i></p>";
	if($_SESSION['SESS_ADMINLOGGEDIN'] == 1)
	{
		echo "[<a href='" . $config_basedir . "adminorders.php'>管理</a>][<a href='" . $config_basedir . "adminlogout.php'>管理退出</a>]";
	}



?>

</div>
	</div>
</body>
</html>