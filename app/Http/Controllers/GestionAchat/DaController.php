<?php

namespace App\Http\Controllers\GestionAchat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dmachat;
use App\Models\DtDmachat;
use App\Models\Statut;
use App\Models\Typestatut;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Article;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Auth;

class DaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $das = Dmachat::where('annul', 'N')->get();
        $articles = Article::all();
        $fournisseurs = Fournisseur::all();

        return view('gestionachat.da', compact('das', 'fournisseurs', 'articles'));
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

            $mat = Dmachat::where('code', 'LIKE', "%" . date("Y") . "%")
                ->count();

            $demande = new Dmachat;
            $demande->code = sprintf('DA' . date("Y") . '%06d', $mat + 2);
            $demande->date = date('Y-m-d H:i:s', strtotime($request->input('date')));
            $demande->fournisseur_id = $request->input('fournisseur_id');
            $demande->user_id = Auth::user()->id;
            $demande->save();

            //statut
            Statut::create([
                'typestatut_id' => '1',
                'date' => date('Y-m-d H:i:s', strtotime($request->input('date'))),
                'num_id' => $demande->id,
                'table_nom' => 'DA',

            ]);

            //detail Da
            for ($i = 0; $i < count($request->article_id); $i++) {
                $article_id = $request->article_id[$i];
                $prix_u = $request->prix_u[$i];
                $qt = $request->qte[$i];
                $mntht = $request->mntht[$i];
                $mntttc = $request->mntttc[$i];
                if ($qt > 0) {

                    $dtdmachat = new DtDmachat;
                    $dtdmachat->dmachat_id = $demande->id;
                    $dtdmachat->article_id = $article_id;
                    $dtdmachat->qte = $qt;
                    $dtdmachat->prix_u = $prix_u;
                    $dtdmachat->mntht = $mntht;
                    $dtdmachat->mntttc = $mntttc;

                    $dtdmachat->save();
                }
            }
        }



        return redirect('da');
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
        $daId = $request->idda;

        if ($request->article_id) {

            Dmachat::where('id', '=', $daId)->update([
                'date' => date('Y-m-d H:i:s', strtotime($request->input('date'))),
                'fournisseur_id' => $request->input('fournisseur_id'),

            ]);


            $ff = DtDmachat::where('dmachat_id', '=', $daId)->delete();

            //   dd($ff,$daId);
            for ($i = 0; $i < count($request->article_id); $i++) {
                $article_id = $request->article_id[$i];
                $prix_u = $request->prix_u[$i];
                $qt = $request->qte[$i];
                $mntht = $request->mntht[$i];
                $mntttc = $request->mntttc[$i];

                //  dd($article_id,$prix_u,$qt);
                if ($qt > 0) {

                    $dtdmachat = new DtDmachat;
                    $dtdmachat->dmachat_id = $daId;
                    $dtdmachat->article_id = $article_id;
                    $dtdmachat->qte = $qt;
                    $dtdmachat->prix_u = $prix_u;
                    $dtdmachat->mntht = $mntht;
                    $dtdmachat->mntttc = $mntttc;


                    $dtdmachat->save();
                }
            }

        } else {
        }


        session()->flash('edit', 'La demande d\'achat a été modifier avec succès');
        return redirect('/da');

    }

    public function AnnulationDa(Request $request)
    {
        $daId = $request->id;



        Dmachat::where('id', '=', $daId)->update([

            'annul' => "O",
            'date_annul' => now()->toDateTimeString(),
        ]);

        session()->flash('delete', 'La demande d\'achat a été annulée');
        return redirect('da');

    }

    public function indexValidationDa()
    {
        $das = Dmachat::where('annul', 'N')->get();
        $articles = Article::all();
        $fournisseurs = Fournisseur::all();

        return view('gestionachat.validationda', compact('das', 'fournisseurs', 'articles'));
    }

    public function ValidationDa(Request $request)
    {
        if ($request->article_id) { 
        if ($request->valide_da == 'Valide') {
            Statut::create([
                'typestatut_id' => '2',
                'date' => now()->toDateTimeString(),
                'num_id' => $request->idda,
                'table_nom' => 'DA',

            ]);
            session()->flash('edit', 'La demande d\'achat a été validée avec succès');
        }
        }
        else {
            session()->flash('delete', 'la demande d\'achat n a pas de detail');
        }
        if($request->valide_da == 'Reject') {
            Statut::create([
                'typestatut_id' => '3',
                'date' => now()->toDateTimeString(),
                'num_id' => $request->idda,
                'table_nom' => 'DA',

            ]);
            session()->flash('delete', 'La demande d\'achat a été rejetée');
        }
        
    
   
   
        return redirect('validationachat');
    }

    public function Print($id,Request $request)
    {
      
        
        $test=Dmachat::select('dmachats.code','date','fournisseurs.nom','fournisseurs.payment')
                 ->join('fournisseurs','fournisseurs.id','dmachats.fournisseur_id')
                 ->where('dmachats.id',$id)
                 ->get();
       
// foreach ($test as $tes) {
//     $fpdf = new Fpdf('P','mm','A4');
//     $fpdf->SetFont('Arial','B',16);
//     $fpdf->AddPage("P");
//     $fpdf->Text(10, 10, $tes->code);
//     // $fpdf->Cell(60,10,'Powered by FPDF.',0,1,'C');      
     
//     $fpdf->Output();

//     exit;
// Instancier FPDF

            $pdf = new Fpdf();
            $pdf->AddPage();
            $pdf->AliasNbPages();

            // En-tête de page
            $pdf->Image(public_path('\dist\img\ENTETE.png'),30,3,150,20);
            $pdf->Ln(20);
            $pdf->SetFont('Arial','B',15);
            $pdf->Cell(80);
            $pdf->Cell(30,10,'Demande d\'achat',0,0,'C');
            $pdf->Ln(30);

            // Données de la demande d'achat
            foreach ($test as $tes) {
                $pdf->SetFont('Arial','',12);
            $pdf->Cell(0,10,'Demande d\'achat N '.$tes->code,0,1);
            // Date de la demande d'achat
            $pdf->Cell(0,10,'Date : '.$tes->date,0,1);
            // Statut de la demande d'achat
            $pdf->Cell(0,10,'Fournisseur : '.$tes->nom,0,1);
            $pdf->Cell(0,10,'Mode de payement : '.utf8_decode($tes->payment),0,1);

            // Liste des articles demandés
            $pdf->Ln();
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(70,7,'Article',1,0,'C');
            $pdf->Cell(30,7,'Quantite',1,0,'C');
            $pdf->Cell(30,7,'Prix unitaire',1,0,'C');
            $pdf->Cell(30,7,'Prix HT',1,0,'C');
            $pdf->Cell(30,7,'Prix TTC',1,0,'C');
            $pdf->Ln();
            $pdf->SetFont('Arial','',12);
            }
            
            $detart=DtDmachat::where('dmachat_id',$id)->get();

            // dd($detart);
            
            $totalHT = collect($detart)->sum(function ($detart) {
                return $detart["mntht"] ;
            });

            $totalTTC = collect($detart)->sum(function ($detart) {
                return $detart["mntttc"] ;
            });


            
            
            foreach($detart as $item)
            {
                $pdf->Cell(70,7,$item->article->libelle,1,0);
                $pdf->Cell(30,7,$item->qte,1,0,'C');
                $pdf->Cell(30,7,$item->prix_u,1,0,'C');
                $pdf->Cell(30,7,$item->mntht,1,0,'C');
                $pdf->Cell(30,7,$item->mntttc,1,0,'C');
                $pdf->Ln();
               
            }
            $pdf->Cell(130, 7, "Total", 1);
            $pdf->Cell(30, 7, $totalHT . " DZD", 1);
            $pdf->Cell(30, 7, $totalTTC . " DZD", 1);
            $pdf->Ln();
            // Pied de page
            $pdf->SetY(-15);
            $pdf->SetFont('Arial','I',8);
            $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');
            // Générer le PDF
            // $pdf->Output("D", "bon_demande_achat.pdf");
            $pdf->Output();
    }
       
    

}