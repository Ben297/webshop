<?php

class View
{

    private $path = '\xampp\htdocs\webshop\src\templates';
    private $template = 'default';

    private $_ = array();

    // Weißt dem aktuellen Objekt key: value: zu

    public function assign($key, $value){
        $this->_[$key] = $value;
    }

    // Wählt das Template aus - default-value = default_old.php (Standard-Template)

    public function setTemplate($template = 'default'){
        $this->template = $template;
    }

    // Zur einfacheren Ausgabe von Werten bei der Entwicklung - Nicht wichtig

    public function alert($msg){
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }


    public function loadTemplate(){
        //weißt $tpl den wert der variable template zu (standard: default)
        $tpl = $this->template;
        // in der file variable wird der pfad zum file zusmammengesetzt: \xampp\htdocs\webshop\src\template + \ + default + .php
        $file = $this->path . DIRECTORY_SEPARATOR . $tpl . '.php';
        // wenn die datei existiert dann ...
        $exists = file_exists($file);
        if ($exists){

            //puffern der datein
            ob_start();

            include $file;
            // schreibe den puffer in die variable output
            $output = ob_get_contents();

            //lösche den puffer
            ob_end_clean();

            // gibt die datei zurück - der inhalt wird gerendert
            return $output;
        }
        else {
            return 'could not find template' . ' --- '  . $file . ' --- ' . $exists ;
        }
    }

}