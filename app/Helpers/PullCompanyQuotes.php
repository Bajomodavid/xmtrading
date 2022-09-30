<?php

namespace App\Helpers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PullCompanyQuotes {
    private string $apiUrl;
    private Client $client;
    private array $quotes;
    public string $symbol;
    public string $from;
    public string $to;

    public function __construct(string $symbol, string $from, string $to)
    {
        $this->symbol = $symbol;
        $this->apiUrl = config('exercise.endpoint');
        $this->client = new Client([
           'base_uri' => $this->apiUrl,
            'headers' => [
                'X-RapidAPI-Key' => config('exercise.apikey'),
                'X-RapidAPI-Host' => config('exercise.x-api-host'),
            ]
        ]);
        $this->quotes = [];
        $this->from = strtotime($from);
        $this->to = strtotime($to);
    }

    public function fetchQuotes(): void
    {
        try {
            $request = $this->client->get('/stock/v3/get-historical-data?symbol=' . $this->symbol . '&region=US');
            $this->quotes = (array)json_decode($request->getBody()->getContents())->prices;
            $this->quotes = array_reverse($this->quotes);
            $this->filter();
        } catch (GuzzleException $exception) {
            throw new BadRequestException($exception->getMessage(), $exception->getCode());
        }
    }

    public function filter()
    {
        for ($i = 0; $i < count($this->quotes); $i++) {
            if ($this->quotes[$i]->date >= $this->from) {
                if ($i > 0) {
                    array_splice($this->quotes, 0, $i+1);
                }
                break;
            }
        }

        $count = count($this->quotes);
        for ($i = 0; $i < $count; $i++) {
            if ($this->quotes[$i]->date >= $this->to) {
                $this->quotes = array_splice($this->quotes, $i, $count-$i);
                break;
            }
        }
    }

    public function getQuotes(): array
    {
        return $this->quotes;
    }
}