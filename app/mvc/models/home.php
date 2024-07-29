<?php

// chargement des données du dernier objet créé ou mis à jour
$query = $pdo->prepare("
select o.objnom, o.objid , o.ediid, o.serid, e.edinom, t.typecode, 
    date(case when o.objdatecreation>coalesce(objdateupdate,date_add(current_timestamp(), interval -50000 day )) then o.objdatecreation else o.objdateupdate end) dateCRUD
from objets o
inner join editeurs e on e.ediid = o.ediid
inner join types t on o.typeid = t.typeid
where (case when o.objdatecreation>coalesce(objdateupdate,date_add(current_timestamp(), interval -50000 day )) then o.objdatecreation else o.objdateupdate end) =
(SELECT case when max(objdatecreation) > max(objdateupdate) then max(objdatecreation) else max(objdateupdate) end date_max
FROM objets  )
order by case when objdatecreation>objdateupdate then objdatecreation else objdateupdate end desc;
");
$query -> execute();
$resulset = $query->fetchAll(PDO::FETCH_ASSOC);
$objet = $resulset[0];

?>
