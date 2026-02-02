<?php

namespace App\Http\Controllers\GestionStock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Emplacement;
use App\Models\Dtcommande;
use App\Models\Statut;
use App\Models\Reception;
use App\Models\DtReception;
use App\Models\Mouvement;
use App\Models\Inventaire;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Article;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Auth;

class ReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receptions = Reception::where('annul', 'N')->get();
        $articles = Article::all();
        $fournisseurs = Fournisseur::all();
        $cmds = Commande::select('commandes.id','commandes.code','commandes.date','commandes.fournisseur_id','commandes.user_id','statuts.id as statutid','statuts.num_id','statuts.table_nom','typestatuts.libelle')
                        ->leftjoin('statuts','statuts.num_id','commandes.id')
                        ->leftjoin('typestatuts','typestatuts.id','statuts.typestatut_id')
                        ->where('annul', 'N')
                        ->where('table_nom','CMD')
                        ->where('typestatut_id',2)
                        ->orderby('statuts.created_at','desc')
                        ->get();
        $emplacements=Emplacement::all();
       
        return view('gestionstock.reception', compact('receptions', 'cmds','articles','emplacements'));
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
        if ($request->article_id) {

            $mat = Reception::where('code', 'LIKE', "%" . date("Y") . "%")
                ->count();

            $reception = new Reception;
            $reception->code = sprintf('RE' . date("Y") . '%06d', $mat + 2);
            $reception->date = date('Y-m-d H:i:s', strtotime($request->input('date')));
            $reception->fournisseur_id = $request->input('fournisseur_id');
            $reception->num_bl = $request->input('num_bl');
            $reception->date_bl = $request->input('date_bl');
            $reception->fac_num = $request->input('num_fac');
            $reception->date_fac = $request->input('date_fac');
            $reception->user_id = Auth::user()->id;
            $reception->commande_id = $request->input('idcmd');
            $reception->emplacement_id = $request->input('emplacement_id');
            $reception->save();

            // //statut Reception
            Statut::create([
                'typestatut_id' => '1',
                'date' => date('Y-m-d H:i:s', strtotime($request->input('date'))),
                'num_id' => $reception->id,
                'table_nom' => 'RECEPTION',

            ]);

            //statut Cmd
            Statut::create([
                'typestatut_id' => '5',
                'date' => date('Y-m-d H:i:s', strtotime($request->input('date'))),
                'num_id' => $request->input('idcmd'),
                'table_nom' => 'CMD',

            ]);

            //detail Da
            for ($i = 0; $i < count($request->article_id); $i++) {
                $article_id = $request->article_id[$i];
                $prix_u = $request->prix_uart[$i];
                $qt = $request->qte[$i];
                

                $pu=$request->prix_uart[$i] * $request->qteart[$i];
                $pr=$request->prix_ucmd[$i] * $request->qte[$i];
                $pur=$pu + $pr;
                $qteart=$request->qteart[$i] + $request->qte[$i];
               
//PMP=(prix_u_article * qte_stock) + (qte_recu * prix_u_achat)/qte_stock + qte_recu
                // dd($prix_u,$pu,$pr,$pur,$pmp);
                if ($qt > 0) {

                    $dtreception = new DtReception;
                    $dtreception->reception_id = $reception->id;
                    $dtreception->article_id = $article_id;
                    $dtreception->qte_recu = $qt;
                    $dtreception->prix_u = $prix_u;
                    $dtreception->pmp =  $pur / $qteart;
                   

                    $dtreception->save();
                }
            }
        }



        return redirect('reception');
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

    public function Modification(Request $request)
    {
        $receptionId = $request->idreception;

        if ($request->article_id) {

            Reception::where('id', '=', $receptionId)->update([
                'date' => date('Y-m-d H:i:s', strtotime($request->input('date'))),
                'fournisseur_id' => $request->input('fournisseur_id'),
                'num_bl' => $request->input('num_bl'),
                'fac_num' => $request->input('fac_num'),
                'commande_id' => $request->input('idcmd'),

            ]);


            $ff = DtReception::where('reception_id', '=', $receptionId)->delete();

            //   dd($ff,$receptionId);
            for ($i = 0; $i < count($request->article_id); $i++) {
                $article_id = $request->article_id[$i];
                $prix_u = $request->prix_u[$i];
                $qt = $request->qte[$i];
                $pmp = $request->pmp[$i];
                $mntttc = $request->mntttc[$i];
                if ($qt > 0) {

                    $dtreception = new DtReception;
                    $dtreception->reception_id = $receptionId;
                    $dtreception->article_id = $article_id;
                    $dtreception->qte_recu = $qt;
                    $dtreception->prix_u = $prix_u;
                    $dtreception->pmp = $pmp;
                   

                    $dtreception->save();
                }
            }

        } else {
        }


        session()->flash('edit', 'La reception a été modifier avec succès');
        return redirect('reception');

    }

    public function AnnulationReception(Request $request)
    {
        $receptionId = $request->id;



        Reception::where('id', '=', $receptionId)->update([

            'annul' => "O",
            'date_annul' => now()->toDateTimeString(),
        ]);

        session()->flash('delete', 'La Reception a été annulée');
        return redirect('reception');


    }

