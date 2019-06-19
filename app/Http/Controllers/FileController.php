<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function downloadFile($fileName) {
        return response()->download(public_path('uploads/'.$fileName));
    }

    public function uploadFile(Request $request) {
        // $fileName = date('Ymd_His').'_upload';
        $fileName = $request->file('photo')->getClientOriginalName();
        $path = $request->file('photo')->move(public_path('/uploads/'), $fileName);
        $photoURL = url('api/file/'.$fileName);//url('/uploads/'.$fileName);
        return response()->json(['url' => $photoURL], 200);
    }

    public function deleteFile($fileName) {
        $file_path = public_path('/uploads/').$fileName;
        if(File::exists($file_path)){
            File::delete($file_path);
        } else {
            return response()->json([
                'status' => 'error', 
                'msg' => 'file not found'
            ], 404);
        }
        return response()->json(['status' => 'success'], 200);
    }

    public function getAllFiles() {
        foreach (File::files('uploads') as $file) {
             $files[] = $file->getFilename();
        }
        return response()->json(['files' => $files], 200);
    }
}
