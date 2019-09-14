<?php

namespace App\Http\Controllers\backoffice;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $model;
    private $viewDirFolder;
    private $storeValidation;
    private $updateValidation;
    public function __construct()
    {
        $this->middleware('checkPermissions:post');
        $this->model = Post::class;
        $this->viewDirFolder = "backoffice.posts.";
        $this->storeValidation = [
            'subject' => 'required|min:3|max:50|unique:posts',
            'body' => 'required|min:3|max:2500',
            "banner_image" => "required|image",
        ];
        $this->updateValidation = [
            'subject' => 'required|min:3|max:50',
            'body' => 'required|min:3|max:2500',
            "banner_image" => "required|image",
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // all tags
        $object_list = $this->model::all();
        return view($this->viewDirFolder . 'index', compact('object_list'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $tags = Tag::all();
        return view($this->viewDirFolder . 'create_edt', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $req->validate($this->storeValidation);
        $object = $this->model::create([
            "user_id" => Auth::id(),
            "subject" => $req->input('subject'),
            "body" => $req->input('body')
        ]);

        $object->status = $req->input('status') == "on" ? 1 : 0;
        $object->highlighted = $req->input('highlighted') == "on" ? 1 : 0;

        $object->tags()->sync($req->input("tags"));
        if ($req->banner_image) {
            if (is_file(public_path('storage/posts/' . $req->banner_image))) {
                unlink(public_path('storage/posts/' . $req->banner_image));
            }
            $imageName = time() . '_' . $req->banner_image->getClientOriginalName();
            $req->banner_image->move(public_path('storage/posts/'), $imageName);
            $object->banner_image = $imageName;
            $object->save();
        }
        $req->session()->flash('status-success', "The post {$object->subject} was successfully created.");
        return redirect()->route('post.edit', $object->id);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $object = $this->model::findOrFail($id);
        $tags = Tag::all();
        return view($this->viewDirFolder .'create_edt', compact('object', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $req->validate($this->updateValidation);
        $object = $this->model::findOrFail($id);
        $object->update(
            [
                "subject" => $req->input('subject'),
                "body" => $req->input('body')
            ]
        );
        $object->tags()->sync($req->input("tags"));
        if ($req->banner_image) {
            if($object->banner_image){
                unlink(public_path('storage/posts/' . $object->banner_image));
            }
            $imageName = time() . '_' . $req->banner_image->getClientOriginalName();
            $req->banner_image->move(public_path('storage/posts/'), $imageName);
            $object->banner_image = $imageName;
            $object->save();
        }
        $req->session()->flash('status-success', "The post {$object->subject} was successfully updated.");
        return redirect()->route('post.edit', $object->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $req
     * @param int $id
     * @return void
     */
    public function destroy(Request $req,$id)
    {
        $object = $this->model::findOrFail($id);


        try{
            $object->delete();
            if (is_file(public_path('storage/posts/' . $object->banner_image))) {
                unlink(public_path('storage/posts/' . $object->banner_image));
            }
            $req->session()->flash('status-success', "The post {$object->subject} was successfully deleted.");
        }catch (\Exception $e) {
            $req->session()->flash('status-danger', "The post {$object->subject} was unsuccessfully deleted.");
        }
        return redirect()->route('post.index');
    }
}
