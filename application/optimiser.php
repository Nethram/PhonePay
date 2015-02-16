<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Optimiser{
    private static $instance;
    public function __construct()
    {
        if (!self::$instance)
        {
        self::$instance = $this;
        return self::$instance;
        }
         else 
        {
        return self::$instance;
        }
    }


    
}