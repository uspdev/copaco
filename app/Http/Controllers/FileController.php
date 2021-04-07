<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Storage;

class FileController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('equipamentos.create');
        $request->validate([
            'file' => 'required',
            'equipamento_id' => 'required|integer|exists:equipamentos,id',
        ]);
        $file = new File;
        $file->equipamento_id = $request->equipamento_id;
        $file->original_name = $request->file('file')->getClientOriginalName();
        $file->mimetype = $request->file('file')->getClientMimeType();
        $file->path = $request->file('file')->store('.');
        $file->user_id = auth()->user()->id ;
        $file->save();
        return back();
    }

    public function show(File $file)
    {
        $this->authorize('equipamentos.view', $file->equipamento);
        return Storage::download($file->path, $file->original_name);
    }

    public function destroy(File $file)
    {
        $this->authorize('equipamentos.delete', $file->equipamento);
        Storage::delete($file->path);
        $file->delete();
        return back();
    }
}
