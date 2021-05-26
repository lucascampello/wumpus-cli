<?php
if(!class_exists("Celula"))
{
    class Celula {
        private $status;
        
        /**
         * Construtor do método
         * @param int $status - Tipo de Célula (OK | WUMPUS | CHEIRO | FOSSO | BRISA | OURO)
         */
        function __construct($status) {
            $this->setStatus($status);
        }
        
        /**
         * Retorna o Status atual da Célula do Tabuleiro
         * @return int
         */
        function getStatus() : int {
            return $this->status;
        }

        /**
         * Define a Situação da Célula
         * @return void
         */
        public function setStatus($status): void {
            $this->status = $status;
        }
    }
}