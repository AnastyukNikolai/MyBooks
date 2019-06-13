<?php

namespace App\Http\Controllers;

use App\Events\onPublishAnonsEvent;
use App\Financial_operation;
use App\Http\Requests\AddChapterRequest;
use Exception;
use Google_Client;
use App\Chapter;
use App\Artwork;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
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

 function uploadFile(AddChapterRequest $request)
 {

     $artwork = Chapter::find($request->anons_id)->artwork;
     if ($artwork->user_id == Auth::id()) {
         $file_id = $this->createFile($request->file('text'));

     if ($request->anons_id) {

         $chapter = Chapter::find($request->anons_id);
         Chapter::find($request->anons_id)->update([
             'announcement' => false,
             'file_id' => $file_id,
             'min_amount' => null,
         ]);

         $operations = Financial_operation::where('receiver_id', $chapter->artwork->user->id)
             ->where('status_id', 3)
             ->where('type_id', 2)
             ->get();
         foreach ($operations as $operation) {
             if ($operation->chapter->chapter_id == $chapter->id) {
                 $operation->update([
                     'status_id' => 1,
                 ]);
             }
         }

         return redirect()->back()->with('success', 'Глава успешно опубликована');

     } else {


         $artwork = Artwork::find($request->artwork_id);

         $chapter = Chapter::create([
             'title' => $request->title,
             'price' => $request->price,
             'artwork_id' => $request->artwork_id,
             'file_id' => $file_id
         ]);

         return redirect()->back()->with('success', 'Глава успешно добавлена');

     }
 }
     else {
         return redirect()->back();
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