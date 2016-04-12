<?php

if (!isset($lang)) {

  if (!defined('ROOT'))
    define('ROOT', "taules/");
  require_once (ROOT . "gestor_reserves.php");
  //$g = new gestor_reserves();
  $lang = gestor_reserves::getLanguage();
}
require_once("translate_menu_$lang.php");

$actiu = array(
  'canborrell' => array('canborrell'),
  'fotos' => array('fotos(.*)', 'video'),
  'plats' => '',
  'on' => '',
  'excursions' => array('excursio(.*)', 'infomenus', 'suggeriments'),
  'historia' => 'historia(.*)',
  'horaris' => '',
  'form' => '',
  'premsa' => '',
  'premsa' => '',
  'premsa' => '',
);

$main_menu_elements = array(
  array('link' => 'canborrell', 'txt' => 'CAN BORRELL'),
  array('link' => 'fotos', 'txt' => 'FOTOS-VIDEO'),
  array('link' => 'plats', 'txt' => 'CARTA I MENU'),
  array('link' => 'on', 'txt' => 'ON SOM: MAPA'),
  array('link' => 'excursions', 'txt' => 'EXCURSIONS'),
  array('link' => 'historia', 'txt' => 'HISTORIA'),
  array('link' => 'premsa', 'txt' => 'PREMSA'),
  array('link' => 'horaris', 'txt' => 'HORARI'),
  array('link' => 'reservar', 'txt' => 'RESERVES'),
);

/* * *************************************** */

/**
 * Determina quin menú està actiu
 * @param type $desti
 */
function active($desti, $lang = 'ca') {
  global $actiu;
  $class = "";


  if (!isset($actiu[$desti]))
    $actiu[$desti] = '';

  $parts = pathinfo($_SERVER['REQUEST_URI']);
  $filename = $parts['filename'];
  $filename = preg_split('/(?=\.[^.]+$)/', $filename);
  $filename = $filename[0];

  $v = $actiu[$desti];
  if (empty($v)) {
    $match = ($desti == $filename);
  }
  else {
    $regex = !is_array($v) ? $v : '(' . implode('|', $v) . ')';
    $match = preg_match('/' . $regex . '/i', $filename);
  }

  if ($match) {
    $class = 'menu-active';
  }

  return $match;
  //return '<a href="/'.$lang.'/' .  $desti . '" class="' . $class . '" >'."  ";
}

/* * ******************************************************************************* */
/* * ******************************************************************************* */

function main_menu($elements, $lang) {
  $n = 0;
  $menu = '';
  $menu .= '<ul class= "  nav navbar-nav  collapse navbar-collapse">';

  foreach ($elements as $k => $v) {
    $n++;
    //$class = active($v['link'], $lang) ? 'menu-active' : '';
    $class = active($v['link'], $lang) ? 'active' : '';
    //$menu .= '<li class="menu-element menu menu1' . $n . ' ' . $class . '">';
    $menu .= '<li class="' . $class . '">';


    $menu .='<a href="/' . $lang . '/' . $v['link'] . '" class="' . $class . '" >' . "  ";
    $menu .= l($v['txt'], FALSE);
    $menu .= '</a>';
    $menu .= '</li>';
  }

  $menu .= '</ul>';

  return $menu;
}

/* * ******************************************************************************* */
/* * ******************************************************************************* */

function sub_menu($elements, $lang) {
  $n = 0;
  $submenu = '';
  $submenu .= '<ul id="submenu" class="submenu submenu-1">';

  foreach ($elements as $k => $v) {
    $n++;
    $class = active($v['link'], $lang) ? 'menu-active' : '';
    $submenu .= '<li class="submenu-element sml1 sm1' . $n . ' ' . $class . '">';
    $submenu .= '<a href="' . $v['link'] . '"  class="submenu-link sml1 sm1' . $n . '">';
    $submenu .= $v['txt'];
    $submenu .= '</a>';
    $submenu .= '</li>';
  }

  $submenu .= '</ul>';

  return $submenu;
}

/* * ******************************************************************************* */
/* * ******************************************************************************* */
/* MENU IDIOMES
 */

function menu_idiomes() {
  $match = preg_match('/' . '^\/?(ca|en|es)(.*)$' . '/i', $_SERVER['REQUEST_URI'], $matches);
  if (!$s = sizeof($matches))
    $url = "";
  else
    $url = $matches[$s - 1];


  $out = <<<EOT
      
   <div id="language-menu" style="">
        <a href="/ca$url">ca</a> | 
        <a href="/es$url">es</a> | 
        <a href="/en$url">en</a>
</div>   
EOT;

  return $out;
}

/* * ******************************************************************************* */
/* * ******************************************************************************* */
/* * ******************************************************************************* */
/* * ******************************************************************************* */
//if (!isset($cb_printed_menu)) echo main_menu($main_menu_elements, $lang);
$cb_printed_menu = TRUE;
?>