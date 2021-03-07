<?php
namespace App;

class TypeObjet {

    private $pdo;
    private $query;

    public function __construct(){
        $this->pdo = $GLOBALS['pdo'];
    }

    public function getListId(){
        $this->query = $this->pdo->prepare("select typeid, typelib from types order by typelib");
        $this->query->execute();
        $types = $this->query->fetchAll(\PDO::FETCH_ASSOC);
        $type_id=[];
        foreach ($types as $type) {
            array_push($type_id,$type['typeid']);
        }
        return $type_id;
    }

    public function getArrayList_IdLib(){
        $this->query = $this->pdo->prepare("select typeid, typelib from types order by typelib");
        $this->query->execute();
        $types = $this->query->fetchAll(\PDO::FETCH_ASSOC);
        $type_list=[];

        foreach ($types as $type) {
            array_push($type_list,array($type['typeid'],$type['typelib']));
        }

        return $type_list;

    }


}
