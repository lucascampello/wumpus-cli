<?php
if(!class_exists("Celula"))
{
    class Celula {
        public $status;
        public $arrayStatus;
        public $image;
        
        /**
         * Construtor do método
         * @param int $status - Tipo de Célula (OK | WUMPUS | CHEIRO | FOSSO | BRISA | OURO)
         */
        function __construct($status) {
            $this->setStatus($status);
            $this->setArrayStatus($this->getStatus());
            $this->setImage();
        }
        
        /**
         * Retorna o Status atual da Célula do Tabuleiro
         * @return int
         */
        public function getStatus() : int {
            return $this->status;
        }
        
        /**
         * Retorna todos os itens do Array de Status
         * @return array
         */
        public function getArrayStatus() : array {
            return $this->arrayStatus;
        }
        
        /**
         * Retorna o valor em booleano do item específico do Array de Status
         * @param string $item
         * @return bool
         */
        public function getItemArrayStatus($item) : bool {
            return $this->arrayStatus[$item];
        }

        /**
         * Define a Situação da Célula
         * @return void
         */
        public function setStatus($status): void {
            $this->status = intval($status);
        }
        
        public function setImage() : void {
            $this->image = DIR_IMG . $this->status.".png";
        }
                
        /**
         * Inicia os valores do Array de Status da Celula do Tabuleiro
         * @param int $status
         * @return void
         */
        public function setArrayStatus($status) : void {
            switch($this->status)
            {
                case DESCONHECIDO:
                case OK:
                    $this->arrayStatus = array("fedor" => false, "brisa" => false, "brilho" => false, "wumpus" => false, "fosso" => false);
                    break;
                case WUMPUS:
                    $this->arrayStatus = array("fedor" => false, "brisa" => false, "brilho" => false, "wumpus" => true, "fosso" => false);
                    break;
                case FEDOR:
                    $this->arrayStatus = array("fedor" => true, "brisa" => false, "brilho" => false, "wumpus" => false, "fosso" => false);
                    break;
                case FOSSO:
                    $this->arrayStatus = array("fedor" => false, "brisa" => false, "brilho" => false, "wumpus" => false, "fosso" => true);
                    break;
                case BRISA:
                    $this->arrayStatus = array("fedor" => false, "brisa" => true, "brilho" => false, "wumpus" => false, "fosso" => false);
                    break;
                case FEDOR_BRISA:
                    $this->arrayStatus = array("fedor" => true, "brisa" => true, "brilho" => false, "wumpus" => false, "fosso" => false);
                    break;
                case WUMPUS_BRISA:
                    $this->arrayStatus = array("fedor" => false, "brisa" => true, "brilho" => false, "wumpus" => true, "fosso" => false);
                    break;
                case OURO:
                    $this->arrayStatus = array("fedor" => false, "brisa" => false, "brilho" => true, "wumpus" => false, "fosso" => false);
                    break;
                case OURO_FEDOR:
                    $this->arrayStatus = array("fedor" => true, "brisa" => false, "brilho" => true, "wumpus" => false, "fosso" => false);
                    break;
                case OURO_BRISA:
                    $this->arrayStatus = array("fedor" => false, "brisa" => true, "brilho" => true, "wumpus" => false, "fosso" => false);
                    break;
                case OURO_FEDOR_BRISA:
                    $this->arrayStatus = array("fedor" => true, "brisa" => true, "brilho" => true, "wumpus" => false, "fosso" => false);
                    break;
            }
        }
 
        /**
         * Define o valor de um determinado item do Array de Status
         * @param int $item
         * @param bool $valor
         * @return void
         */
        public function setItemArrayStatus($item, $valor) : void {
            $this->arrayStatus[$item] = $valor;
        }
        
        /**
         * Retorna o caminho para a imagem (usado em mapas.php)
         * @return string
         */
        public function getImage() : string
        {
            return $this->image;
        }
    }
}