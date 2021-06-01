<?php
class IOSistema {

    private $log;
    
    public function __construct()
    {
        $this->iniciarLog();
    }
    
    /**
    * Retorna a mensagem padrão da chamada do comando de entrada do algoritmo
    * @return string
    */
    private function exemploChamada() : string
    {
       return " php wumpus.php <NÚMERO DE EXECUÇÕES>\n\n";
    }

    /**
    * Função que finaliza a execução do sistema apresentando um erro 
    * de acordo com código informado
    * @param int $mensagem - Parâmetro do Código de Erro (encontrado em define.php)
    */
    private function mensagemErro($mensagem) : void
    {
       $msg = "Erro:\n ";
       switch($mensagem):
           case POUCOS_PARAMETROS:
               exit($msg . "Não foi informado na chamada o parâmetro <NÚMERO DE EXECUÇÕES>\n" . $this->exemploChamada());
               break;
           case PARAMETRO_NAO_INTEIRO:
               exit($msg . "O parâmetro informado não é um número inteiro\n" . $this->exemploChamada());
               break;
           case PARAMETRO_UNSIGNED:
               exit($msg . "O parâmetro informado deve ser positivo maior que zero!\n");
               break;
           case MAX_EXEC:
               exit($msg . "O parâmetro informado é maior que o tamanho máximo de execuções do algoritmo -> " . MAX_EXEC . " <-\n");
               break;
           case CRIAR_LOG:
               exit($msg . "Impossível criar arquivo de Log (".ARQUIVO_LOG.")\n Verificar se há permissão de escrita na pasta de execução do script.\n\n");
               break;
           case ESCREVER_LOG:
               exit($msg . "Impossível de gravar no arquivo de Log (".ARQUIVO_LOG.")\n");
               break;
           case FECHAR_LOG:
               exit($msg . "Impossível fechar corretamente o arquivo de Log (".ARQUIVO_LOG.")\n");
               break;
       endswitch;
    }

    /**
    * Função que verifica a entrada do usuário pela linha de comando,
    * verificando se:
    *   - Há argumentos na chamada da linha de comando
    *   - Se o argumento é válido 
    *        (inteiro e maior que zero e menor ou igual a MAX_EXEC)
    * @param int $argc
    * @param char[] $argv
    */
    public function controlarEntrada($argc, $argv) : void
    {
       if ($argc <= 1)
           $this->mensagemErro(POUCOS_PARAMETROS);
       if(!is_numeric($argv[1]))
           $this->mensagemErro(PARAMETRO_NAO_INTEIRO);
       else
       {
           $argv[1] = intval($argv[1]); // Transforma a Entrada em Inteiro (Trunca casas decimais)

           if ($argv[1] <= 0)
               $this->mensagemErro(PARAMETRO_UNSIGNED);
           else if ($argv[1] > MAX_EXEC)
               $this->mensagemErro(MAX_EXEC);
       }
    }

    /**
     * Inicializa o arquivo de Log, escrevendo o cabeçalho e retornando o ponteiro do arquivo
     */
    private function iniciarLog()
    {
       $this->log = fopen(ARQUIVO_LOG,"w+");
       if($this->log == null)
           $this->mensagemErro(CRIAR_LOG);

       $mensagem = "#Mundo Wumpus\n#n time_s_avg time_s_std";
       $this->escreverLog($mensagem);
    }

    /**
     * Função de escrita do log do sistema
     * @param resource $arquivo arquivo de destino do log
     * @param string $mensagem mensagem a ser escrita no log
     * @return void
     */
    public function escreverLog($mensagem) : void
    {
        if(file_exists(ARQUIVO_LOG))
            fprintf($this->log, "%s\n", $mensagem);
        else
            $this->mensagemErro(ESCREVER_LOG);
    }

    public function fecharLog()
    {
        if(file_exists(ARQUIVO_LOG))
            fclose($this->log);
        else
            mensagemErro(FECHAR_LOG);
    }

    public function tempo()
    {
        return hrtime(true);
    }
}