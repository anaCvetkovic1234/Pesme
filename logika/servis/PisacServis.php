<?php

class ZanrServis{
    private $broker;
    
    public function __construct($b){
        $this->broker=$b;
    }

    public function vratiSve(){
        return $this->broker->ucitajKOlekciju("select * from pisac");
    }
    public function kreiraj($pisacDto){
        $this->broker->upisi("insert into pisac(ime,prezime,godina_rodjenja) values ('".
                                $pisacDto['ime']."',''".$pisacDto['prezime'].",".$pisacDto['godinaRodjenja'].")");
        $id=  $this->broker->getLastId();
        return   $this->broker->ucitajJedan("select * from pisac where id=".$id);
    }

    public function izmeni($id,$pisacDto){
        $this->broker->upisi("update pisac set ime='".$pisacDto['ime'].
                                "', prezime='".$pisacDto['prezime']."', godina_rodjenja=".
                                $pisacDto['godinaRodjenja']." where id=".$id);
        return   $this->broker->ucitajJedan("select * from pisac where id=".$id);
    }
    public function obrisi($id){
        $this->broker->upisi("delete from pisac where id=".$id);
    }
}

?>