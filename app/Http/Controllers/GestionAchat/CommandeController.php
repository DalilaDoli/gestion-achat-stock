<?php

namespace App\Http\Controllers\GestionAchat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Dtcommande;
use App\Models\Statut;
use App\Models\Dmachat;
use App\Models\dt_dmachat;
use App\Models\Typestatut;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Article;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Auth;


class CommandeController extends Controller
{
    public function index()
    {
        $cmds = Commande::where('annul', 'N')->get();
        $articles = Article::all();
        $fournisseurs = Fournisseur::all();
        $das = Dmachat::select('dmachats.id','dmachats.code','dmachats.date','dmachats.fournisseur_id','dmachats.user_id','statuts.id as statutid','statuts.num_id','statuts.table_nom','typestatuts.libelle')
                        ->leftjoin('statuts','statuts.num_id','dmachats.id')
                        ->leftjoin('typestatuts','typestatuts.id','statuts.typestatut_id')
                        ->where('annul', 'N')
                        ->where('table_nom','DA')
                        ->where('typestatut_id',2)
                        ->orderby('statuts.created_at','desc')
                        ->get();
       
        return view('gestionachat.cmd', compact('cmds', 'fournisseurs', 'articles','das'));
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

            $mat = Commande::where('code', 'LIKE', "%" . date("Y") . "%")
                ->count();

            $cmd = new Commande;
            $cmd->code = sprintf('CMD' . date("Y") . '%06d', $mat + 2);
            $cmd->date = date('Y-m-d H:i:s', strtotime($request->input('date')));
            $cmd->fournisseur_id = $request->input('fournisseur_id');
            $cmd->user_id = Auth::user()->id;
            $cmd->dmachat_id = $request->input('idda');
            $cmd->save();

            //statut
            Statut::create([
                'typestatut_id' => '1',
                'date' => date('Y-m-d H:i:s', strtotime($request->input('date'))),
                'num_id' => $cmd->id,
                'table_nom' => 'CMD',

            ]);

            //detail Da
            for ($i = 0; $i < count($request->article_id); $i++) {
                $article_id = $request->article_id[$i];
                $prix_u = $request->prix_u[$i];
                $qt = $request->qte[$i];
                $mntht = $request->mntht[$i];
                $mntttc = $request->mntttc[$i];
                if ($qt > 0) {

                    $dtcmd = new DtCommande;
                    $dtcmd->commande_id = $cmd->id;
                    $dtcmd->article_id = $article_id;
                    $dtcmd->qte = $qt;
                    $dtcmd->prix_u = $prix_u;
                    $dtcmd->mntht = $mntht;
                    $dtcmd->mntttc = $mntttc;

                    $dtcmd->save();
                }
            }
        }



        return redirect('commande');
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
        $cmdId = $request->idcmd;

        if ($request->article_id) {

            Commande::where('id', '=', $cmdId)->update([
                'date' => date('Y-m-d H:i:s', strtotime($request->input('date'))),
                'fournisseur_id' => $request->input('fournisseur_id'),
                'dmachat_id' => $request->input('idda'),

            ]);


            $ff = DtCommande::where('commande_id', '=', $cmdId)->delete();

            //   dd($ff,$cmdId);
            for ($i = 0; $i < count($request->article_id); $i++) {
                $article_id = $request->article_id[$i];
                $prix_u = $request->prix_u[$i];
                $qt = $request->qte[$i];
                $mntht = $request->mntht[$i];
                $mntttc = $request->mntttc[$i];

                //  dd($article_id,$prix_u,$qt);
                if ($qt > 0) {

                    $dtcmd = new Dtcommande;
                    $dtcmd->commande_id = $cmdId;
                    $dtcmd->article_id = $article_id;
                    $dtcmd->qte = $qt;
                    $dtcmd->prix_u = $prix_u;
                    $dtcmd->mntht = $mntht;
                    $dtcmd->mntttc = $mntttc;

                    $dtcmd->save();
                }
            }

        } else {
        }


        session()->flash('edit', 'La commande a été modifier avec succès');
        return redirect('commande');

    }

    public function AnnulationCmd(Request $request)
    {
        $cmdId = $request->id;



        Commande::where('id', '=', $cmdId)->update([

            'annul' => "O",
            'date_annul' => now()->toDateTimeString(),
        ]);

        session()->flash('delete', 'La Commande a été annulée');
        return redirect('commande');


    }

    public function indexValidationCmd()
    {
        $cmds = Commande::where('annul', 'N')->get();
        $articles = Article::all();
        $fournisseurs = Fournisseur::all();

        return view('gestionachat.validationcmd', compact('cmds', 'fournisseurs', 'articles'));
    }

    public function ValidationCmd(Request $request)
    {
        if ($request->article_id) { 
            // dd($request->valide_cmd);
        if ($request->valide_cmd == 'Valide') {
            Statut::create([
                'typestatut_id' => '2',
                'date' => now()->toDateTimeString(),
                'num_id' => $request->idcmd,
                'table_nom' => 'CMD',

            ]);
            session()->flash('edit', 'La commande a été validée avec succès');
        }
        }
        else {
            session()->flash('delete', 'la commande n a pas de detail');
        }
        if($request->valide_cmd == 'Reject') {
            Statut::create([
                'typestatut_id' => '3',
                'date' => now()->toDateTimeString(),
                'num_id' => $request->idcmd,
                'table_nom' => 'CMD',

            ]);
            session()->flash('delete', 'La commande a été rejetée');
        }
        
    
   
   
        return redirect('validationcommande');
    }

    public function Print($id,Request $request)
    {
      
        
        $test=Commande::select('commandes.code','date','fournisseurs.nom','fournisseurs.payment')
                 ->join('fournisseurs','fournisseurs.id','commandes.fournisseur_id')
                 ->where('commandes.id',$id)
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
            $pdf->Cell(30,10,'Commande',0,0,'C');
            $pdf->Ln(30);

            // Données de la demande d'achat
            foreach ($test as $tes) {
                $pdf->SetFont('Arial','',12);
            $pdf->Cell(0,10,'Commande N '.$tes->code,0,1);
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
            
            $detart=Dtcommande::where('commande_id',$id)->get();

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

            $pdf->SetY(-5);

            // Ajouter le texte "Approbation du DG"
            // $pdf->Cell(80, 10, "Approbation du DG", 0, 0);

            // // Déplacer la position horizontale de 10 mm
            // $pdf->Cell(10);

            // // Ajouter le texte "Signature demandeur"
            // $pdf->Cell(0, 10, "Signature demandeur", 0, 1);


            // Pied de page
            $pdf->SetY(-15);
            $pdf->SetFont('Arial','I',8);
            $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');
            // Générer le PDF
            // $pdf->Output("D", "bon_de_commande.pdf");
            $pdf->Output();
    }
       
}
