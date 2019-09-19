<?php

class Config {
	//___required constants for SQLite-Database___
	const DB_PATH = '/var/www/html/sensormonitor/html/db/sensordata.db';
	//const DB_DSN = 'mysql:host=localhost;dbname=mydbname';
	const DB_DSN = 'sqlite:/var/www/html/sensormonitor/html/db/sensordata.db';
	//___required constants for MySQL-server___
	const DB_HOST = '';
	const DB_DATABASE = '';
	const DB_PORT = '';
	const DB_USER = '';
	const DB_PASSWORD = '';
}
