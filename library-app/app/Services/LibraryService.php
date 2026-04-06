<?php
namespace App\Services;

use Config\LibraryApi;

class LibraryService
{
    protected LibraryApi $config;

    public function __construct()
    {
        $this->config = config('LibraryApi');
    }

    public function getBooks(array $params = []): array
    {
        $url = $this->config->baseUrl . '/books';
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        return $this->fetch($url);
    }

    public function getBook(int $id): array
    {
        $url = $this->config->baseUrl . '/books/' . $id;
        return $this->fetch($url);
    }

    public function createBook(array $data): array
    {
        $url = $this->config->baseUrl . '/books';
        return $this->fetch($url, 'POST', $data);
    }

    public function updateBook(int $id, array $data): array
    {
        $url = $this->config->baseUrl . '/books/' . $id;
        return $this->fetch($url, 'PUT', $data);
    }

    public function deleteBook(int $id): array
    {
        $url = $this->config->baseUrl . '/books/' . $id;
        return $this->fetch($url, 'DELETE');
    }

    public function getMembers(array $params = []): array
    {
        $url = $this->config->baseUrl . '/members';
        if (!empty($params))
            $url .= '?' . http_build_query($params);
        return $this->fetch($url);
    }

    public function getMember(int $id): array
    {
        $url = $this->config->baseUrl . '/members/' . $id;
        return $this->fetch($url);
    }

    public function createMember(array $data): array
    {
        $url = $this->config->baseUrl . '/members';
        return $this->fetch($url, 'POST', $data);
    }

    public function updateMember(int $id, array $data): array
    {
        $url = $this->config->baseUrl . '/members/' . $id;
        return $this->fetch($url, 'PUT', $data);
    }

    public function deleteMember(int $id): array
    {
        $url = $this->config->baseUrl . '/members/' . $id;
        return $this->fetch($url, 'DELETE');
    }

    private function fetch(string $url, string $method = 'GET', array $body = []): array
    {
        $ch = curl_init();

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
            ],
        ];

        if ($method === 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = json_encode($body);
        } elseif ($method === 'PUT') {
            $options[CURLOPT_CUSTOMREQUEST] = 'PUT';
            $options[CURLOPT_POSTFIELDS] = json_encode($body);
        } elseif ($method === 'DELETE') {
            $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        }

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error)
            return ['error' => 'Gagal terhubung ke API: ' . $error];

        $data = json_decode($response, true);
        if ($httpCode >= 400)
            return ['error' => $data['message'] ?? 'Terjadi kesalahan.'];

        return $data;
    }
}