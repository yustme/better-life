<?php

namespace App\Repository;

use Keboola\StorageApi\Client as SapiClient;

class ConditionsRepository
{
    /** @var Client */
    private $sapiClient;

    public function __construct()
    {
        $this->sapiClient = new SapiClient([
            'url' => 'https://connection.eu-central-1.keboola.com/',
            'token' => '',
        ]);
    }

    public function getCityList()
    {
        $filters = [
            'columns' => ['city'],
            'format' => 'json',
            'whereFilters' => [
                [
                    'column' => 'city',
                    'operator' => 'ne',
                    'values' => [
                        '',
                    ],
                ],
                [
                    'column' => 'pocet_sale',
                    'operator' => 'gt',
                    'values' => ['100'],
                    'dataType' => 'INTEGER',
                ],
            ],
            'orderBy' => [
                [
                    'column' => 'city',
                    'order' => 'ASC',
                ],
            ],
            'limit' => 1000,
        ];
        return $this->sapiClient->getTableDataPreview('out.c-mistr-padak.cities_out', $filters);
    }

    public function getCity(string $cityName)
    {
        $filters = [
            'whereFilters' => [
                [
                    'column' => 'city',
                    'operator' => 'eq',
                    'values' => [
                        $cityName,
                    ],
                ],
            ],
            'format' => 'json',
        ];
        return $this->sapiClient->getTableDataPreview('out.c-mistr-padak.cities_out', $filters);
    }

    public function getCityIndeces(string $cityName)
    {
        $filter = [
            'whereFilters' => [
                [
                    'column' => 'city',
                    'operators' => 'eq',
                    'values' => [
                        $cityName,
                    ],
                ],
            ],
            'format' => 'json',
        ];
        $city = $this->sapiClient->getTableDataPreview('out.c-mistr-padak.cities_out', $filter);
        $cityId = $city['rows'][0][0]['value'];

        $filter = [
            'whereFilters' => [
                [
                    'column' => 'city_id',
                    'operators' => 'eq',
                    'values' => [
                        $cityId,
                    ],
                ],
            ],
            'format' => 'json',
        ];
        $indicies = $this->sapiClient->getTableDataPreview('out.c-vojta.index_with_values', $filter);
        $data = [];
        foreach ($indicies['rows'] as $row) {
            $data[$row[1]['value']] = $row[2]['value'];
        }
        return $data;
    }
}