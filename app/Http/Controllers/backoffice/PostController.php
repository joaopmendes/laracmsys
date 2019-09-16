<?php

namespace App\Http\Controllers\backoffice;

use App\Language;
use App\Post;
use App\PostLang;
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
    /**
     * @var array
     */
    private $defaultValidations;

    public function __construct()
    {
        $this->middleware('checkPermissions:post');
        $this->model = Post::class;
        $this->viewDirFolder = "backoffice.posts.";
        $this->defaultValidations = [
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
        $languages = Language::all();
        $tabsAdjust = 100 / $languages->count();
        return view($this->viewDirFolder . 'create_edt', compact('tags', 'languages', 'tabsAdjust'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $this->validation($req);
        $object = $this->model::create([
            "user_id" => Auth::id(),
        ]);
        $object->status = $req->input('status') == "on" ? 1 : 0;
        $object->highlighted = $req->input('highlighted') == "on" ? 1 : 0;
        $object->save();

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
        $languages = Language::all();
        foreach ($languages as $lang) {
            $post_lang = new PostLang();
            $this->defaultLanguageCamps($req, $object, $post_lang, $lang);
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
        $languages = Language::all();
        $tabsAdjust = 100 / $languages->count();
        return view($this->viewDirFolder .'create_edt', compact('object', 'tags', 'languages', 'tabsAdjust'));
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
        $this->validation($req);
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
        $languages = Language::all();
        foreach ($languages as $lang) {
            $post_lang = PostLang::firstOrCreate(['post_id' => $object->id, 'language_id' => $lang->id]);
            $this->defaultLanguageCamps($req, $object, $post_lang, $lang);
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
    public function validation($req)
    {
        $languages_to_validate = Language::where('STATUS', 1)->get();
        // This is needed to validate multiple languages camps
        $array_of_name_langs_to_validate = [];
        foreach ($languages_to_validate as $lang) {
            $array_of_name_langs_to_validate += ["subject_{$lang->slug}" => 'required|min:3|max:50'];
            $array_of_name_langs_to_validate += ["body_{$lang->slug}" => 'required|min:3'];
        }

        $req->validate(
            array_merge($this->defaultValidations, $array_of_name_langs_to_validate),
        );
    }
    public function defaultLanguageCamps(Request $request, $object, $object_lang, $lang){
        $object_lang->language_id = $lang->id;
        $object_lang->post_id = $object->id;

        $object_lang->subject = $request->input("subject_{$lang->slug}") ?: null;
        $object_lang->body = $request->input("body_{$lang->slug}") ?: null;
        $object_lang->save();

    }


}
