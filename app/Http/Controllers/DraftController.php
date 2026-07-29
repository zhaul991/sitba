<?php

namespace App\Http\Controllers;

use App\Models\Draft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DraftController extends Controller
{

    public function index()
    {
        $drafts = Draft::with('uploader')
            ->latest()
            ->get();

        return view('draft.index', compact('drafts'));
    }



    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('draft.create');
    }



    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'nama_draft' => 'required|string|max:255',
            'file' => 'required|mimes:doc,docx|max:20480',
        ]);


        $path = $request->file('file')
            ->store('drafts', 'public');


        Draft::create([
            'nama_draft' => $validated['nama_draft'],
            'file' => $path,
            'uploaded_by' => Auth::id(),
        ]);


        return redirect()
            ->route('draft.index')
            ->with('success', 'Draft berhasil ditambahkan.');
    }


    public function preview(Draft $draft)
    {
        return response()->file(
            storage_path('app/public/' . $draft->file)
        );
    }



    public function download(Draft $draft)
    {
        return Storage::disk('public')
            ->download($draft->file);
    }



    public function destroy(Draft $draft)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($draft->file) {

            Storage::disk('public')
                ->delete($draft->file);

        }


        $draft->delete();


        return redirect()
            ->route('draft.index')
            ->with('success', 'Draft berhasil dihapus.');
    }

}
