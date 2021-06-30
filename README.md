# Agentes Inteligente para Mundo do Wumpus
## Sobre
Trabalho de Análise e Complexidade Algorítmica - PPGES 2021/1 Adaptação do Código da disciplina de Inteligência Computacional da Universidade Federal do Pará - Tucuruí.

## Criadores do Código Original adaptado:
[@ **Denys Menfredy**](/DenysMenfredy)

[@ **Jeremias Kalebe**](/jkalebe)

[@ **Renuá Meireles**](/Renua-Meireles)

[@ **Rodrigo Moraes**](/Driguss)

## GitHub do Projeto Original
https://github.com/DenysMenfredy/WumpusWorld

## Dependências
python3

bibliotas do python: (requirements.txt)

- matplot>=0.1.9
- matplotlib>=3.3.4
- numpy>=1.20.1
- pyparsing>=2.4.7
- scipy>=1.6.0


## Características do Problema
- Mapa de tamanho NxN;
- 1 até N Buracos;
- 1 Wumpus;
- 1 Ouro;

 Objetivo do Algoritmo é ter pelo menos 1 agente realizando o percurso de forma segura até o ouro, tomando decisões autônomas para não cair em nenhum buraco ou ser morto pelo wumpus, para cada mapa proceduralmente gerado de tamanho NxN, sendo que cada mapa contem inicialmente apenas 1 buraco, depois 2, até N buracos.

## Exemplo de Execução
main.py [-h] [--tamanho_mapa TAMANHO_MAPA] [--buracos BURACOS] [--agentes AGENTES] [--rodadas RODADAS] [--verbosity VERBOSITY] [--log LOG]

### optional arguments:

  -h, --help
  
  <i>Mostra a Mensagem de Ajuda</i>
  
  
  --tamanho_mapa TAMANHO_MAPA, -tm TAMANHO_MAPA
  
  <i>Define o tamanho da Largura e Altura do Mapa (N).</i> <strong>Padrão:4</strong>
  
  
  --buracos BURACOS, -b BURACOS
   
   <i>Define o de buracos, consequentemente o número de execuções com sucesso do algoritmo.</i> <strong>Padrão: 4 </strong> (Tamanho do Mapa)
  
  
  --agentes AGENTES, -a AGENTES
  
   <i>Define o número total de agentes que irão tentar fazer a travessia no mesmo mapa.</i> <strong>Padrão:1</strong>
  
  
  --rodadas RODADAS, -r RODADAS
  
   <i>Número de rodadas com acerto que desejo realizar em cada quantidade de buracos.</i> <strong>Padrão:3</strong>
  
  
  --verbosity VERBOSITY, -v VERBOSITY
   
   <i>Nível de verbosidade do Log.</i> (INFO=20 DEBUG=10)
  
  
  --log LOG, -l LOG
   
   <i>arquivo de saída.</i> <strong>Padrão:wumpus.txt</strong>
  
## Gráfico Resultante
Tempo total, médio e mediano da conclusão de <strong>RODADAS</strong> com sucesso num mapa (<strong>TAMANHO MAPA x TAMANHO MAPA</strong>) com 1 até <strong>BURACOS</strong>.
