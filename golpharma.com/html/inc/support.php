<?php
if(testCookie() !== true)
	die("Not connected");
?>
<html>
<head>
<title>Support</title>
</head>
<body>
<h3>Customer Support</h3><br />
<form action="index.php?page=support" method="post" enctype="multipart/form-data">

<h4>Title</h4><input type="text" name="title" placeholder="Title for your ticket" maxlength="20" /><br />
<br /><h4>Message</h4><textarea name="message" placeholder="Describe your issue" width="80" height="100" maxlength="500" /></textarea><br />
<br /><h4>File</h4><h6>(jpeg,png,exe)</h6><input type="file" name="file" /><br />
<br /><input type="submit" name="submit" value="Submit"><br />
<input type="submit" name="prev" value="Preview">
</form>
<h3>You can now use [img] BBCode balise !</h3>
</body>
</html>
<?php
$title = mysql_real_escape_string(htmlspecialchars(trim($_POST['title'])));
$msg = htmlspecialchars(trim($_POST['message']));
$cook = mysql_real_escape_string(htmlspecialchars(trim($cookie['id'])));
$submit = $_POST['submit'];
if(isset($_POST['prev']) && !empty($title) && !empty($msg)  && !empty($cook))
{
	echo "<h3>Preview : </h3>";
	echo "<h3>Title : ".$title."</h3>";
	echo "<h3>Message : ".bbcode($msg)."</h3>";
}
elseif(isset($submit) && !empty($title) && !empty($msg)  && !empty($cook))
{
	$msg=mysql_real_escape_string($msg);
	$dir = "uploads/";
	$imageType = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
	if(isset($submit))
	{
		$check = getimagesize($_FILES['file']['tmp_name']);
		if($check !== false)
		{
			if($_FILES['file']["size"] < 5000000)
			{
				if($imageType == "jpg" || $imageType == "png" || $imageType == "jpeg" || $imageType == "gif")
				{
					$file = $dir.$file.randStr(32).".".$imageType;		
					if(move_uploaded_file($_FILES['file']["tmp_name"], $file))
					{
						$sql = mysql_query("INSERT INTO tickets (title,description,image,autorId) VALUES ('$title','$msg','$file','$cook')");
					        echo 'Your issue has been successfully submitted';
					}
				}
			}
		}
	}
	//$sql = mysql_query("INSERT INTO tickets (title,description,image,autorId) VALUES ('$title','$msg','$file','$cook')");
	//echo 'Your issue has been successfully submitted';
}
else
{
	echo '<font color="red"><b>You must fill out each fields</b></font>';
}

?>

