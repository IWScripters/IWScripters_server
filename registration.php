<?php
include "php/apikey.php";
include "php/OpenId.php";

$OpenID= new LightOpenID("rootcorp.ddns.net");
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
		header("Location: registration.php");
	}
}
if(isset($_SESSION['T2SteamAuth']))
{
	$steam = json_decode(file_get_contents("cache/".$_SESSION['T2SteamID64'].".json"));
	$login = "<div id='login'><a href='?logout'>Logout</a></div>";
}
if(isset($_GET['logout']))
{
	unset($_SESSION['T2SteamAuth']);
	unset($_SESSION['T2SteamID64']);
	header("Location: registration.php");
}
?>
<!DOCTYPE html>
<html class="html" lang="ru-RU">
 <head>

  <script type="text/javascript">
   if(typeof Muse == "undefined") window.Muse = {}; window.Muse.assets = {"required":["jquery-1.8.3.min.js", "museutils.js", "jquery.musemenu.js", "jquery.watch.js", "registration.css"], "outOfDate":[]};
</script>
  
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
  <meta name="generator" content="2015.0.2.310"/>
  <title>REGISTRATION</title>
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="css/site_global.css?4052507572"/>
  <link rel="stylesheet" type="text/css" href="css/master_c-side.css?3925551639"/>
  <link rel="stylesheet" type="text/css" href="css/registration.css?349822274" id="pagesheet"/>
  <!-- Other scripts -->
  <script type="text/javascript">
   document.documentElement.className += ' js';
  </script>
  <!-- JS includes -->
  </head>
<body>
<?php
if(isset($_SESSION['T2SteamAuth'])){
	echo "<img src='".$steam->response->players[0]->avatarfull."'>";
}
echo "<br>".$login."<br>";
?>
  <div class="shadow rgba-background clearfix" id="page"><!-- column -->
   <div class="position_content" id="page_position_content">
    <nav class="MenuBar clearfix colelem" id="menuu371"><!-- horizontal box -->
     <div class="MenuItemContainer clearfix grpelem" id="u379"><!-- vertical box -->
      <a class="nonblock nontext MenuItem MenuItemWithSubMenu clearfix colelem" id="u380" href="index.html"><!-- horizontal box --><div class="MenuItemLabel NoWrap grpelem" id="u381-4"><!-- rasterized frame --><div id="u381-4_clip"><img id="u381-4_img" alt="HOMEPAGE" width="227" height="36" src="images/homepage4.png"/></div></div></a>
     </div>
     <div class="MenuItemContainer clearfix grpelem" id="u393"><!-- vertical box -->
      <a class="nonblock nontext MenuItem MenuItemWithSubMenu clearfix colelem" id="u394" href="products.html"><!-- horizontal box --><div class="MenuItemLabel NoWrap grpelem" id="u396-4"><!-- rasterized frame --><div id="u396-4_clip"><img id="u396-4_img" alt="PRODUCTS" width="227" height="36" src="images/products4.png"/></div></div></a>
     </div>
     <div class="MenuItemContainer clearfix grpelem" id="u386"><!-- vertical box -->
      <a class="nonblock nontext MenuItem MenuItemWithSubMenu MuseMenuActive clearfix colelem" id="u387" href="registration.php"><!-- horizontal box --><div class="MenuItemLabel NoWrap grpelem" id="u390-4"><!-- rasterized frame --><div id="u390-4_clip"><img id="u390-4_img" alt="REGISTRATION" width="228" height="36" src="images/registration4.png"/></div></div></a>
     </div>
     <div class="MenuItemContainer clearfix grpelem" id="u372"><!-- vertical box -->
      <a class="nonblock nontext MenuItem MenuItemWithSubMenu clearfix colelem" id="u373" href="about-us.html"><!-- horizontal box --><div class="MenuItemLabel NoWrap grpelem" id="u376-4"><!-- rasterized frame --><div id="u376-4_clip"><img id="u255-4_img" alt="ABOUT US" width="228" height="36" src="images/aboutus4.png"/></div></div></a>
     </div>
    </nav>
    <div class="verticalspacer"></div>
   </div>
  </div>
  <!-- JS includes -->
  <script type="text/javascript">
   if (document.location.protocol != 'https:') document.write('\x3Cscript src="http://musecdn2.businesscatalyst.com/scripts/4.0/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script type="text/javascript">
   window.jQuery || document.write('\x3Cscript src="scripts/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script src="javascript/museutils.js?275725342" type="text/javascript"></script>
  <script src="javascript/jquery.musemenu.js?4042164668" type="text/javascript"></script>
  <script src="javascript/jquery.watch.js?3999102769" type="text/javascript"></script>
  <!-- Other scripts -->
  <script type="text/javascript">
   $(document).ready(function() { try {
(function(){var a={},b=function(a){if(a.match(/^rgb/))return a=a.replace(/\s+/g,"").match(/([\d\,]+)/gi)[0].split(","),(parseInt(a[0])<<16)+(parseInt(a[1])<<8)+parseInt(a[2]);if(a.match(/^\#/))return parseInt(a.substr(1),16);return 0};(function(){$('link[type="text/css"]').each(function(){var b=($(this).attr("href")||"").match(/\/?css\/([\w\-]+\.css)\?(\d+)/);b&&b[1]&&b[2]&&(a[b[1]]=b[2])})})();(function(){$("body").append('<div class="version" style="display:none; width:1px; height:1px;"></div>');
for(var c=$(".version"),d=0;d<Muse.assets.required.length;){var f=Muse.assets.required[d],g=f.match(/([\w\-\.]+)\.(\w+)$/),k=g&&g[1]?g[1]:null,g=g&&g[2]?g[2]:null;switch(g.toLowerCase()){case "css":k=k.replace(/\W/gi,"_").replace(/^([^a-z])/gi,"_$1");c.addClass(k);var g=b(c.css("color")),h=b(c.css("background-color"));g!=0||h!=0?(Muse.assets.required.splice(d,1),"undefined"!=typeof a[f]&&(g!=a[f]>>>24||h!=(a[f]&16777215))&&Muse.assets.outOfDate.push(f)):d++;c.removeClass(k);break;case "js":k.match(/^jquery-[\d\.]+/gi)&&
typeof $!="undefined"?Muse.assets.required.splice(d,1):d++;break;default:throw Error("Unsupported file type: "+g);}}c.remove();if(Muse.assets.outOfDate.length||Muse.assets.required.length)c="Некоторые файлы на сервере могут отсутствовать или быть некорректными. Очистите кэш-память браузера и повторите попытку. Если проблему не удается устранить, свяжитесь с разработчиками сайта.",(d=location&&location.search&&location.search.match&&location.search.match(/muse_debug/gi))&&Muse.assets.outOfDate.length&&(c+="\nOut of date: "+Muse.assets.outOfDate.join(",")),d&&Muse.assets.required.length&&(c+="\nMissing: "+Muse.assets.required.join(",")),alert(c)})()})();
/* body */
Muse.Utils.transformMarkupToFixBrowserProblemsPreInit();/* body */
Muse.Utils.prepHyperlinks(true);/* body */
Muse.Utils.initWidget('.MenuBar', function(elem) { return $(elem).museMenu(); });/* unifiedNavBar */
Muse.Utils.fullPage('#page');/* 100% height page */
Muse.Utils.showWidgetsWhenReady();/* body */
Muse.Utils.transformMarkupToFixBrowserProblems();/* body */
} catch(e) { if (e && 'function' == typeof e.notify) e.notify(); else Muse.Assert.fail('Error calling selector function:' + e); }});
</script>
   </body>
</html>
