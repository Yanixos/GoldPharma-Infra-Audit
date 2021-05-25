<?php
unset($_COOKIE['auth']);
setcookie("auth", "", time()-3600,  "");
unset($_COOKIE['mac']);
setcookie("mac", "", time()-3600,  "");
header('Location: index.php');
?>
