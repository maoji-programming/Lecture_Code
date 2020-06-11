Usage:

    python decode.py [cipher file]

Output:

    Key:[LOVE]
    Plain text:[ILOVECYBERSECURITYTHISFIELDISBECOMINGMOREIMPORTANTDUETOINCREASEDRELIANCEONCOMPUTERSYSTEMSTHEINTERNETANDWIRELESSNETWORKSTANDARDSSUCHASBLUETOOTHANDWIFIANDDUETOTHEGROWTHOFSMARTDEVICESINCLUDINGSMARTPHONESTELEVISIONSANDTHEVARIOUSDEVICESTHATCONSTITUTETHEINTERNETOFTHINGS]

Mechanism:

    Given the key length(4), we split cipher into 4 part corresponding to each key letter.
    For example:
        cipher text :abcdefghijkl
        group 1 : [a,e,i] 
        group 2 : [b,f,j]
        ...

    Then, we compared with the English frequency table[2] to each group to mapping the corresponding letter pair.
    And find out the offset which means the corresponding letter of the key

    To find the best of the fitness of mapping letters,
    We compute Chi-Square score of each shifting offset in each key element postion.

    Finally, for key element postion, we take the minimum of them which is the answer of key.

    Then, we decrypt the cipher using the key. 

    However, it may not get a correct key because the letter frequency of cipher is not similar to general case,
    then we may take the secord minimum Chi-Square score of each key element position

Reference: 

    [1] Keyword Recovery with the χ2 Method. (n.d.). Retrieved May 27, 2020, from https://pages.mtu.edu/~shene/NSF-4/Tutorial/VIG/Vig-Recover.htm
    [2] Micka, Pavel. Letter frequency (English). Algoritmy.net.
