<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * Pull json file containing company symbols
 */
class PullCompanyJson {
    private string $jsonUrl;
    private Client $client;
    private array $companies;

    public function __construct()
    {
        $this->jsonUrl = config('exercise.json_url');
        $this->client = new Client([
            'base_uri' => $this->jsonUrl,
        ]);
        $this->companies = [];
    }

    public function getJson(): void
    {
        try {
            $request = $this->client->get('/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json');
            $this->parseJson(json_decode($request->getBody()));
        } catch (GuzzleException $exception) {
            throw new BadRequestException($exception->getMessage(), $exception->getCode());
        }
    }

    private function parseJson(array $body): void
    {
        foreach ($body as $company) {
            $company = (array)$company;
            if (!in_array($this->companies, $company)) {
                $this->companies[] = $this->array_change_key_case_unicode($company);
            }
        }
    }

    public function getCompanies(): array
    {
        return $this->companies;
    }

    private function array_change_key_case_unicode($arr): array
    {
        $ret = [];
        foreach ($arr as $k => $v) {
            $ret[str_replace(' ', '_', mb_convert_case($k, MB_CASE_LOWER, "UTF-8"))] = $v;
        }
        return $ret;
    }
}