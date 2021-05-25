<?php
	include("inc/config.php");
	include("inc/utils.php");
	if(testCookie())
	{	
                // We could store others things in the future so we split with \n
               	$tmp_array = explode("\n",urldecode($_COOKIE['auth']));
               	for ($i = 0; $i < count($tmp_array); $i++)
		       	$cookie=unserialize($tmp_array[$i]); // Todo an array
	}
	 // Deprecated use of mysql extension
	$link = mysql_connect(MYSQL_ADDR,MYSQL_USER,MYSQL_PASSWD);	
	$db = mysql_select_db(MYSQL_DB,$link);
	
	if(isset($_GET['page']) && $_GET['page'] === "login_form" && isset($_POST['mail']) && isset($_POST['pass']))
	{ 
		$sql = "SELECT salt from users where mail='".mysql_real_escape_string($_POST['mail'])."'";
		$result = mysql_query($sql);
		if($row = mysql_fetch_array($result,MYSQL_ASSOC))
			$salt = $row["salt"];

		
		$sql="SELECT * from users where mail='".mysql_real_escape_string($_POST['mail'])."' and password='".hash("sha512",($_POST['pass'].$salt))."'";
		$result = mysql_query($sql);
		if($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{
			$cookie["id"] = $row["id"];
			$cookie["admin"] = $row["admin"];
			$cookie["cart"] = array();
			setcookie("auth", urlencode(serialize($cookie)), time()+3600, "");
			setcookie("mac", sha1(SECRET.serialize($cookie)), time()+3600, "");			
		// Pas de http only dans la vm .....................
		}

	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Goldpharma, online drug store and pharmacy</title>
<link href="buyamoxicillinonline.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="mainwrap">
<div class="wrapper">
	<ul class="nav">
	<?php
	if(!isset($cookie) || !isset($cookie['id']))
	{?>
        <li><a href="/?page=register">Register</a></li>
        <li><a href="/?page=login">Login</a></li>
        <?php } else { ?>
	<li><a href="/?page=account">My account</a></li>
        <li><a href="/?page=cart">Shopping cart</a></li>
	<li><a href="/logout.php">Logout</a></li>
	<?php } if(isset($cookie) && $cookie["admin"] === "1") { ?>
	<li><a href="/?page=admin"><b>Administration</b></a></li>      
	<?php }
	if(isset($cookie) && $cookie["admin"] === "0")
	{
		echo '<li><a href="/?page=support">Support</a></li>';
	}
	?>
    </ul>
    <div class="line1">
      <h4>&nbsp;</h4>
      <h4>&nbsp;</h4>

</div>
    <div id="side">
      <h3>Categories</h3>
      <ul>  
	<li><a href="/?page=home">Home</a></li>
        <li><a href="/?page=articles">Articles</a></li>
	<li><a href="/?page=testimonials">Testimonials</a></li>
        <li><a href="/?page=about">About</a></li>


      </ul>


      <p>&nbsp;</p>
      <h5>&nbsp;</h5>
</div>
    <div id="content">
    <?php
	$authorized =  array("home","register","login","account","about");
	if(isset($_GET['page']) && $_GET['page'] === "register_form" && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['mail']) && isset($_POST['ccn']) && isset($_POST['pass']))
	{
		$sql = "SELECT mail from users WHERE mail='".mysql_real_escape_string(trim($_POST['mail']))."'";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) === 0)
		{
			$salt=randStr(6);
			$sql= "INSERT INTO users VALUES('','".mysql_real_escape_string(htmlspecialchars(trim($_POST['firstname']))).
		      	"','".mysql_real_escape_string(htmlspecialchars(trim($_POST['lastname']))).
                      	"','".mysql_real_escape_string(htmlspecialchars(trim($_POST['mail']))).
                      	"','".mysql_real_escape_string(htmlspecialchars(trim($_POST['ccn']))).
                      	"','".hash("sha512",($_POST['pass'].$salt)).
		     	 "','".$salt."',0)";		
			if(mysql_query($sql))
				echo "<h3>Congratz for your registration</h3>";
		}
		else
			echo "<h3>Email already used</h3>";
	
	}
	elseif(isset($_GET['page']) and $_GET['page'] === "articles")
		{
			$sql = "SELECT * from articles order by nom";
			$result = mysql_query($sql);
			echo '<table><tr><th>Name</th><th>Information</th><th>Picture</th><th>Action</th></tr>';
			while($row = mysql_fetch_array($result,MYSQL_ASSOC))
			{
				echo '<tr><td><h4>'.$row['nom'].'</h4></td>';
				echo '<td><p align="justify">'.$row['description'].'</p></td>';
				echo '<td><img src="'.$row['photo'].'"></td>';
				echo '<td><div><a href="?page=cart&art='.$row['nom'].'"><img src="images/buy.png"></a></div><div><h6>'.$row['prix'].'$ per unit</h6></div></td>';
			}
			echo '</table>';
		}
	elseif(isset($_GET['page']) and $_GET['page'] === "testimonials")
	{
		$sql = "SELECT * from temoin order by id";
		$result = mysql_query($sql);
		echo '<h1>Customer Testimonials</h1>';
		echo '<h3>Our products can change your life ! Trust us.</h3><br />';
		echo '<table>';//echo '<table><tr><th>Picture</th><th>Name</th><th>Message</th></tr>';
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{
			echo '<tr><td><img src="'.$row['photo'].'" height="80" width="80"></td>';
			echo '<td><b>'.$row['pseudo'].'</b></td>';
			echo '<td><i><p align="justify">'.$row['message'].'</p></i></td></tr>';
		}
		echo '</table>';
	}
	elseif(isset($_GET['page']) and $_GET['page'] === "cart")
		include("inc/cart.php");
	elseif(isset($_GET['page']) and in_array($_GET['page'],$authorized))
		include("inc/".$_GET['page'].".html");
	elseif(isset($_GET['page']) and $_GET['page'] === "admin")
		include("inc/admin.php");
	elseif(isset($_GET['page']) and $_GET['page'] === "support")
		include("inc/support.php");
	else
		include("inc/home.html");
    ?>
    </div>
</div>

</div>
<div id="footer">
	<p><a href="/" class="flogo"></a>
  </p>
	<p>Copyright © Goldpharma</p>
</div>

</body>
</html>


<?php
	mysql_close($link);
?>
