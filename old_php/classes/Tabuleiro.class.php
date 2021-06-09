<?php

/**
 * Classe responsável pela construção do Tabuleiro
 *
 * @author Lucas Campello da Pieva
 * @version 1.0
 */
if(!class_exists("Tabuleiro"))
{    
    class Tabuleiro {
        /**
         * Array de Células do Tabuleiro
         * @var object_array 
         */
        public $objCelulas;

        /**
         * Faz a construção do Tabuleiro
         * @param int $idMapa
         */
        public function __construct($idMapa)
        {
            $objArquivo = file(DIR_MAPAS."mapas.txt");
            $arrayPosicoes = explode(";",$objArquivo[$idMapa]);

            for($i = 0; $i < TAMANHO_TABULEIRO; $i++)
                $this->objCelulas[] = new Celula($arrayPosicoes[$i]);
        }
        
        /**
         * Desenha o mapa em formato HTML para o arquivo mapas.php
         * @return string
         */
        public function Desenhar()
        {
            $html = "";
            $linha = "";
            $contador = 0;
            for($i = POSICAO_INICIAL; $i < TAMANHO_TABULEIRO; $i++)
            {
                $linha .= "<img src=\"".$this->objCelulas[$i]->getImage()."\"\>";
                if($contador == 3)
                {
                   $html = "
                   <div =\"linha\">".$linha."</div>".$html;
                   $linha = "";
                   $contador = -1;
                }
                $contador++;
            }
            return $html;
        }
    }
}
