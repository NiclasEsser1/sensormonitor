<?php

class WeatherSensor extends APIConfig
{

    private $id, $lat, $long, $weather, $location, $weather_data, $location_data;

    function __construct($id, $lat, $long)
    {
        $this->id = $id;
        $this->lat = $lat;
        $this->long = $long;
        stream_context_set_default(array('http' => array(
                'proxy'           => APIConfig::PROXY,
                'request_fulluri' => true,),));
    }

    public function getWeather()
    {
        $str = 'http://api.openweathermap.org/data/2.5/weather?lat=.'.($this->lat).'&lon='.($this->long)."&APPID=".APIConfig::API_KEY;


        $this->weather_data = json_decode(file_get_contents($str));
        $this->weather = array(
            'nodeId' => $this->id, //$this->weather_data->name,
            'temperature' => $this->weather_data->main->temp-273,
            'humidity' => $this->weather_data->main->humidity,
            'pressure' => $this->weather_data->main->pressure,
            'voltage' => 2.4);
        return $this->weather;
    }
    public function sayHuman()
    {
        return;
    }
}
