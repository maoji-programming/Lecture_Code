import numpy as np
import queue
import copy
import scipy.stats
import math
import matplotlib.pyplot as plt
class person:
    def __init__(self, in_time, ser_time):
        self.start_time = in_time
        self.waiting_time = 0
        self.service_time = ser_time
        self.end_time = in_time + ser_time + self.waiting_time

    def set_waiting_time(self, value):
        self.waiting_time = value
        self.end_time = self.start_time + self.service_time + value

def birth_series(queue):
    list_b = []
    for i in queue:
        list_b.append(i.start_time)
    return list_b

def death_series(queue):
    list_d = []
    for i in queue:
        list_d.append(i.end_time)
    return list_d

def waiting_series(queue):
    list_w = []
    for i in queue:
        list_w.append(i.waiting_time)
    return list_w

def service_series(queue):
    list_s = []
    for i in queue:
        list_s.append(i.service_time)
    return list_s
def get_total_idle(queue):
    list_i = []
    for i in range(len(queue) - 1):
        ele_i = max(0,queue[i + 1].start_time - queue[i].end_time)
        list_i.append(ele_i)
    return np.sum(list_i) + queue[0].start_time
        
def state_list(queue):
    s_list = []
    b_ptr = 0
    d_ptr = 0
    for t in range(int(N[-1].end_time)):
        temp_list_b = []
        temp_list_d = []
        while birth_series(queue)[b_ptr] < t:
            
            temp_list_b.append(birth_series(queue)[b_ptr])

            b_ptr += 1
            #print(b_ptr)
        while death_series(queue)[d_ptr] < t:

            temp_list_d.append(death_series(queue)[d_ptr])

            d_ptr += 1

        state = len(temp_list_b) - len(temp_list_b)
        s_list.append(state)
    
    return s_list
    
# Input Parameters

arrival_rate = float(input("Enter Job Arrival Rate (/sec): "))
service_rate = float(input("Enter Job Service Rate (/sec): "))
print("Select the method..")
print("(1) Count Base Method")
print("(2) Time Base Method")
choice = int(input("Enter the Algorithm No: "))
# Output Parameters
emp_arrival_rate = 0.0
emp_service_rate = 0.0
# Parameter initialize

epilson = 0.1
delta = 0.1
test_length = 200

# research bound

count_bound = 2 * int((pow(arrival_rate,2) + pow(service_rate,2))/(pow(epilson,2)) * np.log(1/delta))
#time_bound = int((pow(arrival_rate,2) + pow(service_rate,2))/(pow(epilson,2)) * np.log(1/delta))

time_bound =  2 * int((math.ceil(arrival_rate) + math.ceil(service_rate/arrival_rate))/(pow(epilson,2))*np.log(1/delta))

confidence = [0,0]

