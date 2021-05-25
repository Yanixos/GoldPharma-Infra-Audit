<?php
function bbcode($msg) // Only [img] for now
{
        $texte = preg_replace('~\[img](.*?)\[/img\]~s','<img src="$1">',$msg);
        $texte = htmlspecialchars_decode($texte,ENT_QUOTES);
        return $texte;
}
/*
	Commented since we had it in the index.php
        if(testCookie())
        {       
                // We could store others things in the future so we split with \n
                $tmp_array = explode("\n",urldecode($_COOKIE['auth']));
                for ($i = 0; $i < count($tmp_array); $i++)
                        $cookie=unserialize($tmp_array[$i]); // Todo an array
        }
*/
function testCookie()
{
    if (isset($_COOKIE['auth']) && isset($_COOKIE['mac']))
    {
        $hash = sha1(SECRET.urldecode($_COOKIE['auth']));
        if($hash === $_COOKIE['mac'])
                return true;
    }
    return false;
}       
function randStr($len)
{

        $charset="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $charsetLen=strlen($charset) - 1;
        $random = array();
        for($i = 0;$i < $len;$i++)
                $random[$i] = $charset[mt_rand(0,$charsetLen)]; 
        return implode($random);
}
?>
