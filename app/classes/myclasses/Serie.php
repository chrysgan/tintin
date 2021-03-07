<?php
namespace App;

class Serie {

    private $pdo;
    private $query;

    public function __construct(){
        $this->pdo = $GLOBALS['pdo'];
    }

    public function getListId(){
        $this->query = $this->pdo->prepare("select serid from series");
        $this->query->execute();
        $series = $this->query->fetchAll(\PDO::FETCH_ASSOC);
        $serie_list_id=[];
        foreach ($series as $serie) {
            settype($serie['serid'],"int");
            array_push($serie_list_id,$serie['serid']);
        }
        return $serie_list_id;
    }

    public function getArrayList_IdNom(){
        $this->query = $this->pdo->prepare("select serid, sernom from series order by sernom");
        $this->query->execute();
        $series = $this->query->fetchAll(\PDO::FETCH_ASSOC);
        $serie_arraylist_idnom=[];

        foreach ($series as $serie) {
            settype($serie['serid'],"int");
            array_push($serie_arraylist_idnom,array($serie['serid'],$serie['sernom']));
        }
        return $serie_arraylist_idnom;

    }


}
