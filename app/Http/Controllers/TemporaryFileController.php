<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;

class TemporaryFileController extends Controller
{
    public function store(Request $request)
    {

            $file     = $request->image;
            $fileName  = $file->getClientOriginalName();
            $folder    = uniqid().'-'.now()->timestamp;
            $file->storeAs('images/tmp/'.$folder,$fileName);
            // create tmp file
            $temporartFile           = new TemporaryFile;
            $temporartFile->filename = $fileName;
            $temporartFile->folder   = $folder ;
            $temporartFile->save();
            return $folder;
    }

    public function delete(Request $request)
    {
        $filePath = $request->get('file_path');
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 404);
    }
    
}
