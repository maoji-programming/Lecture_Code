# In[0]: Library
from mindset import ListDrawing
import matplotlib.pyplot as plt
import numpy as np
N = input("How many?")
N  = int(N)
# In[1]: Add records
system1 = ListDrawing('simulation1', False)
system2 = ListDrawing('simulation2', False)
for i in range(N):
    system1.create(str(i))
    system2.create(str(i))
# In[2]: Different rating
for j in range(N):
    system1.rating(str(j),(j+1))
# In[3]: Statistic
frequency1 = list(np.zeros((N)))
frequency2 = list(np.zeros((N)))

for i in range(50000):
    result1 = int(system1.draw())
    result2 = int(system2.draw())
    frequency1[result1] += 1
    frequency2[result2] += 1
# Ploting 
x_list = list(range(0,N))

x = np.arange(len(x_list))  # the label locations
width = 0.35  # the width of the bars

fig, ax = plt.subplots()
rects1 = ax.bar(x - width/2, frequency1, width, label='with rating ')
rects2 = ax.bar(x + width/2, frequency2, width, label='without rating')

# Add some text for labels, title and custom x-axis tick labels, etc.
ax.set_ylabel('Frequency')
ax.set_title('Comparsion')
ax.set_xticks(x)
ax.set_xticklabels(x_list)
ax.legend()


def autolabel(rects):
    """Attach a text label above each bar in *rects*, displaying its height."""
    for rect in rects:
        height = rect.get_height()
        ax.annotate('{}'.format(height),
                    xy=(rect.get_x() + rect.get_width() / 2, height),
                    xytext=(0, 3),  # 3 points vertical offset
                    textcoords="offset points",
                    ha='center', va='bottom')


autolabel(rects1)
autolabel(rects2)

fig.tight_layout()

plt.show()