<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobNews;

class JobNewsController extends Controller
{
    // 🔍 Freelancer lihat job published
    public function index()
    {
        $jobs = JobNews::where('status', 'published')
            ->with('employer:id,name,email')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'List job published',
            'data' => $jobs
        ]);
    }

    // 👨‍💼 Employer lihat job miliknya
    public function myJobs()
    {
        $user = auth()->user();

        $jobs = JobNews::where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'List job milik anda',
            'data' => $jobs
        ]);
    }

    // ➕ Create Job
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isEmployer() && !$user->isAdmin()) {
            return response()->json(['message' => 'Hanya admin dan employee yang boleh'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|in:draft,published'
        ]);

        $job = JobNews::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'draft'
        ]);

        return response()->json([
            'message' => 'Job berhasil dibuat',
            'data' => $job
        ]);
    }

    // 🔎 Detail Job
    public function show($id)
    {
        $job = JobNews::with('employer:id,name,email')->find($id);

        if (!$job) {
            return response()->json(['message' => 'Job tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail job',
            'data' => $job
        ]);
    }

    // ✏️ Update Job
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $job = JobNews::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job tidak ditemukan'], 404);
        }

        // hanya pemilik job atau admin
        if ($job->user_id != $user->id && !$user->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status' => 'sometimes|in:draft,published'
        ]);

        $job->update($request->only(['title', 'description', 'status']));

        return response()->json([
            'message' => 'Job berhasil diupdate',
            'data' => $job
        ]);
    }

    // 🗑️ Delete Job
    public function destroy($id)
    {
        $user = auth()->user();

        $job = JobNews::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job tidak ditemukan'], 404);
        }

        // hanya pemilik atau admin
        if ($job->user_id != $user->id && !$user->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $job->delete();

        return response()->json([
            'message' => 'Job berhasil dihapus'
        ]);
    }
}
