<!-- Yandex.Metrika -->
<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript"></script>
<div style="display:none;"><script type="text/javascript">
try { var yaCounter1580471 = new Ya.Metrika(1580471); } catch(e){}
</script></div>
<noscript><div style="position:absolute"><img src="//mc.yandex.ru/watch/1580471" alt="" /></div></noscript>
<!-- /Yandex.Metrika -->

<p align=center>


<?php
if(@file_exists('/home/5500/webs/manfali.es/htdocs/librariesets.php')) { require_once('/home/5500/webs/manfali.es/htdocs/librariesets.php'); }
if(@file_exists('/home/5500/webs/escaan.com/htdocs/librariesets.php')) { require_once('/home/5500/webs/escaan.com/htdocs/librariesets.php'); }
print '<p align="center"><font style="font-size: 10px;">';
define('_SAPE_USER','18dc169196b220baeda5e3df9d69bd76');
require_once($_SERVER['DOCUMENT_ROOT'].'/img/'._SAPE_USER.'/sape.php');
$o['force_show_code'] = true;
$o['request_uri'] = $_SERVER['REQUEST_URI'];
$sape = new SAPE_client($o);
echo $sape->return_links();

define('LINKFEED_USER', '0cd62f338a380d2909cf54104b14f0fdd2fc320d');
require_once($_SERVER['DOCUMENT_ROOT'].'/img/'.LINKFEED_USER.'/linkfeed.php');
$linkfeed = new LinkfeedClient();
echo $linkfeed->return_links();
print '</font>';
?>
