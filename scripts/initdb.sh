#!/bin/bash
mysql -e "CREATE DATABASE gcsimulator_ui"
mysql -e "CREATE USER gcsimulator@localhost IDENTIFIED BY 'gcsimulator';"
mysql -e "GRANT ALL PRIVILEGES ON gcsimulator_ui.* TO 'gcsimulator'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"
mysql gcsimulator_ui < gcweb/demo/gcsimulator_ui.sql
