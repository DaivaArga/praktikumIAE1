<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{// app/Http/Controllers/Api/MemberController.php

    // GET /api/members
    public function index(Request $request)
    {
        $query = \App\Models\Member::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('member_code', 'like', '%' . $request->search . '%');
        }

        return \App\Http\Resources\MemberResource::collection($query->orderBy('name')->get());
    }

    // GET /api/members/{id}
    public function show(string $id)
    {
        $member = \App\Models\Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan.',
            ], 404);
        }

        return response()->json(['success' => true, 'data' => new \App\Http\Resources\MemberResource($member)]);
    }

    // POST /api/members
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'member_code' => 'required|string|max:20|unique:members,member_code',
            'email' => 'required|email|unique:members,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,suspended',
            'joined_at' => 'nullable|date',
        ]);

        $member = \App\Models\Member::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil didaftarkan.',
            'data' => new \App\Http\Resources\MemberResource($member),
        ], 201);
    }

    // PUT /api/members/{id}
    public function update(Request $request, string $id)
    {
        $member = \App\Models\Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:150',
            'member_code' => 'sometimes|required|string|max:20|unique:members,member_code,' . $id,
            'email' => 'sometimes|required|email|unique:members,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,suspended',
            'joined_at' => 'nullable|date',
        ]);

        $member->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil diperbarui.',
            'data' => new \App\Http\Resources\MemberResource($member),
        ]);
    }

    // DELETE /api/members/{id}
    public function destroy(string $id)
    {
        $member = \App\Models\Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan.',
            ], 404);
        }

        if ($member->status === 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Member dengan status active tidak boleh dihapus.',
                'data' => ['name' => $member->name, 'status' => $member->status],
            ], 422);
        }

        $name = $member->name;
        $member->delete();

        return response()->json([
            'success' => true,
            'message' => "Member '$name' berhasil dihapus.",
        ], 200);
    }

    // PUT & DELETE → TUGAS MAHASISWA 📝
}
