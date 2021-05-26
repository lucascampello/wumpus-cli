<?php
if(!class_exists("Jogo"))
{    
    class Jogo {
        public $objTabuleiro;
        
        public function __construct($idMapa)
        {
            $this->objTabuleiro = new Tabuleiro($idMapa);
        }
    }
}