<?php
require_once 'autoload.php';

try {
    $dbh = new Database(new PDO(Config::DB_DSN, Config::DB_USER, Config::DB_PASSWORD));
}catch (PDOException $e) {
    exit($e->getMessage());
}
$sensor1 = new WeatherSensor(1,50, 7);
$sensor2 = new WeatherSensor(2,0, 0);
$sensor3 = new WeatherSensor(3,32, 21);
$sensor4 = new WeatherSensor(4,11, 17);

$sensors = array($sensor1, $sensor2, $sensor3, $sensor4);
foreach($sensors as $sensor)
{
    $sensor_data = $sensor->getWeather();
    $dbh->insert($sensor_data);
}
echo "updated sensor data";
