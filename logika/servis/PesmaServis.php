<?php

class PesmaServis{
    private $broker;
    
    public function __construct($b){
        $this->broker=$b;
    }

    public function vratiSve(){
        $pesme= $this->broker->ucitajKOlekciju("select p.*, z.naziv as 'zanr_naziv',pe.ime as 'pevac_ime',pe.prezime as 'pevac_prezime' from pesma p inner join zanr z on (z.id=p.zanr) inner join pevac pe on(pe.id=p.pevac)");
        $res=[];
        foreach($pesme as $pesma){
            $res[]=$this->toDto($pesma);
        }
        return $res;
    }
    public function vratiJednu($id){
        $pesma= $this->broker->ucitajJedan("select p.*, z.naziv as 'zanr_naziv',pe.ime as 'pevac_ime',pe.prezime as 'pevac_prezime' from pesma p inner join zanr z on (z.id=p.zanr) inner join pevac pe on(pe.id=p.pevac) where p.id=".$id);
        return $this->toDto($pesma);
    }
    public function kreiraj($pesmaDto){
        $this->broker->upisi("insert into pesma(naziv,trajanje,zanr,pevac) values('".$pesmaDto['naziv'].
                                "',".$pesmaDto['trajanje'].",".$pesmaDto['zanr'].",".$pesmaDto['pevac'].")");
        $id=$this->broker->getLastId();
        return $this->vratiJednu($id);
    }
    public function izmeni($id,$pesmaDto){
        $this->broker->upisi("update pesma set naziv='".$pesmaDto['naziv']."', trajanje=".$pesmaDto['trajanje'].
                                ", zanr=".$pesmaDto['zanr']." , pevac=".$pesmaDto['pevac']." where id=".$id);
        return $this->vratiJednu($id);
    }
    public function obrisi($id){
        $this->broker->upisi("delete from pesma where id=".$id);
    }
    private function toDto($pesma){
        return [
            "id"=>$pesma->id,
            "naziv"=>$pesma->naziv,
            "trajanje"=>$pesma->trajanje,
            "zanr"=>[
                "id"=>$pesma->zanr,
                "naziv"=>$pesma->zanr_naziv
            ],
            "pevac"=>[
                "id"=>$pesma->pevac,
                "ime"=>$pesma->pevac_ime,
                "prezime"=>$pesma->pevac_prezime
            ]
        ];
    }
}

?>