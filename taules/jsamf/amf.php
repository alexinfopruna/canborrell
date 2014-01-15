<?php

define('AMFPHP_BASE', '../amfphp/core/');
define('ROOT', '../');
if (!isset($_SESSION))   session_start();
/*
require_once( '../amfphp/core/amf/app/Gateway.php');
require_once( AMFPHP_BASE . 'amf/io/AMFSerializer.php');
require_once( AMFPHP_BASE . 'amf/io/AMFDeserializer.php');
*/

//print "AKIII";
/*
require 'SabreAMF/Client.php';
//header('Content-Type: ' . SabreAMF_Const::MIMETYPE);

$obj=array();

$client = new SabreAMF_Client('http://cb.localhost/taules/amfphp/gateway.php?session_id='. session_id()); 
$client->setEncoding(3);
//print "TORNAM ";
$amf= $client->sendRequest('ControlTaules.recuperaUsuari',$obj);
//print "TORNAM2 ";
//print_r ($amf);
*/

/* 
print_r($usr);
$amf = new AMFObject($usr);

$deserializer = new AMFDeserializer($amf->rawData);
$deserializer->deserialize($amf);    

 
//require_once('../amfphp/services/vo/com/canBorrell/UsuariVO.php');
$usr=new UsuariVO(0,'pepe','lopez');
$serializer = new AMFSerializer();
$serializer->serialize($usr);
 
echo $serializer->outBuffer;
*/
function rp()
{
	include_once 'SabreAMF/AMF3/Serializer.php';
	include_once 'SabreAMF/AMF3/Deserializer.php';
	include_once 'SabreAMF/OutputStream.php';
	include_once 'SabreAMF/InputStream.php';
	include_once 'SabreAMF/TypedObject.php';
	include_once 'SabreAMF/ClassMapper.php';
	
	/************DECODER****************//*/
	SabreAMF_ClassMapper::registerClass('FLASH_CLASS_NAME','PHP_CLASS_NAME'); //CLASSES SHOULD BE SAME
	$inputStream = new SabreAMF_InputStream($buffer);
	$des = new SabreAMF_AMF3_Deserializer($inputStream);
	$obj = $des->readAMFData();
	//$obj will contain the instance of PHP_CLASS_NAME with the properties set as the values sent by Flex/Flash
	/************END DECODER*****************/
	
	/**************ENCODER******************/
require_once('../amfphp/services/vo/com/canBorrell/UsuariVO.php');
$usr=new UsuariVO(0,'pepe','lopez');
	
	$classObj = new UsuariVO(0,'pepe','lopez');	 //PHP_CLASS is your class
	$object = new SabreAMF_TypedObject('UsuariVO',$classObj); //FLASH_CLASS_NAME IS NAME OF CLASS AVAILABLE TO FLASH FOR MAPPING
	$outputStream = new SabreAMF_OutputStream();
	$serializer = new SabreAMF_AMF3_Serializer($outputStream);
	$serializer->writeAMFData($object);
	$output = $outputStream->getRawData();
	//$output is AMF Encoded string to be sent to FLEX/FLASH.
	/***********END ENCODER***************/
	
        header('Content-Type: ' . SabreAMF_Const::MIMETYPE);
        
	return $output;
}

function sendResponse(){
        $doto=$data = array(array("name"=>"joe","directory"=>"/home/ 
 joe","id"=>"33"),array("name"=>"lolo","directory"=>"/home/ 
 lolo","id"=>"34"));

        include ('SabreAMF/OutputStream.php');
        include ('SabreAMF/AMF3/Serializer.php');

        $amfOutputStream = new SabreAMF_OutputStream();
        $amfSerializer = new SabreAMF_AMF3_Serializer($amfOutputStream);
        header('Content-Type: ' . SabreAMF_Const::MIMETYPE);
        $amfSerializer->writeAMFData($data);
	
        return ($amfOutputStream->getRawData());
 }
echo rp();
//echo sendResponse();
?>
