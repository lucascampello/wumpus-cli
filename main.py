#!/usr/bin/python3
# -*- coding: utf-8 -*-

# Lucas Campello da Pieva
# Universidade Federal do Pampa (Unipampa)
# Programa de Pós-Graduação em Eng. de Software (PPGES)

# Algoritmos
# Mundo Wumpus
try:
    import sys
    import argparse
    import logging
    import matplotlib.pyplot as plt
    import matplotlib.colors as colors
    import matplotlib.cm as cmx
    from efficience_calculation import EfficienceCalculation

except ImportError as error:
    print(error)
    print()
    print("1. (optional) Setup a virtual environment: ")
    print("  python3 -m venv ~/Python3env/algoritmos ")
    print("  source ~/Python3env/algoritmos/bin/activate ")
    print()
    print("2. Install requirements:")
    print("  pip3 install --upgrade pip")
    print("  pip3 install -r requirements.txt ")
    print()
    sys.exit(-1)


DEFAULT_SEED = None
DEFAULT_TAMANHO_MAPA = 4
DEFAULT_MAPAS_GERADOS = 10
DEFAULT_BURACOS = DEFAULT_TAMANHO_MAPA
DEFAULT_RODADAS = 3
DEFAULT_AGENTES = 1
DEFAULT_OUTPUT = None #"alg_lab.png"
DEFAULT_LOG = "wumpus.txt"

DEFAULT_LOG_LEVEL = logging.INFO
TIME_FORMAT = '%Y-%m-%d,%H:%M:%S'


def imprime_config(args):
    '''
    Mostra os argumentos recebidos e as configurações processadas
	:args: parser.parse_args
	'''
    logging.info("Argumentos:\n\t{0}\n".format(" ".join([x for x in sys.argv])))
    logging.info("Configurações:")
    for k, v in sorted(vars(args).items()):
        logging.info("\t{0}: {1}".format(k, v))
    logging.info("")


def main():
    '''
    Programa principal
    :return:
    '''

    nome = 'Lucas Campello da Pieva'

    # Definição de argumentos
    parser = argparse.ArgumentParser(description='Mundo Wumpus')

    # Tamanho do mapa (Padrão 4)
    help_msg = "tamanho do mapa. Padrão:{}".format(DEFAULT_TAMANHO_MAPA)
    parser.add_argument("--tamanho_mapa", "-tm", help=help_msg, default=DEFAULT_TAMANHO_MAPA, type=int)

    # Número de Buracos (Padrão TAMANHO DO MAPA -1)
    help_msg = "buracos.        Padrão:{}".format(DEFAULT_BURACOS)
    parser.add_argument("--buracos", "-b", help=help_msg, default=DEFAULT_BURACOS, type=int)

    # Número de Agentes (Padrão 1)
    help_msg = "agentes.        Padrão:{}".format(DEFAULT_AGENTES)
    parser.add_argument("--agentes", "-a", help=help_msg, default=DEFAULT_AGENTES, type=int)


    # Número de Agentes (Padrão 1)
    help_msg = "rodadas.        Padrão:{}".format(DEFAULT_RODADAS)
    parser.add_argument("--rodadas", "-r", help=help_msg, default=DEFAULT_RODADAS, type=int)

    # Nível de  Saída (INFO | DEBUG)
    help_msg = "verbosity logging level (INFO=%d DEBUG=%d)" % (logging.INFO, logging.DEBUG)
    parser.add_argument("--verbosity", "-v", help=help_msg, default=DEFAULT_LOG_LEVEL, type=int)

    # Nível de  Log (Padrão: wumpus.txt)
    help_msg = "arquivo de saída.  Padrão:{}".format(DEFAULT_LOG)
    parser.add_argument("--log", "-l", help=help_msg, default=DEFAULT_LOG, type=str)

    # Lê argumentos da linha de comando
    args = parser.parse_args()

    # configura o mecanismo de logging
    if args.verbosity == logging.DEBUG:
        # mostra mais detalhes
        logging.basicConfig(format='%(asctime)s %(levelname)s {%(module)s} [%(funcName)s] %(message)s',
                            datefmt=TIME_FORMAT, level=args.verbosity)

    else:
        logging.basicConfig(format='%(message)s',
                            datefmt=TIME_FORMAT, level=args.verbosity)

    # imprime configurações para fins de log
    imprime_config(args)

    #Inicializa os Parâmetros do Jogo
    #tamanho = args.tamanho_mapa
    #buracos = args.buracos
    #rodadas = args.rodadas
    size_chrom = 100
    pontuacao = [
        1000,  # Pegou Ouro
        500,  # Matou Wumpus
        70,  # Escapou
        -10,  # Agente Morreu
        -0.5,  # Tamanho
        2,    # OK
        -2,   # Erro
        -2,   # Distância
        -2,   # Fadiga
    ]

    # Inicializo as variáveis de Controle do Jgoo
    efficience_calulation = EfficienceCalculation("wumpus")

    # Cria a estrutura de pontuação e inicializa os valores para o algoritmo
    efficience_calulation.loadWeights(size_chrom,1,args.agentes,pontuacao)

    # roda
    efficience_calulation.runIterations(args)

    # Gera o mpy com os dados resultantes
    efficience_calulation.exportResults()

# Chamada MAin do Sistema
if __name__ == '__main__':
    sys.exit(main())