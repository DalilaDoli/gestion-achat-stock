<?php

namespace App\Http\Controllers\GestionAchat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emplacement;
use App\Models\Commande;
use App\Models\Dtcommande;
use App\Models\Reception;
use App\Models\Dtreception;

class ReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receptions=Reception::all();
        $cmds = Commande::select('commandes.id','commandes.code','commandes.date','commandes.fournisseur_id','commandes.user_id','statuts.id as statutid','statuts.num_id','statuts.table_nom','typestatuts.libelle')
                        ->leftjoin('statuts','statuts.num_id','commandes.id')
                        ->leftjoin('typestatuts','typestatuts.id','statuts.typestatut_id')
                        ->where('annul', 'N')
                        ->where('table_nom','DA')
                        ->where('typestatut_id',2)
                        ->orderby('statuts.created_at','desc')
                        ->get();
        $emplacements=Emplacement::all();
        
                        return view('gestionachat.reception',compact('receptions','cmds','emplacements'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
