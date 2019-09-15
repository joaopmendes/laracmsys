<?php

namespace App\Http\Controllers\backoffice;

use App\Language;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkPermissions:language');

    }
    public function index()
    {
        $object_list = Language::all();
        return view(
          'backoffice.languages.index',
          compact('object_list')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backoffice.languages.create_edt');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'required|min:2|max:20',
            'name' => 'required|min:3|max:50'
        ]);
        $lang = Language::create($request->all());
        if(!$lang) {
            $request->session()->flash('status-error', "The language {$lang->name} couldn't be created.");
            return back();
        }
        $request->session()->flash('status-success', "The language {$lang->name} was successfully created.");
        return redirect()->route('language.edit', $lang->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        return view('backoffice.languages.create_edt', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req, Language $language)
    {
        if($language->id == 1){
            $req->session()->flash('status-error', "The language {$language->name} cannot be deleted because It's a core language");
            return redirect()->route('language.index');
        }
        $language->delete();
        $req->session()->flash('status-success', "The language {$language->name} was successfully deleted.");
        return redirect()->route('language.index');
    }
}
