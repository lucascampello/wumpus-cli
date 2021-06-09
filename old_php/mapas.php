<?php
    require("define.php");
    require(DIR_CLASS."Autoloader.class.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mundo do Wumpus</title>
        <link type="text/css" rel="stylesheet" media="screen" href="css/main.css" />
    </head>
    <body>
        <div id="content">
            <div id="jogo">
                <div id='left'>
                    <?php 
                        for($i = 0; $i < N_MAPAS; $i++)
                        {
                            echo "MAPA: <strong>".($i+1)."</strong>";
                            $objTabuleiro[$i] = new Tabuleiro($i);
                            echo $objTabuleiro[$i]->Desenhar(); 
                            echo "<br clear/>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>