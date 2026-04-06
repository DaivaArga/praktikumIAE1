<?php

namespace App\Controllers;

use App\Services\LibraryService;

class MemberController extends BaseController
{
    protected LibraryService $library;

    public function __construct()
    {
        $this->library = new LibraryService();
    }

    /**
     * Menampilkan daftar semua member
     */
    public function index(): string
    {
        $search = $this->request->getGet('search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $params = $search ? ['search' => $search] : [];
        $result = $this->library->getMembers($params);

        return view('members/index', [
            'title' => 'Daftar Member Perpustakaan',
            'members' => $result['data'] ?? [],
            'error' => $result['error'] ?? null,
            'search' => $search
        ]);
    }

    /**
     * Menampilkan detail satu member berdasarkan ID
     */
    public function detail(int $id): string
    {
        $result = $this->library->getMember($id);

        if (empty($result['data']) && !isset($result['error'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Member dengan ID $id tidak ditemukan.");
        }

        return view('members/detail', [
            'title' => 'Detail Member',
            'member' => $result['data'] ?? null,
            'error' => $result['error'] ?? null,
        ]);
    }

    /**
     * Update member berdasarkan ID (PUT)
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

        $result = $this->library->updateMember($id, $data);

        if (isset($result['error'])) {
            return $this->response->setStatusCode(400)->setJSON($result);
        }

        return $this->response->setJSON($result);
    }

    /**
     * Delete member berdasarkan ID (DELETE)
     */
    public function delete(int $id)
    {
        $method = $this->request->getMethod();
        if ($method !== 'DELETE') {
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Method not allowed']);
        }

        $result = $this->library->deleteMember($id);

        if (isset($result['error'])) {
            return $this->response->setStatusCode(400)->setJSON($result);
        }

        return $this->response->setJSON($result);
    }
}