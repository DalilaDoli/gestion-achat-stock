<?php

namespace App\Http\Controllers\Referentiel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fournisseur;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fournisseurs=Fournisseur::all();

        return view('referentiel.fournisseur',compact('fournisseurs'));
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
            'nom' => 'required',
            'adresse' => 'required',
            'rc' => 'required',
            'ai' => 'required',
            'nif' => 'required',
            'payment' => 'required',
        ]);
    
        $fournisseur = Fournisseur::create($validatedData);
    
        return redirect('fournisseur');
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
        $validatedData = $request->validate([
            'code' => 'required|max:255',
            'nom' => 'required',
            'adresse' => 'required',
            'rc' => 'required',
            'ai' => 'required',
            'nif' => 'required',
            'payment' => 'required',
        ]);

        Fournisseur::whereId($id)->update($validatedData);
        return redirect('fournisseur');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fournisseur=Fournisseur::whereId($id)->delete();
        return redirect('fournisseur');
    }
}
