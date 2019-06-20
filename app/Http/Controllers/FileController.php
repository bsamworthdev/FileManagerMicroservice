<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\RecursiveIteratorIterator;
use App\Http\Controllers\RecursiveDirectoryIterator;
use App\Http\Controllers\FileSystemIterator;

class FileController extends Controller
{
    public function downloadFile($fileName)
    {
        return response()->download(public_path('uploads/' . $fileName));
    }

    public function uploadFile(Request $request)
    {
        $fileName = $request->file('uploaded_file')->getClientOriginalName();
        
        //Move file to public/uploads folder
        $path = $request->file('uploaded_file')->move(public_path('/uploads/'), $fileName);

        //Fetch url and path
        $url = url('api/file/' . $fileName);
        $path = '/uploads/' . $fileName;

        return response()->json([
            'url' => $url,
            'path' => $path
        ], 200);
    }

    public function deleteFile($fileName)
    {
        $file_path = public_path('/uploads/') . $fileName;
        if (File::exists($file_path)) {
            //Delete File
            if ($fileName <> 'testimage.jpg') {
                File::delete($file_path);
            }
        } else {
            //File does not exist
            return response()->json([
                'status' => 'error',
                'msg' => 'file not found'
            ], 404);
        }
        return response()->json(['status' => 'success'], 200);
    }

    public function getAllFiles()
    {
        $files = [];
        //Build array of filenames of all files in uploads folder
        foreach (File::files(public_path('uploads')) as $file) {
            $fileName = $file->getFilename();
            if ($fileName <> 'testimage.jpg') {
                $files[] = $fileName;
            }
        }
        return response()->json(['files' => $files], 200);
    }

    public function getStorageSpace()
    {
        $size = $this->calculateFolderSize(public_path('/uploads/'));
        return response()->json(['bytes' => $size], 200);
    }

    private function calculateFolderSize($path)
    {
        $bytesTotal = 0;
        $path = realpath($path);
        if ($path !== false && $path != '' && File::exists($path)) {
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)) as $obj) {
                if ($obj->getFilename() <> 'testimage.jpg') {
                    $bytesTotal += $obj->getSize();
                }
            }
        }
        return $bytesTotal;
    }
}
