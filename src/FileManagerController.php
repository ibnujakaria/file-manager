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
                'type' => 'directory',
                'last_modified' => \Carbon\Carbon::createFromTimestamp(\Storage::lastModified($directory))->diffForHumans()
            ];
        }

        foreach ($filesList as $key => $file) {
            $files[] = [
                'name' => last(explode("/", $file)),
                'path' => $file,
                'size' => \Storage::size($file),
                'type' => 'file',
                'last_modified' => \Carbon\Carbon::createFromTimestamp(\Storage::lastModified($file))->diffForHumans()
            ];
        }

        return [
            'directoriesAndFiles' => array_merge($directories, $files)
        ];
    }

    public function addDirectory(Request $request)
    {
        return json_encode([
            'result' => \Storage::makeDirectory($request->name)
        ]);
    }

    public function uploadFiles(Request $request)
    {   
        $path = $request->path ? $request->path : '';

        foreach ($request->file('files') as $key => $file) {
            $file->storeAs($path, $file->getClientOriginalName());
        }

        return response()->json([
            'result' => true
        ]);
    }

    public function deleteDirectories(Request $request)
    {
        foreach ($request->input('directories', []) as $key => $directory) {
            \Storage::deleteDirectory($directory);
        }

        return json_encode(['result' => true]);
    }

    public function deleteFiles(Request $request)
    {
        foreach ($request->input('files', []) as $key => $file) {
            \Storage::delete($file);
        }

        return json_encode(['result' => true]);
    }
}
