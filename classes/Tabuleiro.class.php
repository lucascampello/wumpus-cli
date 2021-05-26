<?php

/**
 * Description of Tabuleiro
 *
 * @author micre
 */
if(!class_exists("Tabuleiro"))
{    
    class Tabuleiro {
        public $posicaoJogador;
        public $objCelulas;

        public function __construct($idMapa)
        {
            $objArquivo = file(DIR_MAPAS."mapas.txt");
            $arrayPosicoes = explode(";",$objArquivo[$idMapa-1]);
            $this->posicaoJogador = 0;

            for($i = 0; $i < TAMANHO_TABULEIRO; $i++)
            {
                $this->objCelulas[] = new Celula(intval($arrayPosicoes[$i]));
            }
            $this->setPosicaoPlayer(0);
        }
        
        public function setPosicaoPlayer($posicao) : int
        {
            $posicaoAtual = $this->objCelulas[$posicao]->getStatus();
            if($this->objCelulas[$posicao]->getStatus() == OK)
            {
                $this->objCelulas[$posicao]->setStatus(JOGADOR);
            }
            else
            {
                
            }
            
            return $posicaoAtual;
        }
    }
}
