# Agentes Inteligente para Mundo do Wumpus
# Sobre
Trabalho de Análise e Complexidade Algorítmica - PPGES 2021/1
Adaptação do Código  da disciplina de Inteligência Computacional da **Universidade Federal do Pará - Tucuruí**.

## Criadores do Código Original adaptado:
[@ **Denys Menfredy**](/DenysMenfredy)
[@ **Jeremias Kalebe**](/jkalebe)
[@ **Renuá Meireles**](/Renua-Meireles)
[@ **Rodrigo Moraes**](/Driguss)

## GitHub do Projeto Original
https://github.com/DenysMenfredy/WumpusWorld

# Dependências
  - python3
  - bibliotas do python: (requirements.txt)
	matplot>=0.1.9
	matplotlib>=3.3.4
	numpy>=1.20.1
	pyparsing>=2.4.7
	scipy>=1.6.0

#### Características do Problema
- Mapa de tamanho NxN;
- N-1 Buracos;
- 1 Wumpus;
- 1 Ouro;
- Objetivo do Agente é percorrer o mapa em busca do ouro, tomando decisões autônomas para não cair em nenhum buraco ou ser morto pelo wumpus, tentar matar o wumpus e voltar em segurança para o inicio do tabuleiro.

# Exemplo de Execução
  - python3 main.py [-h] [--tamanho_mapa TAMANHO_MAPA] [--mapa_gerados MAPA_GERADOS] [--rodadas RODADAS] [--verbosity VERBOSITY] [--log LOG]

optional arguments:
  -h, --help            show this help message and exit
  --tamanho_mapa TAMANHO_MAPA, -tm TAMANHO_MAPA
                        tamanho do mapa. Padrão:4
  --mapa_gerados MAPA_GERADOS, -mg MAPA_GERADOS
                        mapas gerados. Padrão:10
  --rodadas RODADAS, -r RODADAS
                        rodadas. Padrão:20
  --verbosity VERBOSITY, -v VERBOSITY
                        verbosity logging level (INFO=20 DEBUG=10)
  --log LOG, -l LOG     arquivo de saída. Padrão:wumpus.txt

### License
BSD 2-Clause "Simplified" License