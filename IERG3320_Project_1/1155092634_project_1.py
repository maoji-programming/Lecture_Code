import re
import os
import math
import nltk
import numpy as np

#
# IERG3320/ESTR3306 Social Media and Human Information Interaction
# Mini Project One Sentiment Analysis – Project Specification
#
# 
# Text file: paragraph.txt
#

POSITIVE = 1
NEUTRAL = 0
NEGATIVE = -1

class Paragraph:
    def __init__(self,postfile):
        self.normal_content = []    # loading buffer
        self.analyze_content = []   # array of sentence object
        self.total_score = 0        # final score

# recognization set
        self.positive_set = []
        self.negative_set = []
        self.negation_set = ["no","nobody","nothing","not","cannot","don't","doesn't","should","never"]
        self.symbol_set = [',','-','"',"''","``",":"]

        sentence_enders = re.compile('[.!?\n]')

# post text loading
        with open(postfile,"r")as blog:
            self.normal_content = blog.read().splitlines()
        for para in self.normal_content:
            msen = sentence_enders.split(para)
            for sen in msen:
                syntax = Sentence(sen)
                self.analyze_content.append(syntax)

# postive word loading
        with open("positive-word.txt","r")as pf:
            self.positive_set = pf.read().splitlines()

# negative word loading
        with open("negative-word.txt","r")as nf:
            self.negative_set = nf.read().splitlines()

#
# recognize words and rewrite the format of them
#
# positive word -> <+VE> : a word with  +1 score in a sentence
# negative word -> <-VE> : a word with  -1 score in a sentence
# neutral word  -> <NEU> : a word with  +0 score in a sentence
# negation word -> <NAG> : a word with x-1 score in a sentence
# symbol        -> <SYM> : non-word
#
    def class_tranlating(self,sentence):
        for w in sentence.analyze_content:
            if w in main.positive_set or w == ":-)":
                sentence.PorN_factor = sentence.PorN_factor + POSITIVE
                sentence.wordnum = sentence.wordnum + 1
                sentence.class_content.append("<+VE>")
            elif w in main.negative_set:
                sentence.PorN_factor = sentence.PorN_factor + NEGATIVE
                sentence.wordnum = sentence.wordnum + 1
                sentence.class_content.append("<-VE>")
            elif w in main.negation_set:
                sentence.nega_factor = sentence.nega_factor + 1
                sentence.wordnum = sentence.wordnum + 1
                sentence.class_content.append("<NAG>")
            elif w in main.symbol_set:
                sentence.class_content.append("<SYM>")
            else:
                sentence.PorN_factor = sentence.PorN_factor + NEUTRAL
                sentence.class_content.append("<NEU>")
                sentence.wordnum = sentence.wordnum + 1
#
# sum the score of each sentence and divid the word count
# sum of (+1/-1 score * -1 ^ # of negation) divided by # of words
#        
    def show_score_result(self):
        result = 0
        total = 0
        for s in self.analyze_content:
            result = s.PorN_factor * math.pow(NEGATIVE, s.nega_factor) + result
            total = s.wordnum + total
        self.total_score = result / total
        print("The score of ["+blog_post+"] is "+str(self.total_score))
#
# polarity shows comment is positive or negative
#
    def show_polarity(self):
        if self.total_score > 0 :
            print("The polarity     is      positive")
        elif self.total_score < 0:
            print("The polarity     is      negative")
        else:
            print("The polarity     is      neutral")

class Sentence:
    def __init__(self,content):
        self.content = content  # string of the sentence
        self.analyze_content = nltk.word_tokenize(self.content) # split the sentence into string array
        self.class_content = [] # array of class represents words in the sentence
        self.score = 0          # score of the sentence
        self.PorN_factor = 0    # count +1/-1 score
        self.nega_factor = 0    # count # of negation
        self.wordnum = 0        # count # of word in sentence


if __name__ == '__main__':
    # file input
    blog_post = input("What is you input file?")
    if blog_post == "":
        blog_post = "paragraph.txt"
    # setting
    main = Paragraph(blog_post)
    # marking
    for s in main.analyze_content:
        main.class_tranlating(s)
    # result
    main.show_score_result()
    main.show_polarity()
