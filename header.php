<?php 

session_start();
if(isset($_SESSION['SESS_CHANGEID']) == TRUE) {

	session_unset();
	session_regenerate_id();

}

require("config.php");
$db = mysql_connect($dbhost, $dbuser, $dbpassword);
mysql_select_db($dbdatabase, $db);
mysql_query("SET NAMES 'UTF8'");
?>

<!doctype html>
<html>

<head>
	<meta charset='utf-8'>
		<title><?php echo $config_sitename; ?></title>
		<link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
</head>
<body>
	<div id="header">
		<h1><?php echo $config_sitename;?></h1>
	</div>
	<div id="menu">
		<a href="<?php echo $config_basedir; ?>">首页</a> -
		<a href="<?php echo $config_basedir; ?>showcart.php">浏览/结账</a>
	</div>
	<div id="container">
<!-- 		左边栏开始 -->
		<div id="bar">
			<?php 

			require("bar.php");
			echo "<hr>";
			//在网站左边栏下方显示登陆按钮，并连接到登陆页面
			if(isset($_SESSION['SESS_LOGGEDIN']) == TRUE) 
			{
				echo "<strong>" . $_SESSION['SESS_USERNAME'] . "</strong>"
 . "已登录[<a href= '" . $config_basedir . "logout.php'>退出</a>]";
 			}
 			else
 			{
 				echo "<a href= '" . $config_basedir."login.php'>登陆</a>";

 			}
 			?>
		</div> 
<!-- 左边栏结束 -->
<!-- 页面主体部分开始 -->
		<div id="main">
			