# Count Based : Find the fixed required count with arbitrary time
if choice == 1:
    birth_list = {}
    death_list = {}
    for t in range(test_length):
        #
        # Queue Sampling
        #
        N = []
        B = 0
        D = 0
        previous = person(0,0)
        current = person(0,0)
        birth_dif_l = []
        while True:
            
            
            birth_dif = np.random.exponential(1/arrival_rate)
            B = B + birth_dif # each customer start differene is EXP
            birth_dif_l.append(birth_dif)

            S = np.random.exponential(1/service_rate) # serve time is EXP
            current = person(B,S)
            
            if previous.end_time > current.start_time:
                current.set_waiting_time(previous.end_time - current.start_time)
            else:
                current.set_waiting_time(0)
            
            previous = current
            N.append(current)
            
            if len(N) > count_bound :
                break


        last_time_b = int(np.max(birth_series(N)))
        last_time_d = int(np.max(death_series(N)))
        
        
        emp_arrival_rate = 1/np.mean(birth_dif_l)
        emp_service_rate = 1/np.mean(service_series(N))

        birth_list[t] = emp_arrival_rate
        death_list[t] = emp_service_rate
        
        if max(abs(arrival_rate - emp_arrival_rate) ,abs(service_rate - emp_service_rate)) <= epilson :
            #print("ACC")
            confidence[0] += 1 #accept
        else:
            #if abs(service_rate - emp_service_rate) > epilson:

            #   print("service error"+str(emp_service_rate))

            #if abs(arrival_rate - emp_arrival_rate) > epilson:

            #    print("arrive error"+str(emp_arrival_rate))
            confidence[1] += 1 #reject




    # if abs(arrival_rate - emp_arrival_rate) <= epilson:
    #     confidence[0] += 1 #accept
    # else:
    #     confidence[1] += 1 #reject
    prob_true = confidence[0]/np.sum(confidence)
    
    print("===========================================================")
    print("probably correctness:\t\t"+ str(prob_true))
    print("Required count bound:\t\t"+str(int(count_bound)))
    print("Required time:\t\t\t"+str(N[-1].end_time))
    print("The mean empirical lambda:\t"+str(np.mean(list(birth_list.values()))))
    print("The mean empirical mu:\t\t"+str(np.mean(list(death_list.values()))))
    print("===========================================================\n")
    print("\nSelect the result..")
    print("(a) Last Schedule")
    print("(b) Parameter Hypothesis")
    print("(c) Both")
    choice = str(input("Enter the result choice: "))
    if choice == 'a' or choice == 'c':
        plt.barh(range(len(birth_series(N))),  waiting_series(N), left=birth_series(N),color='blue' )
        plt.barh(range(len(birth_series(N))),  service_series(N), left=np.add(birth_series(N),waiting_series(N)),color='red' )
        plt.yticks(range(len(birth_series(N))), np.arange(1,max(len(birth_series(N))+1,len(death_series(N))+1)))
        plt.show()
    if choice == 'b' or choice == 'c':
        plt.plot(list(birth_list.keys()),list(birth_list.values()))
        plt.plot(list(death_list.keys()),list(death_list.values()))
        plt.plot(list(birth_list.keys()),np.ones([list(birth_list.keys())[-1]+1])*arrival_rate+epilson,'r')
        plt.plot(list(birth_list.keys()),np.ones([list(birth_list.keys())[-1]+1])*arrival_rate-epilson,'r')
        plt.plot(list(death_list.keys()),np.ones([list(death_list.keys())[-1]+1])*service_rate+epilson,'r')
        plt.plot(list(death_list.keys()),np.ones([list(death_list.keys())[-1]+1])*service_rate-epilson,'r')
        plt.legend()
        plt.show()
