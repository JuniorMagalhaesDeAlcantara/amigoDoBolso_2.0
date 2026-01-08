<?php

class Model
{
    protected ;
    protected ;

    public function __construct()
    {
        ->db = Database::getInstance()->getConnection();
    }

    public function findAll()
    {
         = ->db->query(""SELECT * FROM {->table}"");
        return ->fetchAll();
    }

    public function findById()
    {
         = ->db->prepare(""SELECT * FROM {->table} WHERE id = ?"");
        ->execute([]);
        return ->fetch();
    }

    public function create()
    {
         = implode(', ', array_keys());
         = ':' . implode(', :', array_keys());

         = ""INSERT INTO {->table} () VALUES ()"";
         = ->db->prepare();

        foreach ( as  => ) {
            ->bindValue("":"", );
        }

        ->execute();
        return ->db->lastInsertId();
    }

    public function update(, )
    {
         = [];
        foreach ( as  => ) {
            [] = "" = :"";
        }
         = implode(', ', );

         = ""UPDATE {->table} SET  WHERE id = :id"";
         = ->db->prepare();

        ->bindValue(':id', );
        foreach ( as  => ) {
            ->bindValue("":"", );
        }

        return ->execute();
    }

    public function delete()
    {
         = ->db->prepare(""DELETE FROM {->table} WHERE id = ?"");
        return ->execute([]);
    }
}
