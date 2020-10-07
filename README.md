# cgweb

## Installation

Tested on ubuntu 20.04

1. Install requirement
    
    apt install apache2 mysql-server php php-mysql php-yaml php-sqlite3

2. move the git repository to the document root of the web server
3. Change Allow override None to Allow override All in /etc/apache2/apache2.conf for DocumentRoot

4. create gcsimulator_ui database and import  gcsimulator_ui.sql in mysql

5. adduser and grant privileges
6. modify database configuration in dashboard/include/DatabaseConfig.php
7. move demo/templates/users somewhere into the filesystem at "yourpath" and grant access to www-data
7. register a new user at localhost/dashoard/register.php
9. manually insert a row in simulators table for the new user
   use iduser of last inserted user (see id of users table) and set workingdir equal to "yourpath"/eurecat/bin, or copy eurecat dir to your preferred name
10. open "yourpath"/eurecat/bin/config.yaml and update  workingdir, simulationdir, webdir parameters
    ... to be continued
 
11. modify the sim_dir parameter in demo/config.php  to point to "yourpath"/eurecat/Simulations

