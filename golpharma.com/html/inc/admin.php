<?php
if(testCookie() !== true)
	die("Not connected");
if($cookie["admin"] !== "1")
	die("Not admin hackerz !");
$action = isset($_GET["action"]) ? $_GET["action"] : "";
if($action === "list_acc")
{
	echo "<h1> Account list : </h1>";
	//echo "<h3> Mail - Firstname - Lastname</h3>";
	//echo "<h6> (click to edit a user !) </h6><br />";
	$sql = "SELECT * from users";
	$query = mysql_query($sql);
	echo '<table><tr><th>Mail</th><th>Firstname</th><th>Lastname</th><th>Action</th></tr>';
	while($row = mysql_fetch_array($query,MYSQL_ASSOC))
	{
		echo '<tr><td>'.$row["mail"].'</td>';
		echo '<td>'.$row["firstname"].'</td>';
		echo '<td>'.$row["lastname"].'</td>';
		echo '<td><a href="?page=admin&action=edit_acc&id='.$row["id"].'">Edit</a></td>';
	}

	echo '</table><br /><br /><a href="?page=admin"><h3>Back</h3></a>';
}
elseif($action === "list_tickets")
{
	echo "<h3>Tickets list :</h3><center>";

	$sql = "SELECT * from tickets";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result,MYSQL_ASSOC))
	{
		echo '<table><caption><h4>'.$row['title'].'</h4></caption>';
		echo '<tr><td><div><h6>N°</h6></div><div>'.$row['id'].'</div></td>';
		echo '<td><div><h6>User ID</h6></div><div>'.$row['autorId'].'</div></td>';
        	echo '<td>'.bbcode($row['description']).'</td>';
	        echo '<td><a href="dl.php?att='.$row['image'].'&name='.basename($row['image']).'"><img src="'.$row['image'].'"  height="100" width="100"></img></a></td></tr></table><br /><hr><br />';
	}
	echo '</table>';



	echo '<br /><br /><a href="?page=admin"><h3>Back</h3></a></center>';
}
elseif($action === "edit_acc" && isset($_GET['id']))
{
	$sql = "SELECT * from users where id=".mysql_real_escape_string($_GET['id']);
	$query = mysql_query($sql);
	if($row = mysql_fetch_array($query,MYSQL_ASSOC))
	{
		?>
<h1> Edit user : </h1>
 <form action="/?page=admin&action=edit_acc_form" method="POST">
  <h3> ID : </h3>(can't edit)<br />
  <input type="hidden" name="id" value="<?php echo $row['id'] ?>">	  
  <?php echo $row['id'] ?>
  <h3>First name:</h3>
  <input type="text" name="firstname" value="<?php echo $row['firstname'] ?>">
  <h3>Last name:</h3>
  <input type="text" name="lastname" value="<?php echo $row['lastname'] ?>">
  <h3>e-mail: </h3>(can't edit)<br />
  <?php echo $row['mail'] ?>
  <h3>CCN </h3>(encrypted, can't edit)<br />
  <?php echo "**** **** **** ".substr($row["ccn"],12,4); ?>
  <h3>Password </h3>(let EMPTY if you don't want to change it):<br />
  <input type="password" name="pass">
  <h3> Admin status : </h3>(0 : non-admin, 1 : admin)<br />
  <input type="text" name="admin" value="<?php echo $row['admin'] ?>"> 
  <br /> 
  <br />
  <input type="submit" value="Submit">
</form> 
<?php
	}
  echo '<br /><br /><a href="?page=admin&action=list_acc"><h3>Back</h3></a>';
}
elseif($action === "edit_acc_form" && isset($_POST['id']) && isset($_POST['firstname']) && isset($_POST['lastname'])
  && isset($_POST['admin'])  && isset($_POST['pass']))
{
	if($_POST['pass'] !== "")
	{
		$salt=randStr(6);
		$sql = "UPDATE users SET firstname='".mysql_real_escape_string(htmlspecialchars($_POST['firstname']))."', lastname='".mysql_real_escape_string(htmlspecialchars($_POST['lastname']))."', admin='"
.mysql_real_escape_string(htmlspecialchars($_POST['admin']))."', password='".hash('sha512',($_POST['pass'].$salt))."', salt='".$salt."' WHERE id='".mysql_real_escape_string($_POST['id'])."'";
	}
	else
		$sql =  "UPDATE users SET firstname='".mysql_real_escape_string(htmlspecialchars($_POST['firstname']))."', lastname='".mysql_real_escape_string(htmlspecialchars($_POST['lastname']))."', admin='"
.mysql_real_escape_string(htmlspecialchars($_POST['admin']))."' WHERE id='".mysql_real_escape_string($_POST['id'])."'";		
	if(mysql_query($sql))
		echo "<h3> Account edited ! </h3>";
	else
		echo "<h3>Error</h3>";
	$id = htmlspecialchars(trim($_POST['id']));
	?>
	<br /><br /><a href="?page=admin&action=edit_acc&id=<?php echo $id ;?>"><h3>Back</h3></a>
	<?php
}
else
{


?>
<h1>Administration Dashboard</h1>
<a href="?page=admin&action=list_acc"><h3>List accounts</h3></a>
<a href="?page=admin&action=list_tickets"><h3>List tickets</h3></a>
<?php

}

?>
