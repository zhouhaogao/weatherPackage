<?php 


namespace zhouhaogao\OpenWeatherClient;

class OpenWeatherClient
{
    private $apiKey;

    /**
     * Creates a new OpenWeatherClient.
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Gets the weather for the given location.
     */
    public function getCurrentWeather($location)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'http://api.openweathermap.org/data/2.5/weather', [
            'query' => [
                'q' => $location->getCity() . ',' . $location->getState() . ',' . $location->getCountry(),
                'appid' => $this->apiKey,
                'units' => 'imperial'
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        return new \Liererkt\OpenWeatherClient\WeatherDay(
            new \DateTime('now'),
            $location,
            'imperial',
            $data['main']['temp'],
            $data['main']['feels_like'],
            $data['main']['pressure'],
            $data['main']['humidity']
        );
    }
}
