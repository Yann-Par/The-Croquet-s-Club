<?php

namespace Models;

class Connect extends DataBase
{
    
    
    // se connecter grace a l'identification du mail
    public function getConnect($mail)
    {
        $query = $this->getDB()->prepare(
            "
                SELECT *
                FROM users
                WHERE mail = ?
            ");
        $query->execute([$mail]);
        return $query->fetch();
    }
}




?>