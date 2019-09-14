<?php

namespace App\Http\Controllers\backoffice;

use App\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkPermissions:file')->except('getAllFilesJson');
    }
    public function index()
    {
        $files = File::all();
        return view('backoffice.files.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {

        if ($req->file) {

                $file = $req->file;
                $obj = new File();
                $imageName = $file->getClientOriginalName();
                $obj->name = $imageName;
                $type = $file->getClientOriginalExtension();

                $obj->type = $type;
                $obj->image = self::isFileAImage($type);
                $obj->path = str_replace('public/', '', Storage::putFile('public/files', $file));

                $obj->save();
                return response()->json([
                    "success"=> "Image " . $imageName . " uploaded successfully",
                ], 200);

        }

        return response()->json([
            "error"=> "Image not recieved in server",
        ], 400);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    public function getAllFilesJson()
    {
        return File::all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $req
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $req, File $file)
    {
        Storage::delete($file->path);
        $file->delete();
        $req->session()->flash('status-success', "The file {$file->id} was successfully deleted.");

        return back();
    }
    public static function isFileAImage($fileType) {
        return ( $fileType === 'jpg' ||
            $fileType === 'png' ||
            $fileType === 'jpeg');
    }
}
