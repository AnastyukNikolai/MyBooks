<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddChapterRequest;
use Exception;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class DriveController extends Controller
{
    private $drive;
    public function __construct(Google_Client $client)
    {
        $this->middleware(function ($request, $next) use ($client) {
            $client->refreshToken(Auth::user()->refresh_token);
            $client->setDeveloperKey("AIzaSyBf4rLeSJpr4XWD1ozBsgUZgWvc_aSsdOk");
            $client->addScope("https://www.googleapis.com/auth/drive");
            $this->drive = new Google_Service_Drive($client);
            return $next($request);
        });
    }

    public function getDrive(){
        $this->ListFolders('root');
    }

    public function ListFolders($id){

        $query = "mimeType='application/vnd.google-apps.folder' and '".$id."' in parents and trashed=false";

        $optParams = [
            'fields' => 'files(id, name)',
            'q' => $query
        ];

        $results = $this->drive->files->listFiles($optParams);


        if (count($results->getFiles()) == 0) {
            print "No files found.\n";
        } else {
            print "Files:\n";
            foreach ($results->getFiles() as $file) {
                dump($file->getName(), $file->getID());
            }
        }
    }

 function uploadFile(AddChapterRequest $request){

        if($request->isMethod('GET')){
            view('upload');
        }else{
            $this->createFile($request->file('text'));


        }

    }

    public function createStorageFile($storage_path){
        $this->createFile($storage_path);
    }

     function createFile($file, $parent_id = null){

        $name = gettype($file) === 'object' ? $file->getClientOriginalName() : $file;
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $name,
            'parent' => $parent_id ? $parent_id : 'root'
        ]);

        $data = gettype($file) === 'object' ?  File::get($file) : Storage::get($file);
        $mimeType = gettype($file) === 'object' ? File::mimeType($file) : Storage::mimeType($file);


        $file = $this->drive->files->create($fileMetadata, [
            'data' => $data,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

         return $file->id;
    }

    function deleteFileOrFolder($id){
        try {
            $this->drive->files->delete($id);
        } catch (Exception $e) {
            return false;
        }
    }

    function createFolder($folder_name){
        $folder_meta = new Google_Service_Drive_DriveFile(array(
            'name' => $folder_name,
            'mimeType' => 'application/vnd.google-apps.folder'));
        $folder = $this->drive->files->create($folder_meta, array(
            'fields' => 'id'));
        return $folder->id;
    }
}