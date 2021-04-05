<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Storage;

class FileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimetypes:application/pdf,image/jpg,image/png,image/jpeg|max:12288',
            'equipamento_id' => 'required|integer|exists:equipamentos,id',
        ]);
        $file = new File;
        $file->equipamento_id = $request->equipamento_id;
        $file->original_name = $request->file('file')->getClientOriginalName();
        $file->path = $request->file('file')->store('.');
        $file->save();
        return back();
    }

    public function show(File $file)
    {
        return Storage::download($file->path, $file->original_name);
    }

    public function destroy(File $file)
    {
        Storage::delete($file->path);
        $file->delete();
        return back();
    }
}
