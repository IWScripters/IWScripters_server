<?php
include "apikey.php";
include "OpenId.php";

$OpenID= new LightOpenID("localhost");
$login = "";

session_start();

if(!$OpenID->mode)
{
    if(isset($_GET['login']))
    {
        $OpenID->identity = "http://steamcommunity.com/openid";
        header("Location: ".$OpenID->authUrl());
    }
    if (!isset($_SESSION['T2SteamAuth']))
    {
        $login = "<div id='login'>Sign in through Steam<a href='?login'><img src='http://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_large_noborder.png'></a> to 'Website Action'.</div>";
    }
}
elseif($OpenID->mode == "cancel") {
    echo "You have canceled an authentication";
} else {
    if (!isset($_SESSION['T2SteamAuth']))
    {
        $_SESSION['T2SteamAuth'] = $OpenID->validate() ? $OpenID->identity : null;
        $_SESSION['T2SteamID64'] = str_replace("http://steamcommunity.com/openid/id/","",$_SESSION['T2SteamAuth']);

        if($_SESSION['T2SteamAuth'] !== null)
        {
            $Steam64 = str_replace("http://steamcommunity.com/openid/id/","",$_SESSION['T2SteamAuth']);
            $profile = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v002/?key=".$api."&steamids=".$Steam64);
            $buffer = fopen("cache/".$Steam64.".json","w+");
            fwrite($buffer, $profile);
            fclose($buffer);
        }
        header("Location: index.php");
    }
}
if(isset($_SESSION['T2SteamAuth']))
{
    $login = "<div id='login'><a href='?logout'></div>";
}
if(isset($_GET['logout']))
{
    unset($_SESSION['T2SteamAuth']);
    unset($_SESSION['T2SteamID64']);
    header("Location: index.php");
}
$steam = json_decode(file_get_contents("cache/{$_SESSION['T2SteamID64']}.json"));
echo $login;
echo "<img src='".$steam->response->players[0]->avatarfull."'>";
