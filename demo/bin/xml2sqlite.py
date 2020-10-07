import sqlite3
import xml.etree.ElementTree as ET
from argparse import ArgumentParser

NEIGHBOURHOOD_TYPE=1
households = {"house":2, "chargingStation":3}
device_types ={"heatercooler":4,"ChargingPoint":5,"backgroundload":6, "device":8}

class DBConfig():
    conn = None


    def createTree(self, schemafile, xmldir):
        db_filename = xmldir+"/db.sqlite"
        self.conn = sqlite3.connect(db_filename)
        schema_filename = schemafile
        with open(schema_filename, 'rt') as f:
            schema = f.read()
        self.conn.executescript(schema)
        f = open(xmldir+"/buildingNeighborhood.xml", "r")
        fileIntero = f.read()
        root = ET.fromstring(fileIntero)
        
        i=1
        query = "insert into static (nodeid,parentid,name,type) values(1,0,'neighborhood',"+str(NEIGHBOURHOOD_TYPE)+")"
        cursor = self.conn.cursor()
        cursor.execute(query)
        self.load_static_attributes(i,root)

        for htype in households.keys():
        
            for household in root.findall(htype):  # READ XML FILE
            
                i += 1
                parent_house=i
                houseId = household.get('id')
                query = "insert into static  (nodeid,parentid,name,type) values(?,1,?,"+str(households[htype])+")"
                cursor = self.conn.cursor()

                cursor.execute(query, (i,htype+"["+str(houseId)+"]",))
                self.load_static_attributes(i,household)
                for user in household.findall('user'):
                    for device in device_types.keys():
                        for instance in user.findall(device): 
                            i += 1

                            parent_device=i
                            device_id = instance.get('id')
                            if device_id is None:
                                device_id = instance.find('id').text
                            query = "insert into static  (nodeid,parentid,name,type) values(?,?,?,"+str(device_types[device])+")"
                            cursor = self.conn.cursor()

                            cursor.execute(query, (i,parent_house,device+"["+str(houseId)+"]:["+str(device_id)+"]",))
                            self.load_static_attributes(i,instance)
                            
                            if device == "ChargingPoint":
                                for ev in instance.findall("ecar"):
                                    i += 1
                                    device_id = instance.get('id')
                                    if device_id is None:
                                        device_id = instance.find('id').text
                                    query = "insert into static  (nodeid,parentid,name,type) values(?,?,?,7)"
                                    cursor = self.conn.cursor()
                                    cursor.execute(query, (i,parent_device,"ecar["+str(device_id)+"]",))
                                    self.load_static_attributes(i,ev)
                                    self.load_static_properties(i,ev)
                            else:
                                 self.load_static_properties(i,instance)


        self.conn.commit()
        self.conn.close()        

    def create_dynamic_parameters(self, schemafile, xmldir):            
        f = open(xmldir+"/loads.xml", "r")
        fileIntero = f.read()
        root = ET.fromstring(fileIntero)
        
    def load_static_attributes(self,idtree,xmlnode):
        for key in xmlnode.attrib:
            query = "insert into staticParameter(iddevice,key,val) values(?,?,?)"
            cursor = self.conn.cursor()
            cursor.execute(query, (idtree, key, xmlnode.get(key),))

    def load_static_properties(self,idtree,xmlnode):
        for child in xmlnode:
            query = "insert into staticParameter(iddevice,key,val) values(?,?,?)"
            cursor = self.conn.cursor()
            cursor.execute(query, (idtree, child.tag, child.text,))
   

if __name__ == "__main__":

   usage = "usage: %prog [options] dbschema xmldir"
   parser = ArgumentParser(usage)

   parser.add_argument("schema",metavar="DBSCHEMA")
   parser.add_argument("xmldir", metavar="XMLDIR")
                       
   args = parser.parse_args()
   db = DBConfig()
   db.createTree(args.schema, args.xmldir)
   
