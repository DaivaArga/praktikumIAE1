<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // app/Http/Controllers/Api/BookController.php

    // GET /api/books
    public function index(Request $request)
    {
        $query = \App\Models\Book::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        return \App\Http\Resources\BookResource::collection($query->orderBy('title')->get());
    }

    // GET /api/books/{id}
    public function show(string $id)
    {
        $book = \App\Models\Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        return response()->json(['success' => true, 'data' => new \App\Http\Resources\BookResource($book)]);
    }

    // POST /api/books
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'author' => 'required|string|max:150',
            'isbn' => 'required|string|max:20|unique:books,isbn',
            'category' => 'nullable|string|max:100',
            'publisher' => 'nullable|string|max:150',
            'year' => 'nullable|integer|min:1900|max:2100',
            'stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $book = \App\Models\Book::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan.',
            'data' => new \App\Http\Resources\BookResource($book),
        ], 201);
    }

    // PUT /api/books/{id} → TUGAS MAHASISWA 📝
    public function update(Request $request, string $id)
    {
        $book = \App\Models\Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:200',
            'author' => 'sometimes|required|string|max:150',
            'isbn' => 'sometimes|required|string|max:20|unique:books,isbn,' . $id,
            'category' => 'nullable|string|max:100',
            'publisher' => 'nullable|string|max:150',
            'year' => 'nullable|integer|min:1900|max:2100',
            'stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $book->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil diperbarui.',
            'data' => new \App\Http\Resources\BookResource($book),
        ], 200);
    }

    // DELETE /api/books/{id} → TUGAS MAHASISWA 📝
    public function destroy(string $id)
    {
        $book = \App\Models\Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        if ($book->stock > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus buku yang masih memiliki stock.',
                'data' => ['title' => $book->title, 'stock' => $book->stock],
            ], 422);
        }

        $title = $book->title;
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => "Buku '$title' berhasil dihapus.",
        ], 200);
    }
}
