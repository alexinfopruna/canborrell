<?php
//echo "Multilang...";die();

if (!defined("GESTOR")){
            if (!defined('ROOT'))  define('ROOT', "taules/");
            require_once (ROOT."gestor_reserves.php");  
            
            $lang = gestor_reserves::getLanguage();
            //$lang = 'es';
}

require_once("translate_web_$lang.php");
$fnl = 'lv';

$ls = array(
  'ca' => 'cat',
  'cat' => 'cat',
  'es' => 'cat',
  'esp' => 'cat',
  'en' => 'en',
  'eng' => 'en',
);

$ruta = '';
if (!isset($_REQUEST['page']))
  $_REQUEST['page'] = 'index.html';
if (!strstr($_REQUEST['page'], '.'))
  $_REQUEST['page'] .='.html';

$ruta .= $_REQUEST['page'];
if (!file_exists($ruta)) {
  header("Location: /404.html");
}
?>
<html>
    <head>
<?php 
include("head.html"); 
include($ruta);
?>
        <style scoped>
        header{
            background-image: url('../img/fons_<?php echo $bg_id;?>a.jpg');
        }

        #cos{
            background-image: url('../img/fons_<?php echo $bg_id;?>b.jpg');
        }

        #content{
            background-image: url('../img/fons_<?php echo $bg_id;?>c.jpg');
        }
    </style>
            
    </head>
    <body><p class="pull-right visible-xs">
          </p>
  
        <div id="container">
            <div class="row row-offcanvas row-offcanvas-left">
                <?php include("header.html"); ?>
                <div id="cos">
                    <?php include("submenu.html"); ?>
                    

                    <div id="content" class="content col-md-10">
                        <!----------------------------------------------------------------------------------------->
                        <!----------------------------------------------------------------------------------------->
                        <!----------------------------------------------------------------------------------------->
                        <!----------------------------------------------------------------------------------------->
                        <!----------------------------------------------------------------------------------------->
                        <!----------------------------------------------------------------------------------------->
                        <!----------------------------------------------------------------------------------------->
                        <?php
                        echo $html;
                        ?>
                        <!----------------------------------------------------------------------------------------->
                        <!----------------------------------------------------------------------------------------->
                        <!----------------------------------------------------------------------------------------->
                        <!----------------------------------------------------------------------------------------->
                        <!----------------------------------------------------------------------------------------->
                        <!----------------------------------------------------------------------------------------->
                        <!----------------------------------------------------------------------------------------->
                    </div> 
                    <div class="c-b"></div> 
                </div>

<?php include("footer.html"); ?>
            </div> <!-- row -->
        </div> <!-- container -->
    </body>
</html>
