import statistics
import timeit
from game.environment import Environment as GameEnvironment
from ga.environment import Environment as GAEnvironment
from agents.ga_agent import GaAgent
from game.game import Game
from numpy import array, save, load
from matplotlib import pyplot as plt
from os import path

#from matplotlib import pyplot as plt

class EfficienceCalculation(object):
    def __init__(self, identifier):
        self.percent_victories = []
        self.percent_took_gold = []
        self.percent_killed_wumpus = []
        self.best = []
        self.worst = []
        self.average = []
        self.set = identifier
    def loadEnvironment(self, dimension, n_pits):
        self.environment = GameEnvironment(dimension = dimension, n_pits = n_pits)  # game/environment.py
    def loadWeights(self,size_chrm, n_mapas, n_rodadas, weights:list):
        self.weights = weights
        w1, w2, w3, w4, w5, w6, w7, w8 ,w9 = self.weights
        self.ag_params = {
            "stop_gen": n_mapas,
            "size_pop": n_rodadas,
            "crossover_rate": 0.9,
            "mutation_rate": 0.05,
            "evaluator": None,
            "cooperators": 1,
            "size_chromosome": size_chrm,
            "fitness_function": lambda got_gold, wumpus_died, escaped, \
                                agent_died, size, hits, errors, distance, fatigue: got_gold * w1 + wumpus_died * w2 + escaped * w3\
                                                                    + agent_died * w4 + size * w5 + hits * w6 + errors * w7 + distance * w8 + fatigue * w9
        }

#    ORIGINAL
#    def runIterations(self, args):
#        trials = args.agentes

#        f = open(args.log, "w+")
#        f.write("#Solução do Mundo Wumpus (TSP)\n")
#        f.write("#mapa tempo_inicial tempo_final tempo_total(for {} trials)\n".format(trials))
        # tempo_inicio = timeit.default_timer()

#        self.loadEnvironment(self.environment.dimension, self.environment.n_pits)
#        self.runIteration(1, f)
#
#        f.close()
#
    def runIterations(self, args):
        trials = args.rodadas       # Tentativas

        f = open(args.log, "w+")
        f.write("#Solução do Mundo Wumpus (TSP)\n")
        f.write("#mapa tempo_inicial tempo_final tempo_total(for {} trials)\n".format(trials))

        self.runIteration(1, f, args)
        #self.runIteration(1, f, args.rodadas, args.tamanho_mapa, args.buracos)

        f.close()

