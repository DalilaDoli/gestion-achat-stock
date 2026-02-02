<?php

namespace App\Http\Controllers\Referentiel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Famillearticle;
use App\Models\Emplacement;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();
        $famillearticles=Famillearticle::all();
        $emplacements=Emplacement::all();

        return view('referentiel.article', compact('articles','famillearticles','emplacements'));
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|max:255',
            'libelle' => 'required',
            'qte' => 'required',
            'pmp' => 'required',
            'famillearticle_id' => 'required',
            'emplacement_id' => 'required',

        ]);

        $article = Article::create($validatedData);

        return redirect('article');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $validatedData = $request->validate([
        //     'code' => 'required|max:255',
        //     'libelle' => 'required',
        //     'qte' => 'required',
        //     'pmp' => 'required',
        //     'famillearticle_id' => 'required',
        //     'emplacement_id' => 'required',
        // ]);

    
        Article::whereId($id)->update(
           [
            'code' =>   $request->code,
            'libelle' => $request->libelle,
            'qte'   => $request -> qte,
            'pmp' => $request -> pmp,
            'famillearticle_id' => $request -> famillearticle_id,
            'emplacement_id' => $request -> emplacement_id,
           ] 


    );
        return redirect('article');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::whereId($id)->delete();
        return redirect('article');
    }
}