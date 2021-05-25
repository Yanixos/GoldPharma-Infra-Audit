<?php
if(testCookie() === true && isset($_GET['page']) && $_GET['page'] === "cart")
{
	if(isset($_GET['art']))
	{
		echo "<h3> Article added in cart ! </h3>";
		if(isset($cookie["cart"][$_GET['art']]))
			$cookie["cart"][$_GET['art']]+=1;
		else
			$cookie["cart"][$_GET['art']] = 1;
		setcookie("auth", urlencode(serialize($cookie)), time()+3600, "");
                setcookie("mac", sha1(SECRET.serialize($cookie)), time()+3600, "");
		echo '<h3><a href="?page=articles"> Back </a></h3>';
	}
	elseif(isset($_GET['empty']) && $_GET['empty'] === "true")
	{
		$cookie["cart"] = array();
                setcookie("auth", urlencode(serialize($cookie)), time()+3600, "");
                setcookie("mac", sha1(SECRET.serialize($cookie)), time()+3600, "");
		echo "<h3>Cart is now empty ! </h3>";
	}
	else
	{
		echo "<h3> Articles : </h3>";
		echo '<table>';
		foreach($cookie["cart"] as $art => $nb)
		{
	                echo '<tr><td>'.$art.'</td>';
                        echo '<td>'.$nb.'</td>';
                        echo '</tr>';

		}
		echo '</table>';
		echo '<h3><a href="?page=cart&empty=true">Empty this damn cart</a></h3>';
	}

}
else
	die("Error yo !");
?>
