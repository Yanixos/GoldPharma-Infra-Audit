<?php
include("inc/utils.php");
include("inc/config.php");
if(testCookie() === true)
{
                // We could store others things in the future so we split with \n
                $tmp_array = explode("\n",urldecode($_COOKIE['auth']));
                for ($i = 0; $i < count($tmp_array); $i++)
                        $cookie=unserialize($tmp_array[$i]); // Todo an array
}
else
        die("Not connected");
if($cookie["admin"] !== "1")
        die("Not admin hackerz !");

if(isset($_GET['att']) && isset($_GET['name']))
{
       header('Content-Type: application/download');
       header('Content-Disposition: attachment; filename="'.$_GET['name'].'"');
       echo file_get_contents("./".$_GET['att']);
}

?>

