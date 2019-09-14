<?php

namespace App\Http\Controllers\backoffice;

use App\Tag;
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
        return view('backoffice.tags.create_edt');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|min:3|max:50|unique:tags'
        ]);

        $tag = Tag::create([
            "name" => $req->input('name'),
            "color" => $req->input('color')
        ]);

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
        return view('backoffice.tags.create_edt', compact('tag'));
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
        $req->validate([
            'name' => 'required|min:3|max:50'
        ]);
        $tag = Tag::findOrFail($id);
        $tag->update(
            [
                "name" => $req->input('name'),
                "color" => $req->input('color')
            ]
        );
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
}