#    def runIteration(self, iterations, file_log, rodadas, tamanho_mapa, buracos):
    def runIteration(self, iterations, file_log, args):
        self.iterations = iterations
        victories, took_gold, killed_wumpus = 0, 0, 0
        all_fitness = []
        tempos = []
        for i in range(iterations):
            buraco = 0
            solution = ""
            while buraco < args.buracos:
                verificarVitoria = 0
                tempo_inicio = 0
                while verificarVitoria < args.rodadas:
                    self.loadEnvironment(args.tamanho_mapa, buraco)
                    self.ag_params["evaluator"] = Game(self.environment, gui_enabled=False)
                    ga = GAEnvironment(size_fixed=False, Agent=GaAgent, **self.ag_params)

                    tempo_inicio += timeit.default_timer()
                    solution = ga.start()
                    tempo_fim = timeit.default_timer()

                    if(solution.hasGold()):
                        tempo_fim += tempo_inicio
                        tempos += [{"inicial": tempo_inicio, "final": tempo_fim, "total": tempo_fim - tempo_inicio}]
                        verificarVitoria += 1
                        tempo_inicio = 0
                    else:
                        tempo_inicio += tempo_fim

                buraco += 1


            all_fitness.append(solution.fitness)

        linha = 1
        tempo_total = 0
        buraco = 0
        pontos_total = []
        pontos_medio = []
        valores = []
        pontos_mediano = []
        for tempo in tempos:
            print(tempo)
            tempo_total += tempo["total"]
            valores.append(tempo["total"])
            if((linha >= args.rodadas) & (linha % args.rodadas == 0)):
                pontos_total.append(tempo_total)
                pontos_medio.append(statistics.mean(valores))
                pontos_mediano.append(statistics.median(valores))
                print("Buraco:" + str(buraco))
                print("Tempo Total:" + str(tempo_total))
                print("Tempo Médio:" + str(statistics.mean(valores)))
                print("Tempo Mediano:" + str(statistics.median(valores)))
                print(" ==== \n")
                valores.clear()
                buraco += 1
                tempo_total = 0

            file_log.write("  {}  {}     {}   {}\n".format(1, tempo["inicial"], tempo["final"], tempo["total"]))
            linha += 1

        plt.plot(pontos_total, 'b', label='tempo total')
        plt.plot(pontos_mediano, 'g', label='tempo mediano')
        plt.plot(pontos_medio, 'r', label='tempo medio')

        self.showGraphics(args)

        self.percent_victories.append((victories / iterations) * 100)
        self.percent_killed_wumpus.append((killed_wumpus / iterations) * 100)
        self.percent_took_gold.append((took_gold / iterations) * 100)
        self.best.append(max(all_fitness))
        self.worst.append(min(all_fitness))
        self.average.append(sum(all_fitness) / iterations)
    
    def getAgParams(self,):
        return f'\t\tAG params:\nStop Generation: {self.ag_params["stop_gen"]},\
                            \nSize Pop: {self.ag_params["size_pop"]},\
                            \nCrossover Rate: {self.ag_params["crossover_rate"]},\
                            \nMutation rate: {self.ag_params["mutation_rate"]},\
                            \nSize chromosome: {self.ag_params["size_chromosome"]}\n'
    
    def getGameParams(self, ):
        return f'Game Params:\nDimension: {self.environment.dimension}\
                             \nNº pits: {self.environment.n_pits}\
                             \nNº golds: 1\nNº wumpus: 1\n' 
    
    
    def getPercents(self,):
        wins,wumpus,gold = array(self.percent_victories), array(self.percent_killed_wumpus), array(self.percent_took_gold)
        return f'Iterations: {self.iterations}\
            \nPercent Victories:     | {wins} | avg: {wins.mean()} | std: {wins.std()} |\
            \nPercent Killed Wumpus: | {wumpus} | avg: {wumpus.mean()} | std: {wumpus.std()} |\
            \nPercent took Gold:     | {gold} | avg: {gold.mean()} | std: {gold.std()} |\n'
    
    def getResults(self,):
        return f'Configuration {self.set}:\n{self.getAgParams()}\
             {self.getGameParams()}{self.getPercents()}'
              
    def exportResults(self, ):
        wins,wumpus,gold = array(self.percent_victories), array(self.percent_killed_wumpus), array(self.percent_took_gold)
        dimension = self.environment.dimension
        values = array([wins.mean(), wumpus.mean(), gold.mean(), dimension])
        with open(path.abspath(f'files/{self.set}.npy'), "ab+") as file:
            save(file, values)
        
    def clearData(self,):
        open(path.abspath(f'files/{self.set}.npy'), "wb").close()
        
    def showResults(self, ):
        print(self.getResults())
        
    #def showGraphics(self, ):
    #    wins = []
    #    kills = []
    #    gold = []
    #    xs = []
    #    with open(path.abspath(f'files/{self.set}.npy'), "rb") as file:
    #        eof = False
    #        while(not eof):
    #            try:
    #                values = load(file)
    #                wins.append(values[0])
    #                kills.append(values[1])
    #                gold.append(values[2])
    #                xs.append(values[3])
                    
    #            except ValueError:
    #                eof = True
                    
    #    labels = [f'{int(dim)}x{int(dim)}' for dim in sorted(xs)]
    #    print(labels)
    #    print(wins)
    #    print(kills)
    #    print(gold)
    #    ax = plt.subplot(111)
    #    width = 0.35
    #    ax.bar(array(xs) - width, wins, width=width, label='wins')
    #    ax.bar(xs, kills, width=width, label='kills')
    #    ax.bar(array(xs) + width, gold, width=width, label='gold')
    #    ax.set_title("TEST")
    #    ax.legend(loc="best")
    #    ax.grid(True)
    #    ax.set_xticks(sorted(xs))
    #    ax.set_xticklabels(labels)
    #    ax.autoscale(tight=True)
    #    plt.show()

    def showGraphics(self, args):
        plt.legend()

        plt.title("WUMPUS : Rodadas(" + str(args.rodadas) + ") | Mapa ("+ str(args.tamanho_mapa) + "x" + str(args.tamanho_mapa)+") | Agentes ("+str(args.agentes)+")")
        plt.xlabel("Buracos (n)")
        plt.ylabel("Tempo (segundos)")
        plt.show()