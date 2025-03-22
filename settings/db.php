<?php
 function database(){
    try{
        $req = new PDO("mysql:host=localhost;dbname=manya",'root','');
        $req->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $req->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        return $req;

    }catch(PDOException $e){
        echo "Erreur ".$e->getMessage();
    }
 }