//     public function indexValidationCmd()
//     {
//         $receptions = Commande::where('annul', 'N')->get();
//         $articles = Article::all();
//         $fournisseurs = Fournisseur::all();

//         return view('gestionachat.validationcmd', compact('cmds', 'fournisseurs', 'articles'));
//     }

//     public function ValidationCmd(Request $request)
//     {
//         if ($request->article_id) { 
//             // dd($request->valide_cmd);
//         if ($request->valide_cmd == 'Valide') {
//             Statut::create([
//                 'typestatut_id' => '2',
//                 'date' => now()->toDateTimeString(),
//                 'num_id' => $request->idcmd,
//                 'table_nom' => 'CMD',

//             ]);
//             session()->flash('edit', 'La commande a été validée avec succès');
//         }
//         }
//         else {
//             session()->flash('delete', 'la commande n a pas de detail');
//         }
//         if($request->valide_cmd == 'Reject') {
//             Statut::create([
//                 'typestatut_id' => '3',
//                 'date' => now()->toDateTimeString(),
//                 'num_id' => $request->idcmd,
//                 'table_nom' => 'CMD',

//             ]);
//             session()->flash('delete', 'La commande a été rejetée');
//         }
        
    
   
   
//         return redirect('validationcommande');
//     }

//     public function Print($id,Request $request)
//     {
      
        
//         $test=Commande::select('commandes.code','date','fournisseurs.nom','fournisseurs.payment')
//                  ->join('fournisseurs','fournisseurs.id','commandes.fournisseur_id')
//                  ->where('commandes.id',$id)
//                  ->get();
       
// // foreach ($test as $tes) {
// //     $fpdf = new Fpdf('P','mm','A4');
// //     $fpdf->SetFont('Arial','B',16);
// //     $fpdf->AddPage("P");
// //     $fpdf->Text(10, 10, $tes->code);
// //     // $fpdf->Cell(60,10,'Powered by FPDF.',0,1,'C');      
     
// //     $fpdf->Output();

// //     exit;
// // Instancier FPDF
//             $pdf = new Fpdf();
//             $pdf->AddPage();
//             $pdf->AliasNbPages();

//             // En-tête de page
//             $pdf->Image(public_path('\dist\img\avatar2.png'),30,3,150,20);
//             $pdf->Ln(20);
//             $pdf->SetFont('Arial','B',15);
//             $pdf->Cell(80);
//             $pdf->Cell(30,10,'Commande',0,0,'C');
//             $pdf->Ln(30);

//             // Données de la demande d'achat
//             foreach ($test as $tes) {
//                 $pdf->SetFont('Arial','',12);
//             $pdf->Cell(0,10,'Commande N '.$tes->code,0,1);
//             // Date de la demande d'achat
//             $pdf->Cell(0,10,'Date : '.$tes->date,0,1);
//             // Statut de la demande d'achat
//             $pdf->Cell(0,10,'Fournisseur : '.$tes->nom,0,1);
//             $pdf->Cell(0,10,'Mode de payement : '.utf8_decode($tes->payment),0,1);

//             // Liste des articles demandés
//             $pdf->Ln();
//             $pdf->SetFont('Arial','B',10);
//             $pdf->Cell(70,7,'Article',1,0,'C');
//             $pdf->Cell(30,7,'Quantite',1,0,'C');
//             $pdf->Cell(30,7,'Prix unitaire',1,0,'C');
//             $pdf->Cell(30,7,'Prix HT',1,0,'C');
//             $pdf->Cell(30,7,'Prix TTC',1,0,'C');
//             $pdf->Ln();
//             $pdf->SetFont('Arial','',12);
//             }
            
//             $detart=Dtcommande::where('commande_id',$id)->get();

//             $totalHT = collect($detart)->sum(function ($detart) {
//                 return $detart["mntht"] ;
//             });

//             $totalTTC = collect($detart)->sum(function ($detart) {
//                 return $detart["mntttc"] ;
//             });


            
            
//             foreach($detart as $item)
//             {
//                 $pdf->Cell(70,7,$item->article->libelle,1,0);
//                 $pdf->Cell(30,7,$item->qte,1,0,'C');
//                 $pdf->Cell(30,7,$item->prix_u,1,0,'C');
//                 $pdf->Cell(30,7,$item->mntht,1,0,'C');
//                 $pdf->Cell(30,7,$item->mntttc,1,0,'C');
//                 $pdf->Ln();
               
//             }
//             $pdf->Cell(130, 7, "Total", 1);
//             $pdf->Cell(30, 7, $totalHT . " DZD", 1);
//             $pdf->Cell(30, 7, $totalTTC . " DZD", 1);
//             $pdf->Ln();

//             $pdf->SetY(-5);

//             // Ajouter le texte "Approbation du DG"
//             // $pdf->Cell(80, 10, "Approbation du DG", 0, 0);

//             // // Déplacer la position horizontale de 10 mm
//             // $pdf->Cell(10);

//             // // Ajouter le texte "Signature demandeur"
//             // $pdf->Cell(0, 10, "Signature demandeur", 0, 1);


//             // Pied de page
//             $pdf->SetY(-15);
//             $pdf->SetFont('Arial','I',8);
//             $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');
//             // Générer le PDF
//             // $pdf->Output("D", "bon_de_commande.pdf");
//             $pdf->Output();
//     }
}
