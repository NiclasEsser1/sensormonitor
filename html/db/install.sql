-- DROP DATABASE IF EXISTS sensordata;
-- CREATE DATABASE sensordata;
-- ALTER DATABASE sensordata CHARACTER SET utf8;
-- USE sensordata;

-- DROP TABLE IF EXISTS measurement;


CREATE TABLE measurement(
    ID INTEGER PRIMARY KEY AUTOINCREMENT,
    nodeId INT,
    temperature FLOAT,
    humidity FLOAT,
    pressure FLOAT,
    voltage FLOAT,
    datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
