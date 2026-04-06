<?php

namespace App\Controllers;

use App\Services\LibraryService; // Pastikan namespace service sudah benar
use CodeIgniter\HTTP\ResponseInterface;

class BookController extends BaseController
{
    // Menggunakan protected agar bisa diakses jika ada controller anak
    protected LibraryService $library;

    public function __construct()
    {
        // Pastikan file LibraryService.php berada di folder app/Services
        $this->library = new LibraryService();
    }

    /**
     * Menampilkan daftar semua buku
     */
    public function index(): string
    {
        // Mengambil input 'search' dari query string (?search=...)
        $search = $this->request->getGet('search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $params = $search ? ['search' => $search] : [];
        $result = $this->library->getBooks($params);

        return view('books/index', [
            'title' => 'Daftar Buku Perpustakaan',
            // Gunakan null coalescing operator untuk keamanan data
            'books' => $result['data'] ?? [],
            'error' => $result['error'] ?? null,
            'search' => $search // Kirim kembali keyword search ke view untuk mengisi input box
        ]);
    }

    /**
     * Menampilkan detail satu buku berdasarkan ID
     */
    public function detail(int $id): string
    {
        $result = $this->library->getBook($id);

        // Opsional: Jika data tidak ditemukan, bisa lempar 404
        if (empty($result['data']) && !isset($result['error'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Buku dengan ID $id tidak ditemukan.");
        }

        return view('books/detail', [
            'title' => 'Detail Buku',
            'book' => $result['data'] ?? null,
            'error' => $result['error'] ?? null,
        ]);
    }

    /**
     * Update buku berdasarkan ID (PUT)
     */
    public function update(int $id)
    {
        $method = $this->request->getMethod();
        if ($method !== 'PUT') {
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Method not allowed']);
        }

        $data = $this->request->getJSON(true);
        if (!$data) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid JSON data']);
        }

        $result = $this->library->updateBook($id, $data);

        if (isset($result['error'])) {
            return $this->response->setStatusCode(400)->setJSON($result);
        }

        return $this->response->setJSON($result);
    }

    /**
     * Delete buku berdasarkan ID (DELETE)
     */
    public function delete(int $id)
    {
        $method = $this->request->getMethod();
        if ($method !== 'DELETE') {
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Method not allowed']);
        }

        $result = $this->library->deleteBook($id);

        if (isset($result['error'])) {
            return $this->response->setStatusCode(400)->setJSON($result);
        }

        return $this->response->setJSON($result);
    }
}