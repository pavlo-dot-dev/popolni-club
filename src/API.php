<?php

namespace PavloDotDev\PopolniClub;

use GuzzleHttp\Client;
use PavloDotDev\PopolniClub\Entities\Balance;
use PavloDotDev\PopolniClub\Entities\StatusBuilder;
use PavloDotDev\PopolniClub\Entities\TransactionBuilder;
use Psr\Http\Message\ResponseInterface;

class API
{
    protected readonly Client $client;
    public ResponseInterface $response;

    public function __construct(string $login, string $password)
    {
        $this->client = new Client([
            'base_uri' => 'https://popolni.club/api/',
            'headers' => [
                'Authorization' => 'Basic '.base64_encode("$login:$password"),
                'Content-Type' => 'application/json',
                'Expect' => '',
            ],
            'http_errors' => false,
        ]);
    }

    public function transaction(): TransactionBuilder
    {
        return new TransactionBuilder($this);
    }

    public function status(): StatusBuilder
    {
        return new StatusBuilder($this);
    }

    public function balance(): Balance
    {
        $data = $this->call('', ['balance' => '']);

        return new Balance(
            currentBalance: $data['currentBalance'],
            creditLimit: $data['creditLimit'],
        );
    }

    public function call(string $path, array $get = null, array $post = null): array
    {
        if ($get) {
            $path .= "?".http_build_query($get);
        }

        $this->response = $this->client->request($post ? 'POST' : 'GET', $path, [
            'json' => $post
        ]);

        $content = $this->response->getBody()->getContents();
        $data = @json_decode($content, true);
        if ($data === false || json_last_error()) {
            throw new \Exception($content);
        }

        if ($this->response->getStatusCode() !== 200) {
            throw new \Exception('Status '.$this->response->getStatusCode().' - '.print_r($data, true));
        }

        return $data;
    }
}
