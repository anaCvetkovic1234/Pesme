<?php

class PevacServis{
    private $broker;
    
    public function __construct($b){
        $this->broker=$b;
    }

    public function vratiSve(){
        return $this->broker->ucitajKOlekciju("select id, ime, prezime, godina_rodjenja as 'godinaRodjenja' from pevac");
    }
    public function kreiraj($pevacDto){
        $this->broker->upisi("insert into pevac(ime,prezime,godina_rodjenja) values ('".
                                $pevacDto['ime']."','".$pevacDto['prezime']."',".$pevacDto['godinaRodjenja'].")");
        $id= $this->broker->getLastId();
        return $this->vratiJedan($id);
    }

    public function izmeni($id,$pevacDto){
        $this->broker->upisi("update pevac set ime='".$pevacDto['ime'].
                                "', prezime='".$pevacDto['prezime']."', godina_rodjenja=".
                                $pevacDto['godinaRodjenja']." where id=".$id);
        return $this->vratiJedan($id);
    }
    public function vratiJedan($id){
       return $this->broker->ucitajJedan("select id, ime, prezime, godina_rodjenja as 'godinaRodjenja' from pevac where id=".$id);
    }
    public function obrisi($id){
        $this->broker->upisi("delete from pevac where id=".$id);
    }
}

?>