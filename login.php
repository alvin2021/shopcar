<?php
// 会话开始
session_start();
// 包含数据库文件
require("db.php");
// 判断是否登陆，如果登陆从定向到页面首页
if(isset($_SESSION['SESS_LOGGEDIN']) == TRUE) 
{
	header("Location: " . $config_basedir);
}

// 判断是否有表单提交
if ($_POST['submit']) 
{
	# code...
	//查询是否有用户登录
	$loginsql = "SELECT * FROM logins WHERE username = '" . $_POST['userBox'] . "' AND password = '" . $_POST['passBox'] . "'";
	//echo $loginsql;
	$loginres = mysql_query($loginsql);
	$numrows = mysql_num_rows($loginres);

	// $numrows 为1时表示有用户登录，其他则为没有用户登录
	if($numrows == 1)
	{
		//取出数据库值
		$loginrow = mysql_fetch_assoc($loginres);

		//注册会话 php 5.4后这个函数被弃用无需注册
		//session_register("SESS_LOGGEDIN");
		//session_register("SESS_USERNAME");
		//session_register("SESS_USERID");
		
		// 会话变量赋值	
		$_SESSION['SESS_LOGGEDIN'] = 1;
		$_SESSION['SESS_USERNAME'] = $loginrow['username'];
		$_SESSION['SESS_USERID'] = $loginrow['id'];

		$ordersql = "SELECT id FROM orders WHERE customer_id = " . $_SESSION['SESS_USERID'] . " AND status < 2";
		echo $ordersql;
		$orderres = mysql_query($ordersql);
		$orderrow = mysql_fetch_assoc($orderres);

		// 存在订单就将查询到的订单号赋值给变量$_SESSION['SESS_ORDERNUM']
		//session_register("SESS_ORDERNUM");
		$_SESSION['SESS_ORDERNUM'] = $orderrow['id'];
		header("Location: " . $config_basedir);
	}

	//没有查询到订单 
	else
	{
		header("Location:http://" . $HTTP_HOST . $SCRIPT_NAME . "?error=1");
	}
}
// submit if判断语句结束
	
else
{
	require("header.php");
?>
	<h1>客户登陆</h1>
	请输入您的用户名和密码登录网站。如果没有账户，点此免费<a href="register.php">注册</a>。
	<p>
	<?php
		if($_GET['error'])
		{
			echo "<strong>错误的用户名和密码</strong>";
		}
	?>



<!-- 登陆表单 -->
<form action="<?php echo $SCRIPT_NAME; ?>" method="post">
<table>
	<tr>
	<td>用户名</td>
	<td><input type="textbox" name="userBox"></td>
	</tr>
	<tr>
		<td>密码</td>
		<td><input type="password" name="passBox"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="登陆"></td>
	</tr>
</table>


</form>

<?php 
}

require("footer.php");

?>