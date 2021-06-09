<?php
// Constantes que serão utilizadas em todo o código
include("define.php");

// Define o tempo máximo de execução do Script (MAX_EXEC² segundos)
set_time_limit(MAX_EXEC * MAX_EXEC);
require(DIR_CLASS."Autoloader.class.php");

$objJogador = new Jogador();
