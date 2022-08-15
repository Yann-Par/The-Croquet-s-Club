<?php

namespace Models;

abstract class Database
{
    private static $_dbConnect;
    
    
    //connexion a la base de données dans php my admin
    private static function setDb()
    {
        self::$_dbConnect = new \PDO('mysql:host=db.3wa.io;dbname=yannparis_croquett;charset=utf8','yannparis','cksbcbdskcbcsdbkscbksbc');
        self::$_dbConnect->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
    }
    
    
    
    //fonction qui va permettre de recuperer la connexion a la base de donnée dans chaque nouvelle requettes dans les models
    protected function getDb()
    {
        if( self::$_dbConnect === null)
        {
            self::setDb();
        }
        return self::$_dbConnect;
    }
}