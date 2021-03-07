<?php
namespace App;

class Personnage {

    private $pdo;
    private $query;

    public function __construct(){
        $this->pdo = $GLOBALS['pdo'];
    }

    public function getArrayList_IdAlias(){
        $this->query = $this->pdo->prepare("select persid, persalias from personnages order by persalias");
        $this->query->execute();
        $resultset = $this->query->fetchAll(\PDO::FETCH_ASSOC);
        $pers_list=[];

        foreach ($resultset as $pers) {
            array_push($pers_list,array('persid'=>$pers['persid'],'persalias'=>$pers['persalias']));
        }

        return $pers_list;

    }


}
