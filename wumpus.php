<?php
    // Constantes que serão utilizadas em todo o código
    include("define.php");
    
    // Define o tempo máximo de execução do Script (MAX_EXEC² segundos)
    set_time_limit(MAX_EXEC * MAX_EXEC);
    require(DIR_CLASS."Autoloader.class.php");

    // Funções básicas de controle que não pertecem ao algoritmo
    $objIOSistema = new IOSistema();

    // Verificação os parâmetros de entrada do código
    $objIOSistema->controlarEntrada($argc, $argv);

    // Número total de vezes que será executado o algoritmo
    $nExecucoes = intval($argv[1]);
    
    for($i = 0; $i < $nExecucoes; $i++)
    {
        // Escolhe o Mapa entre o 1 e o número total de mapas implementados
        $mapa_escolhido = rand(1,N_MAPAS);

        // Zera o Array de Tempo de Execução
        $tempoExecucao = null;
        // Executa 3 Vezes o Algoritmo pra verificar o tempo médio
        for($y = 0; $y < 3; $y++)
        {
            // Coleta o Tempo de Execução Inicial do Algoritmo
            $tempoInicial = $objIOSistema->tempo();

            // Executa o Jogo (INICIO DAS FUNÇÕES DE -> jogo.php)
            $objJogo = new Jogo($mapa_escolhido);
            $objJogo->jogar();
            

            // Coleta o Tempo de Execução Final do Algoritmo
            $tempoFinal = $objIOSistema->tempo();
            
            // Obtem o Tempo Real da Execução (Final - Inicial)
            $tempoExecucao[] = ($tempoFinal-$tempoInicial)/1000000000;
            
        }

        // Obtem a Média do Tempo de Execução
        $tempoMedio = array_sum($tempoExecucao)/3;
        
        // Escreve o Log
        $objIOSistema->escreverLog(($i+1)." {$tempoMedio}");

        // ESCREVER O LOG
        // $objJogo->logarJogada();
    }
    
    // Fecha o Arquivo de Log
    $objIOSistema->fecharLog();
?>