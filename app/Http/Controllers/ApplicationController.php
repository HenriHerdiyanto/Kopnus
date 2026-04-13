<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\JobNews;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function apply(Request $request, $jobId)
    {
        $user = auth()->user();

        // hanya freelancer & admin
        if (!$user->isFreelancer() && !$user->isAdmin()) {
            return response()->json([
                'message' => 'Admin dan Employee Tidak boleh apply'
            ], 403);
        }

        // cek job
        $job = JobNews::where('id', $jobId)
            ->where('status', 'published')
            ->first();

        if (!$job) {
            return response()->json([
                'message' => 'Job tidak ditemukan atau belum published'
            ], 404);
        }

        // ❗ VALIDASI: hanya 1x apply
        $alreadyApplied = Application::where('job_id', $jobId)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyApplied) {
            return response()->json([
                'message' => 'Kamu sudah melamar job ini'
            ], 400);
        }

        // validasi file CV
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048'
        ]);

        // upload CV
        $file = $request->file('cv');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('cv', $fileName, 'public');

        // simpan aplikasi
        $application = Application::create([
            'job_id' => $jobId,
            'user_id' => $user->id,
            'cv_file' => $path
        ]);

        return response()->json([
            'message' => 'Lamaran berhasil dikirim',
            'data' => $application
        ]);
    }

    // 1. Method untuk Employer melihat pelamar di job miliknya
    public function getApplicants($jobId)
    {
        $user = auth()->user();

        // Pastikan job milik user yang login (sebagai employer)
        $job = JobNews::where('id', $jobId)->where('user_id', $user->id)->first();

        if (!$job) {
            return response()->json(['message' => 'Job tidak ditemukan atau bukan milik Anda'], 404);
        }

        $applicants = Application::where('job_id', $jobId)->with('user')->get();

        return response()->json([
            'job' => $job->title,
            'applicants' => $applicants
        ]);
    }

    // 2. Method untuk Accept / Reject
    public function updateStatus(Request $request, $applicationId)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        $application = Application::find($applicationId);

        // Pastikan job milik employer yang login
        if (!$application || $application->job->user_id !== auth()->id()) {
            return response()->json(['message' => 'Aplikasi tidak ditemukan atau tidak memiliki akses'], 404);
        }

        $application->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Status berhasil diupdate',
            'application' => $application
        ]);
    }
}
