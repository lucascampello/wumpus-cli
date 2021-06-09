import numpy as np
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
        self.environment = GameEnvironment(dimension = dimension, n_pits = n_pits)
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
        
    def runIterations(self, args):
        trials = args.rodadas

        f = open(args.log, "w+")
        f.write("#Solução do Mundo Wumpus (TSP)\n")
        f.write("#mapa tempo_inicial tempo_final tempo_total(for {} trials)\n".format(trials))
#        tempo_inicio = timeit.default_timer()

        self.loadEnvironment(self.environment.dimension, self.environment.n_pits)
        self.runIteration(1, f)

        f.close()


    def runIteration(self, iterations,file_log):
        self.ag_params["evaluator"] = Game(self.environment, gui_enabled=False)
        self.iterations = iterations
        victories, took_gold, killed_wumpus = 0, 0, 0
        all_fitness = []
        for i in range(iterations):
            ga = GAEnvironment(size_fixed = False, Agent = GaAgent, **self.ag_params)
            solution = ga.start(file_log)

            if solution.wonGame():
                victories += 1
            if solution.hasGold():
                took_gold += 1 
            if solution.killedWumpus():
                killed_wumpus += 1
            
            all_fitness.append(solution.fitness)
        
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
        
    def showGraphics(self, ):
        wins = []
        kills = []
        gold = []
        xs = []
        with open(path.abspath(f'files/{self.set}.npy'), "rb") as file:
            eof = False
            while(not eof):
                try:
                    values = load(file)
                    wins.append(values[0])
                    kills.append(values[1])
                    gold.append(values[2])
                    xs.append(values[3])
                    
                except ValueError:
                    eof = True
                    
        labels = [f'{int(dim)}x{int(dim)}' for dim in sorted(xs)]
        print(labels)
        print(wins)
        print(kills)
        print(gold)
        ax = plt.subplot(111)
        width = 0.35
        ax.bar(array(xs)-width, wins, width=width, label='wins')
        ax.bar(xs, kills, width=width, label='kills')
        ax.bar(array(xs)+width, gold, width=width, label='gold')
        ax.set_title("TEST")
        ax.legend(loc = "best")
        ax.grid(True)
        ax.set_xticks(sorted(xs))
        ax.set_xticklabels(labels)
        ax.autoscale(tight=True)
        plt.show()