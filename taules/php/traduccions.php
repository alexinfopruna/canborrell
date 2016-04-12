<?php
define('ROOT', "../");
require_once (ROOT . "gestor_reserves.php");
$lang = gestor_reserves::getLanguage();


include(ROOT . "../translate_web_es.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.


  foreach($translate as $k => $v){  
  echo "<li><a href='traduccions.php?k=$k'>$k</a> </li>";
  }
 */

$key = 'HISTORIA_tx21';
$val = $translate[$key];
?>
<html>
    <?php require_once (ROOT . "../head.html"); ?>


    <body>
        <h2><?php echo $key ?></h2>
        <a href="">Prev</a> | <a href="">Next</a>
        <div id="original" class="alert alert-success">
            <?php echo $val; ?>
        </div>

        <div id="source" class="alert alert-info">
            <?php echo htmlspecialchars($val, ENT_QUOTES); ?>
        </div>

        <form method="POST">
            <textarea name="angles" style="width:100%;height:250px;">
                <?php echo $val; ?>
            </textarea>

            <input type="submit" name="submit"  value="submit"  />

        </form>
        
          <iframe src="https://translate.google.es/?hl=es#ca/en/qweqwe"></iframe>


    </body>
</html>

