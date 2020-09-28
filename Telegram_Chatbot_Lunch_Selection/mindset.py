import numpy as np
import sqlite3


db_access = True

class ListDrawing:
    def __init__(self, t_name, run):
        global db_access
        self.table = t_name
        self.list_size = 0
        self.restaurant_list = {}
        self.rating_list = {}
        db_access = run
        if db_access:
            
            self.conn = sqlite3.connect("restaurant.db")
            # create table
            setup = "CREATE TABLE IF NOT EXISTS "+self.table+"( name TEXT, weight REAL, rating INT );"
            self.conn.cursor().execute(setup)
            self.conn.commit()
            # read database
            stmt = "SELECT * FROM "+self.table+";"
            cur = self.conn.cursor()
            cur.execute(stmt)
            self.conn.commit()
            all_r = cur.fetchall()
            # loading records 
            for r in all_r:
                print(r)
                self.restaurant_list[r[0]]= float(r[1])
                self.rating_list[r[0]]    = int(r[2])
            self.list_size = len(all_r)
            # rating mean



        else:
            self.list_size = 0
            self.restaurant_list = {}
            self.rating_list = {}


    def create(self, name):
        # repeated name checking
        for key in self.restaurant_list.keys():
            if key == name:
                return 0 # name exists already
        # for all old nodes
        update_scalar = self.list_size / (self.list_size + 1)
        for key in self.restaurant_list.keys():
            self.restaurant_list[key] = self.restaurant_list[key] * update_scalar
            if db_access == True:
                if db_access == True:
                    stmt = "UPDATE "+ self.table +" SET weight = "+ str(self.restaurant_list[key]) +" WHERE name = '"+key+"';"
                    print(stmt)
                    self.conn.execute(stmt)
                    self.conn.commit()
        # for the new node
        self.list_size += 1
        self.restaurant_list[name] = 1 / self.list_size
        # rating update
        self.rating_list[name] = 3

        if db_access == True:
            stmt = "INSERT INTO "+ self.table +"(name,weight,rating) VALUES ('"+name+"',"+str(self.restaurant_list[name])+","+str(self.rating_list[name])+");"
            print(stmt)
            self.conn.execute(stmt)
            self.conn.commit()

        return 1 # create success

    def delete(self, name):
        if self.list_size == 0:
            return -1 # no record
        try:
            self._refill(name)
            del self.restaurant_list[name]
            del self.rating_list[name]

            self.list_size -= 1

            if db_access == True:
                stmt = "DELETE FROM "+ self.table +" WHERE name = '"+ name +"';"
                self.conn.execute(stmt)
                self.conn.commit()
            

            return 1 # delete success
        except KeyError:
            return 0 #"name does not exist
    
    def rename(self,o_name,n_name):
        for key in self.restaurant_list.keys():
            if key == n_name:
                return 0 #new name exists already
        try:
            self.restaurant_list[n_name] = self.restaurant_list.pop(o_name)
            self.rating_list[n_name] = self.rating_list.pop(o_name)
            if db_access == True:
                stmt = "UPDATE "+ self.table +" SET name = '"+ n_name +"' WHERE name = '"+o_name+"';"
                self.conn.execute(stmt)
                self.conn.commit()
            return 1 # rename success
        except KeyError:
            return -1 #old name does not exist

    def update(self, w_dict):
        if len(w_dict) != self.list_size:
            return -1 # list size unmatch
        
        if sum(w_dict.values()) != 1:
            return 0 # sum is not equal 0
        
        for key in w_dict.keys():
            self.restaurant_list[key] = w_dict[key]
            if db_access == True:
                stmt = "UPDATE "+ self.table +" SET weight = "+ str(w_dict[key]) +" WHERE name = '"+key+"';"
                print(stmt)
                self.conn.execute(stmt)
                self.conn.commit()
        return 1 # update success
    
    def draw(self):
        # drawing
        result = np.random.choice(list(self.restaurant_list.keys()) , p = list(self.restaurant_list.values()))  
        # updating weight
        rating_mean = 0

        for key in self.restaurant_list.keys():
            if result != key:
                rating_mean += self.rating_list[key]
        rating_mean /= (self.list_size - 1)
        
        for key in self.restaurant_list.keys():
            if result != key:
                extra = self.rating_list[key] / rating_mean
                self.restaurant_list[key] += ( self.restaurant_list[result] * extra / (self.list_size - 1) )
                if db_access == True:
                    stmt = "UPDATE "+ self.table +" SET weight = "+ str(self.restaurant_list[key]) +" WHERE name = '"+key+"';"
                    print(stmt)
                    self.conn.execute(stmt)
                    self.conn.commit()
        # clear result weight
        self.restaurant_list[result] = 0
        if db_access == True:
                stmt = "UPDATE "+ self.table +" SET weight = "+ str(self.restaurant_list[result]) +" WHERE name = '"+result+"';"
                self.conn.execute(stmt)
                self.conn.commit()

        return result

    def _refill(self, result):
        rating_mean = 0

        for key in self.restaurant_list.keys():
            if result != key:
                rating_mean += self.rating_list[key]
        rating_mean /= (self.list_size - 1)
        
        for key in self.restaurant_list.keys():
            if result != key:
                extra = self.rating_list[key] / rating_mean
                self.restaurant_list[key] += ( self.restaurant_list[result] * extra / (self.list_size - 1) )
                if db_access == True:
                    stmt = "UPDATE "+ self.table +" SET weight = "+ str(self.restaurant_list[key]) +" WHERE name = '"+key+"';"
                    self.conn.execute(stmt)
                    self.conn.commit()
        # clear result weight
        self.restaurant_list[result] = 0
        if db_access == True:
                stmt = "UPDATE "+ self.table +" SET weight = "+ str(self.restaurant_list[result]) +" WHERE name = '"+result+"';"
                print(stmt)
                self.conn.execute(stmt)
                self.conn.commit()

        return 1

    def rating(self, name, score):
        try:
            if score > 5 or score < 1:
                return 0 # rating = {1,2,3,4,5}
            self.rating_list[name] = score
            if db_access == True:
                stmt = "UPDATE "+ self.table +" SET rating = "+ str(score) +" WHERE name = '"+name+"';"
                print(stmt)
                self.conn.execute(stmt)
                self.conn.commit()
            return 1
        except KeyError:
            return -1 # name does not exist
    # back-end