# Time Based : Find the fixed required time with arbitrary count
elif choice == 2:
    birth_list = {}
    death_list = {}
    for t in range(test_length):
        #
        # Queue Sampling
        #
        N = []
        B = 0
        D = 0
        previous = person(0,0)
        current = person(0,0)
        while True:
        #for i in range(time_bound):
            B = B + np.random.exponential(1/arrival_rate) # each customer start differene is EXP
            S = np.random.exponential(1/service_rate) # serve time is EXP
            current = person(B,S)
            if previous.end_time > current.start_time:
                current.set_waiting_time(previous.end_time - current.start_time)
            else:
                current.set_waiting_time(0)
            previous = current
            N.append(current)
            # sonmthing wrong here!!!!
            if N[-1].start_time > time_bound and N[-1].end_time > time_bound:
                #N.pop(-1)
                break

        #last_time_b = int(np.max(birth_series(N)))
        #last_time_d = int(np.max(death_series(N)))

        # Count based -> Time based
        bs = birth_series(N)
        #bs.insert(0,0)
        #bs = np.diff(bs)

        C_b = np.zeros(max(time_bound,int(N[-1].start_time+1)))
        for i in range(len(N)):
            C_b[ int(bs[i]) ] += 1
        # Arrival rate estimation
        emp_arrival_rate = np.sum(C_b)/math.ceil(N[-1].start_time)

        ds = death_series(N)
        #ds.insert(0,0)
        #ds = np.diff(ds)
        
        C_d = np.zeros(max(time_bound,int(N[-1].end_time+1)))
        for i in range(len(N)):
            C_d[ int(ds[i])] += 1
        # Filtering
        # for i in C_d:
        #     new_C_d = C_d[C_d != 0]
        # Service rate estimation
        
        emp_service_rate = np.sum(C_d)/np.sum(service_series(N))
        
        birth_list[t] = emp_arrival_rate
        death_list[t] = emp_service_rate

        if max(abs(arrival_rate - emp_arrival_rate) ,abs(service_rate - emp_service_rate)) <= epilson :
            #print("ACC")
            confidence[0] += 1 #accept
        else:
            #print("REJ")
            # if abs(service_rate - emp_service_rate) > epilson:

            #     print(str(t)+": service error"+str(emp_service_rate))

            # if abs(arrival_rate - emp_arrival_rate) > epilson:

            #     print(str(t)+": arrive error"+str(emp_arrival_rate))
            confidence[1] += 1 #reject
        
    prob_true = confidence[0]/np.sum(confidence)
    
    print("===========================================================")
    print("probably correctness:\t\t"+ str(prob_true))
    print("Required time bound:\t\t"+str(int(time_bound)))
    print("Required count:\t\t\t"+str(len(N)))
    print("The mean empirical lambda:\t"+str(np.mean(list(birth_list.values()))))
    print("The mean empirical mu:\t\t"+str(np.mean(list(death_list.values()))))
    print("===========================================================\n")
    print("\nSelect the result..")
    print("(a) Last Schedule")
    print("(b) Parameter Hypothesis")
    print("(c) Both")
    choice = str(input("Enter the result choice: "))
    if choice == 'a' or choice == 'c':
        plt.barh(range(len(birth_series(N))),  waiting_series(N), left=birth_series(N),color='blue' )
        plt.barh(range(len(birth_series(N))),  service_series(N), left=np.add(birth_series(N),waiting_series(N)),color='red' )
        plt.yticks(range(len(birth_series(N))), np.arange(1,max(len(birth_series(N))+1,len(death_series(N))+1)))
        plt.show()
    if choice == 'b' or choice == 'c':
        plt.plot(list(birth_list.keys()),list(birth_list.values()),label="lambda")
        plt.plot(list(death_list.keys()),list(death_list.values()),label="mu")
        plt.plot(list(birth_list.keys()),np.ones([list(birth_list.keys())[-1]+1])*arrival_rate+epilson,'r')
        plt.plot(list(birth_list.keys()),np.ones([list(birth_list.keys())[-1]+1])*arrival_rate-epilson,'r')
        plt.plot(list(death_list.keys()),np.ones([list(death_list.keys())[-1]+1])*service_rate+epilson,'r')
        plt.plot(list(death_list.keys()),np.ones([list(death_list.keys())[-1]+1])*service_rate-epilson,'r')
        plt.legend()
        plt.show()
    # plt.barh(range(len(birth_series(N))),  waiting_series(N), left=birth_series(N),color='blue' )
    # plt.barh(range(len(birth_series(N))),  service_series(N), left=np.add(birth_series(N),waiting_series(N)),color='red' )
    # plt.yticks(range(len(birth_series(N))), np.arange(1,max(len(birth_series(N))+1,len(death_series(N))+1)))
    # plt.show()

    # plt.plot(list(birth_list.keys()),list(birth_list.values()))
    # plt.plot(list(death_list.keys()),list(death_list.values()))
    # plt.plot(list(birth_list.keys()),np.ones([list(birth_list.keys())[-1]+1])*arrival_rate+epilson,'r')
    # plt.plot(list(birth_list.keys()),np.ones([list(birth_list.keys())[-1]+1])*arrival_rate-epilson,'r')
    # plt.plot(list(death_list.keys()),np.ones([list(death_list.keys())[-1]+1])*service_rate+epilson,'r')
    # plt.plot(list(death_list.keys()),np.ones([list(death_list.keys())[-1]+1])*service_rate-epilson,'r')
    # plt.show()


        
