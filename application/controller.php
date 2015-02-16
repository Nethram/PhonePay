<?php 
include 'application/optimiser.php';
include 'application/config.php';
if(empty(Config::$installed)){
	header('location:install');
}


include 'library/media.php';
include 'library/security.php';
include 'application/dbmodel.php';
include 'application/helper.php';




class Controller{
    public $controller='';
    public $parameters='';
    public $method='index';
    public $view='';
    public    static $urlPara;
    public function __construct(){
       new Optimiser;
       
    }
    //function set base url
    function setBaseUrl(){
      $base_url= Config::$base_url;
       if(empty($base_url)){
	$base_url='http://'.$_SERVER['HTTP_HOST'];
	}
        define("base_url",$base_url);  
    }
   //set url para accessible
   function urlPara(){
       if(isset(Controller::$urlPara)){
           $params=new ArrayObject(Controller::$urlPara);
           return $params;
       }
   }
    //getting url parameters
    private function parsePath() {
        $path = array();
        if (isset($_SERVER['REQUEST_URI'])) {
        $req_url=url_para_filter($_SERVER['REQUEST_URI']);
        $request_path = explode('?', $req_url);
        $path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
        $path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
        $path['call'] = utf8_decode($path['call_utf8']);
        if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
        $path['call'] = ''; }
        $path['call_parts'] = explode('/', $path['call']);
        }
        return $path; }
 //gte controller name and url parameters
 function getControllerName(){
     $pathInfo=  $this->parsePath();
     if(!empty($pathInfo['call_parts'])){
     $path=$pathInfo['call_parts'];
     for($n=0;$n<sizeof($path);$n++){
         $path[$n]=url_para_filter($path[$n]);
     }
     $extn=mb_substr($path[$n-1], -4);
        if($extn && $extn!=Config::$url_tail){
            $this->loadError();
          }
     $path[$n-1]=str_replace($extn,'', $path[$n-1]);
     if($path[0]=='index.php'){$path=  array_slice($pathInfo['call_parts'],1);}
     $this->controller=$path[0];
     
     if(!$this->checkFile($this->controller,Config::$dir_controllers)){
            $this->controller=  Config::$defualt_controller;
            $this->parameters=$path;
        }else{
            $this->parameters= array_slice($path,1);
        }
     
     }
     if(empty($this->controller)){
         $this->controller=  Config::$defualt_controller;
     }
     
   }
//load chosen controller and sets parameter and method
    function loadBaseController(){
        $this->getControllerName();
        
        $this->load($this->controller,Config::$dir_controllers);
        if(!class_exists($this->controller)){
            die("No class defined as ".$this->controller);
        }
        $methods=get_class_methods($this->controller); 
        if(isset($this->parameters[0])){
        if(in_array($this->parameters[0], $methods)){
            $this->method=$this->parameters[0];
            $this->parameters= array_slice($this->parameters,1);
        }      }
    }
//set method parameter and url parametrs
    function setParameters(){
        if(!empty($this->parameters)){
            Controller::$urlPara=$this->parameters;
        }
    }
//start site
    function startSite(){
        $this->setBaseUrl();
        $this->loadBaseController();
        $this->setParameters();
        $c=  $this->controller;
        $m=  $this->method;
        if(class_exists($c)){
        $b=new $c;
        $b->$m($this->view);
        }
    }
 
 //check file
   function checkFile($file,$dir){
    $file=$file.'.php';   
    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $name => $object){
    if (strpos($name,$file) !== false) {
        return TRUE;
        }   }
   }
    //load file
    private function load($file,$dir,$data=''){
      $file=$file.'.php';
      $selected='';
   $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $name => $object){
    if (strpos($name,$file) !== false) {
        $selected=$name;
        }   }
    if(!empty($selected)){        include $selected;}
 else {
    $this->loadError(); }
}

//load error
function loadError(){
   // include Config::$dir_controllers.'/error.php';
    header("location:".Config::$base_url."/error".Config::$url_tail);  
    
}
//load view
    function loadView($file,$data=''){
        $dir=  Config::$dir_views;
        $this->load($file, $dir,$data);
    }
 
 //loading model
 function loadModel($file){
     $dir=  Config::$dir_models;
     $this->load($file,$dir);
     $obj=$file;
     $$obj=new $file;
 }
//loading helper
 function loadHelper($file){
     $dir=  Config::$dir_helper;
     $this->load($file,$dir);
     $file=new $file;
 }
//this sets url parameter limit, if limit exeeds, loads error
function urlLimit($count){
    if(sizeof($this->urlPara()) > $count)
    {
        $this->loadError();
    }
}

 //end of class
        }



$site=new Controller();
$site->startSite();
