<?php

namespace App\Http\Controllers\backoffice;

use App\Language;
use App\Tag;
use App\TagLang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('checkPermissions:tag');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // all tags
        $tags = Tag::all();
        return view('backoffice.tags.index', compact('tags'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $languages = Language::all();
        $tabsAdjust = 100 / $languages->count();
        return view('backoffice.tags.create_edt', compact('languages', 'tabsAdjust'));
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
        $tag = new Tag();
        $req->input('color') ? $tag->color = $req->input('color') : '';
        $tag->save();
        $languages = Language::all();
        foreach ($languages as $lang) {
            $tag_lang = new TagLang();
            $this->defaultLanguageCamps($req, $tag, $tag_lang, $lang);
        }

        $req->session()->flash('status-success', "The tag {$tag->name} was successfully created.");
        return redirect()->route('tag.edit', $tag->id);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $languages = Language::all();
        $tabsAdjust = 100 / $languages->count();
        return view('backoffice.tags.create_edt', compact('tag', 'languages', 'tabsAdjust'));
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
        $tag = Tag::findOrFail($id);
        $tag->update(
            [
                "color" => $req->input('color')
            ]
        );
        $languages = Language::all();
        foreach ($languages as $lang) {
            $tag_lang = TagLang::firstOrCreate(['tag_id' => $tag->id, 'language_id' => $lang->id]);
            $this->defaultLanguageCamps($req, $tag, $tag_lang, $lang);
        }
        $req->session()->flash('status-success', "The tag {$tag->name} was successfully updated.");
        return redirect()->route('tag.edit', $tag->id);
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
        $tag = Tag::findOrFail($id);
        try{
            $tag->delete();
            $req->session()->flash('status-success', "The tag {$tag->name} was successfully deleted.");
        }catch (\Exception $e) {
            $req->session()->flash('status-danger', "The tag {$tag->name} was unsuccessfully deleted.");
        }
        return redirect()->route('tag.index');
    }

    public function defaultLanguageCamps(Request $request, $object, $object_lang, $lang){
        $object_lang->language_id = $lang->id;
        $object_lang->tag_id = $object->id;

        $object_lang->name = $request->input("name_{$lang->slug}") ?: null;
        $object_lang->save();

    }

    public function validation($req)
    {
        $languages_to_validate = Language::where('STATUS', 1)->get();
        // This is needed to validate multiple languages camps
        $array_of_name_langs_to_validate = [];
        foreach ($languages_to_validate as $lang) {
            $array_of_name_langs_to_validate += ["name_{$lang->slug}" => 'required|min:3|max:50'];
        }

        $defaultRules = [];
        $req->validate(
            array_merge($defaultRules, $array_of_name_langs_to_validate),
        );
    }
}
