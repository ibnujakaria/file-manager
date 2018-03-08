<?php

namespace Ibnujakaria\FileManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{

    public function index()
    {
        return view('file-manager::index');
    }
    
    public function listAllFiles(Request $request)
    {
        $directoriesList = \Storage::directories($request->input('path', '/'));
        $filesList = \Storage::files($request->input('path', '/'));

        $directories = [];
        $files = [];

        foreach ($directoriesList as $key => $directory) {
            $directories[] = [
                'name' => last(explode("/", $directory)),
                'path' => $directory,
                'size' => \Storage::size($directory),
                'last_modified' => \Carbon\Carbon::createFromTimestamp(\Storage::lastModified($directory))->diffForHumans()
            ];
        }

        foreach ($filesList as $key => $file) {
            $files[] = [
                'name' => last(explode("/", $file)),
                'path' => $file,
                'size' => \Storage::size($file),
                'last_modified' => \Carbon\Carbon::createFromTimestamp(\Storage::lastModified($file))->diffForHumans()
            ];
        }

        return compact('directories', 'files');
    }

    public function addDirectory(Request $request)
    {
        return json_encode([
            'result' => \Storage::makeDirectory($request->name)
        ]);
    }
}
