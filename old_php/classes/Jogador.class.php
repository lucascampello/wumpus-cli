<?php

/**
 * Description of Jogador
 *
 * @author Lucas Campello da Pieva
 * @version 1.0
 */
if(!class_exists("Jogador"))
{    
    class Jogador {
        /**
         * Tem Flecha? [init=true]
         * @var bool 
         */
        private $flecha;
        
        /**
         * Matou o Wumpus? [init=false]
         * @var bool 
         */
        private $wumpusMorto;
        
        /**
         * Posição Atual do Jogador [init = 0]
         * @var int 
         */
        private $posicao;

        /**
         * Base de conhecimento do Jogador para Tomada de Decisão [init=DESCONHECIDO]
         * @var object_array 
         */
        private $objCelulasTabuleiro;
        
        /**
         * Array de Posições Visitadas do Tabuleiro [init=0]
         * @var array
         */
        private $visitados;
        
        /**
         * Número de Passos Realizados [init=0]
         * @var int 
         */
        private $nPassos;
        
        /**
         * Coletou o Ouro? [init=false]
         * @var bool 
         */
        private $ouro;

        /**
         * Construtor da Classe Jogador
         * Inicializa os Atributos com seus valores padrão
         * @return void
         */
        public function __construct(){
            $this->posicao = 0;
            $this->nPassos = 0;
            $this->flecha = true;
            $this->wumpusMorto = false;
            $this->ouro = false;
            for($i =0; $i < TAMANHO_TABULEIRO; $i++)
            {
                $this->setVisitado($i, false);
                $this->objCelulasTabuleiro[$i] = new Celula(DESCONHECIDO);
            }
        }

        /**
         * Retorna a Posição Atual do Jogador
         * @return int
         */
        public function getPosicao() : int
        {
            return $this->posicao;
        }
        
        /**
         * 
         * @param type $indice
         * @param type $valor
         * @return void
         */
        private function setVisitado($posicao, $valor) : void {
            $this->visitados[$posicao] = $valor;
        }
        
        /**
         * Define a Posição Atual do Jogador
         * @param int $posicao
         * @return void
         */
        public function setPosicao($posicao) : void
        {
            $this->posicao = $posicao;
        }
        
        /**
         * Define a Situação da Célula do Tabuleiro
         * @param int $posicao
         * @param int $status
         * @return void
         */
        private function setCelulaTabuleiro($posicao, $item, $valor) : void {
            $this->objCelulasTabuleiro[$posicao]->setItemArrayStatus($item, $valor);
        }
        
        /**
         * Busca a Situação de um Determinado Item do Array de Status do Elemento
         * @param int $posicao
         * @param int $item
         * @return int
         */
        private function getItemCelulaTabuleiro($posicao, $item) : bool {
            return $this->objCelulasTabuleiro[$posicao]->getItemArrayStatus($item);
        }
        
        /**
         * Verifica se acertou o wumpus, caso ainda tenha flecha
         * @param int $posicao
         * @return bool
         */
        public function atirarFlecha($posicao) : bool
        {
            if($this->flecha)
            {
                $this->flecha = false;
                if ($posicao["wumpus"] == true)
                {
                    $this->wumpusMorto = true;
                    return true;
                }
            }
            return false;
        }
        
        /**
         * Retorna as possíveis adjascências da posição atual
         * @param int $posicao
         * @return array
         */
        public function adjascentes($posicao) : array
        {
            $cima = ($posicao <= 11);
            $baixo = ($posicao >= 4);
            $esquerda = (($posicao % 4) != 0);
            $direita = ((($posicao + 1) % 4) != 0);
            
            return array("cima" => $cima, "baixo" => $baixo, "esquerda" => $esquerda, "direita" => $direita);
        }
        
        /**
         * Pegou o Ouro?
         * @return bool
         */
        public function getOuro() : bool 
        {
            return $this->ouro;
        }
        
        public function iterar($posicao)
        {
            $adjascentes = $this->adjascentes($this->posicao);
            // SEM NENHUM STATUS
            if(!$posicao["fedor"] && !$posicao['brisa'] && !$posicao['brilho'] && !$posicao['wumpus'] && !$posicao['fosso'])
            {
                // IDENTIFICA OS ADJASCENTES COMO POTENCIAL OK
                for($i = 0; $i < count($adjascentes); $i++)
                {
                    if(!$adjsacentes[$i])   // caso não exista adjascente
                        continue;

                    // Tenho alguma Suposição Adjascente
                    if($this->objCelulasTabuleiro[$adjascentes[$i]]->getStatus() != DESCONHECIDO)
                    {
                        $arrayStatusAdjacente = $this->objCelulasTabuleiro[$adjascentes[$i]]->getArrayStatus();
                        if($arrayStatusAdjacente['wumpus'] || $arrayStatusAdjacente['fosso'])
                            $this->setCelulaTabuleiro($adjascentes[$i],OK);
                    }
                    else // não tenho ideia
                        $this->setCelulaTabuleiro($adjascentes[$i],OK);
                }
            }
            else if($posicao['fedor'])
            {
                // IDENTIFICA OS ADJASCENTES COMO POTENCIAL OK
                for($i = 0; $i < count($adjascentes); $i++)
                {
                    if(!$adjsacentes[$i])   // caso não exista adjascente
                        continue;
                    
                    if($this->objCelulasTabuleiro[$adjascentes[$i]]->getStatus() == DESCONHECIDO)
                        $this->setCelulaTabuleiro($adjascentes[$i],WUMPUS);
                    else
                    {
                        $statusAdjascente = $this->objCelulasTabuleiro[$adjascentes[$i]]->getArrayStatus();
                        if($posicao['fosso'])
                            $this->setCelulaTabuleiro($i,OK);
                    }
                }
            }
            /*
            else if($posicao['brilho'])                                         // ACHOU O OURO
                $this->ouro = true;
            else if($posicao['fosso'] || ($posicao['wumpus'] && !$this->wumpusMorto))   // MORTE DO JOGADOR
                die("MORREU : " + $this->posicao + " || " + $posicao);
            */
        }
    }
}