<?php
if(!class_exists("Jogo"))
{    
    class Jogo {
        /**
         * É o Fim do Jogo? [init=false]
         * @var bool 
         */
        public $fimJogo;
        public $objTabuleiro;
        public $objJogador;
        
        public function __construct($idMapa)
        {
            $this->objTabuleiro = new Tabuleiro($idMapa);
            $this->objJogador = new Jogador();
            $this->fimJogo = false;
        }
        
        public function jogar()
        {
            while(!$this->fimJogo)
            {
                $posicao = $this->objJogador->getPosicao();
                $arrayPosicaoAtual = $this->objTabuleiro->objCelulas[$posicao]->getArrayStatus();
               
                $this->objJogador->iterar($arrayPosicaoAtual);
//                $this->objJogador->acao();

                if(($this->objJogador->getOuro() == true) && $this->objJogador->getPosicao() == 0)
                    $this->fimJogo = true;
                
                //if($contador >= 50)
                    $this->fimJogo = true;
            }
        }
    }
}
