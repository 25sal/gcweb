# cgweb

## Installation

The following procedure has been tested in a docker container running ubuntu 20.04 Focal Fossa.

1. Install requirements
   ```bash
    $ sudo apt install apache2 mysql-server php php-mysql php-yaml php-sqlite3
    ```
2. move the git repository to the document root of the web server

3. In /etc/apache2/apache2.conf for *DocumentRoot*, change  
   **Allow override None** 
   to 
   **Allow override All**
   This is necessary to enable *.htaccess* in demo/data folder, to execute php code .xml files. 

4. Create the mysql database that containes users' profiles.
    
     create gcsimulator_ui database and import  gcsimulator_ui.sql in mysql
      ```bash
      $ mysql -u username -p gcsimulator_ui < demo/gcsimulator_ui.sql
      ```

5. Add a mysql user and grant privileges on database gcsimulator_ui 
   It is recommended, but not mandatory
6. Modify database configuration in *dashboard/include/DatabaseConfig.php*
   This file allows for database access to the web application
7. Create users folders 
   move demo/templates/users somewhere into the filesystem at "yourpath" and grant access to www-data (or to any other user that runs the webserver)
   The *users* directory containes an example of user folder that is currently called *eurecat*

## Configuration
### Register a new user
1. Register a new user at http://localhost/dashoard/register.php
   This adds a new record into the users table of gcsimulator_ui database. The process is not fully automatic (work in progress).
2. Manually insert a row in simulators table of gcsimulator_ui database for the new user
   Get the **id** field of the last record inserted into the users *table* (last registered user).
   For the new row it is important to set **workingdir** field equal to "yourpath"/eurecat/bin, or rename eurecat dir as you prefer and put the absolute path in that field. Set the **iduser** equal to the **id** field of the correspondendt user into the *users* table. Other parameters are relevant to interface the simulators.
3. Open "yourpath"/eurecat/bin/config.yaml and update  workingdir, simulationdir, webdir parameters
   In particular:
   * **workingdir** is the absolute path of the user folder set at the previous item.
   * **simulationdir** is **yourpath**/eurecat/Simulations
   * **simulation** is provaSim
   * **webdir** is any directory of the webserver
4. modify the **sim_dir** parameter in demo/config.php  to point to "yourpath"/eurecat/Simulations

## Interface the simulator
   To be done
