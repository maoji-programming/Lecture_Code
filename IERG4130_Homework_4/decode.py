import argparse
#
# IERG4130 - Assignment 4 Q2
# Name: Cheung Kam Ho
# SID:  1155092634
#
# Please see 'readme.txt' for more detail
#

# English frequency table
# Source from: 

# Debug table

F2 = {
        'A' : 0.082, 'B' : 0.014, 'C' : 0.028, 'D' : 0.038,
        'E' : 0.131, 'F' : 0.029, 'G' : 0.020, 'H' : 0.053,
        'I' : 0.064, 'J' : 0.001, 'K' : 0.004, 'L' : 0.034,
        'M' : 0.025, 'N' : 0.071, 'O' : 0.080, 'P' : 0.020,
        'Q' : 0.001, 'R' : 0.068, 'S' : 0.061, 'T' : 0.105,
        'U' : 0.025, 'V' : 0.009, 'W' : 0.015, 'X' : 0.002,
        'Y' : 0.020, 'Z' : 0.001
    }

# General table

F = {
        'A' : 0.08497, 'B' : 0.01492, 'C' : 0.02202, 'D' : 0.04253,
        'E' : 0.11162, 'F' : 0.02228, 'G' : 0.02015, 'H' : 0.06094,
        'I' : 0.07546, 'J' : 0.00153, 'K' : 0.01292, 'L' : 0.04025,
        'M' : 0.02406, 'N' : 0.06749, 'O' : 0.07507, 'P' : 0.01929,
        'Q' : 0.00095, 'R' : 0.07587, 'S' : 0.06327, 'T' : 0.09356,
        'U' : 0.02758, 'V' : 0.00978, 'W' : 0.02560, 'X' : 0.00150,
        'Y' : 0.01994, 'Z' : 0.00077
    }

# Cipher frequency table

f = {
        'A' : 0, 'B' : 0, 'C' : 0, 'D' : 0,
        'E' : 0, 'F' : 0, 'G' : 0, 'H' : 0,
        'I' : 0, 'J' : 0, 'K' : 0, 'L' : 0,
        'M' : 0, 'N' : 0, 'O' : 0, 'P' : 0,
        'Q' : 0, 'R' : 0, 'S' : 0, 'T' : 0,
        'U' : 0, 'V' : 0, 'W' : 0, 'X' : 0,
        'Y' : 0, 'Z' : 0
    }
    
# Moving function 
def next(c):
    return chr(((ord(c) + 66) % 26) + 65)

def shift(f_in):
    f_out = {}
    for key in f_in:
        f_out[key] = f_in[next(key)]
    return f_out

def chi_square():
    value = 0
    for i in f:
        value += ( pow((f[i] - F[i]),2) / F[i] )
    return value

# Decoding function
def add(txt_letter,key_letter):
    return (((ord(txt_letter) - 65) - (ord(key_letter) - 65)) % 26) + 65



# Command praser
parser = argparse.ArgumentParser(
    description='Assignment 4: frequency attack',
)
parser.add_argument('file', type=argparse.FileType('r'))
args = parser.parse_args()

# Counting number
key_length = 4 # setting key length
key_list = []
key_vector=[]
letter_block = []
switcher = 0
l = 0

cipher_text = ""
plain_text  = ""

for i in range(key_length):
    letter_block.append([])
    key_list.append([])
    
# Distributor
for sentence in args.file.readlines():
    for letter in sentence:
        if letter == '\n':
            continue
        else:
            letter_block[switcher].append(letter)
            cipher_text = cipher_text + letter
            switcher = (switcher + 1) % key_length
# Calculator
for row in letter_block:
    # Initialize
    for key in f:
        f[key] = 0
    # Counting
    for letter in row:
        f[letter] += 1

    # Standardize
    for key in f:
        f[key] /= len(row)
    
    # Finding all the chi-square value
    key_list[l].append(chi_square())
    for move in range(25):
        f = shift(f)
        key_list[l].append(chi_square())

    l += 1
# Finding the smallest value of chi-square in each key element
for il in range(key_length):
    ans = key_list[il].index(min(key_list[il]))

    key_vector.append(chr(ans+65))

# Decrypter
switcher = 0

for letter in cipher_text:
    temp_letter = add(letter,key_vector[switcher])
    plain_text = plain_text + chr(temp_letter)
    switcher = (switcher + 1) % key_length

# Result
print("=====The key=======================")
print("".join(key_vector))
print("=====The plain text================")
print(plain_text)

