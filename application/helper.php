<?php
Class Helper{
    function LoadDriver($source,$file){
        require_once 'helper/'.$source.'/drivers/'.$file.".php";
       
    }
   function LoadAdaptor($source,$file){
       
        require_once 'helper/'.$source.'/adapters/'.$file.".php";
        
    }
}
