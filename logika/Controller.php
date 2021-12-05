<?php
class Controller{

    private $broker;
    private $zanrServis;
    private $pesmaServis;
    private $pevacServis;
    private static $controller;

    private function __construct(){
        $this->broker=new Broker("localhost",'root','','songs');
        $this->zanrServis=new ZanrServis($this->broker);
        $this->pesmaServis=new PesmaServis($this->broker);
        $this->pevacServis=new PevacServis($this->broker);
    }
    public static function getController(){
        if(!isset($controller)){
            $controller=new Controller();
        }
        return $controller;
    }
    public function obradiZahtev($akcija){
        try {
           echo json_encode($this->vratiUspesno($this->izvrsi($akcija)));
        } catch (Exception $ex) {
            echo json_encode($this->vratiGresku($ex->getMessage()));
        }
    }
    public function izvrsi($akcija){
        if($akcija=='vratiZanrove'){
            return $this->zanrServis->vratiSve();
        }
        if($akcija=='vratiPesme'){
            return $this->pesmaServis->vratiSve();
        }
        if($akcija=='vratiPevace'){
            return $this->pevacServis->vratiSve();
        }
        if($akcija=='kreirajPevaca'){
            return $this->pevacServis->kreiraj($_POST);
        }
        if($akcija=='kreirajPesmu'){
            return $this->pesmaServis->kreiraj($_POST);
        }
        if($akcija=='izmeniPevaca'){
            return $this->pevacServis->izmeni($_GET['id'],$_POST);
        }
        if($akcija=='izmeniPesmu'){
            return $this->pesmaServis->izmeni($_GET['id'],$_POST);
        }
        if($akcija=='obrisiPevaca'){
            $this->pevacServis->obrisi($_GET['id']);
            return null;
        }
        if($akcija=='obrisiPesmu'){
            $this->pesmaServis->obrisi($_GET['id']);
            return null;
        }
    }
    public function vratiUspesno($podaci){
        if(!isset($podaci)){
            return[
                "status"=>true,
            ];
        }
        return[
            "status"=>true,
            "data"=>$podaci
        ];
    }
    public function vratiGresku($greska){
        return[
            "status"=>false,
            "error"=>$greska
        ];
    }
}


?>