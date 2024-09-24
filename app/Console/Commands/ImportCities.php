<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\City;
use Illuminate\Support\Str;

class ImportCities extends Command
{
    protected $signature = 'cities:import';
    protected $description = 'Парсинг городов России из API hh.ru';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $client = new Client();
        $url = 'https://api.hh.ru/areas';

        try {
            $response = $client->get($url);
            $areas = json_decode($response->getBody(), true);

            $russia = $this->findRussia($areas);

            if ($russia) {
                $this->parseCities($russia['areas']);
                $this->info('Города России успешно импортированы!');
            } else {
                $this->error('Россия не найдена в списке стран.');
            }
        } catch (\Exception $e) {
            $this->error('Ошибка при выполнении запроса: ' . $e->getMessage());
        }
    }

    /**
     *
     * @param array $areas
     */
    private function parseCities(array $areas)
    {
        foreach ($areas as $area) {
            if (!empty($area['areas'])) {
                $this->parseCities($area['areas']);
            } else {
                $this->saveCity($area);
            }
        }
    }

    /**
     *
     * @param array $city
     */
    private function saveCity(array $city)
    {
        $slug = $this->generateUniqueSlug($city['name']);

        City::updateOrCreate(
            ['name' => $city['name']],
            ['slug' => $slug]
        );

        $this->info("Город {$city['name']} с slug '{$slug}' успешно сохранен.");
    }

    /**
     *
     * @param string $name
     * @return string
     */
    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (City::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     *
     * @param array $areas
     * @return array|null
     */
    private function findRussia(array $areas): ?array
    {
        foreach ($areas as $area) {
            if ($area['parent_id'] === null && $area['name'] === 'Россия') {
                return $area;
            }
        }

        return null;
    }
}
