<?php
namespace App;

class Editeur {

    private $pdo;
    private $query;

    public function __construct(){
        $this->pdo = $GLOBALS['pdo'];
    }

    public function getListId(){
        $this->query = $this->pdo->prepare("select ediid, edinom from editeurs order by edinom");
        $this->query->execute();
        $editeurs = $this->query->fetchAll(\PDO::FETCH_ASSOC);
        $editor_id=[];
        foreach ($editeurs as $editor) {
            array_push($editor_id,$editor['ediid']);
        }
        return $editor_id;
    }

    public function getArrayList_IdNom(){
        $this->query = $this->pdo->prepare("select ediid, edinom from editeurs order by edinom");
        $this->query->execute();
        $editeurs = $this->query->fetchAll(\PDO::FETCH_ASSOC);
        $editor_list=[];

        foreach ($editeurs as $editor) {
            array_push($editor_list,array($editor['ediid'],$editor['edinom']));
        }

        return $editor_list;

    }


}
