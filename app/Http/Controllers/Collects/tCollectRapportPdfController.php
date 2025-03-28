<?php
namespace App\Http\Controllers\Collects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tCollectRapportPdfController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

function pdf_detail_enquete_excel(Request $request)
{
   if ($request->get('date1') && $request->get('date2')) {
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $data_return = []; // Initialisation du tableau pour stocker les résultats

        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data = DB::table('tdata_enquete')
        ->join('tdata_violation','tdata_violation.id','=','tdata_enquete.id_violation')
        ->join('tdata_ethni','tdata_ethni.id','=','tdata_enquete.id_ethni')
        ->join('tdata_genre','tdata_genre.id','=','tdata_enquete.id_genre')
        ->join('tdata_auteur','tdata_auteur.id','=','tdata_enquete.id_auteur')
        ->join('tagent' , 'tagent.id','=','tdata_enquete.refAgent')
        ->select("tdata_enquete.id",'id_violation','id_ethni','id_genre',
        'id_auteur','refAgent','tdata_enquete.author','tdata_enquete.refUser',
        'nom_auteur','code_auteur','nom_violation','code_violation',
        'nom_ethni','code_ethni','nom_genre','code_genre'
        ,'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes',
        'envie','refCompte','codeSecret')
        ->selectRaw("DATE_FORMAT(tdata_enquete.created_at,'%d/%M/%Y') as created_at")
        ->where([
            ['tdata_enquete.created_at','>=', $date1],
            ['tdata_enquete.created_at','<=', $date2]
        ])
        ->orderBy("tdata_enquete.created_at", "asc")
        ->get();   

    // Vérifiez que les deux tableaux ont la même longueur
    if ($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $row1 = $data[$i];

            $data_return[] = [
                'N°.' => $row1->id,
                'GENRE' => $row1->nom_genre,
                'CODEGENRE' => $row1->code_genre,
                'VIOLATION' => $row1->nom_violation,                
                'CODEVIOLATION' => $row1->code_violation,
                'ETHNI' =>$row1->nom_ethni,
                'CODEETHNI' => $row1->code_ethni,
                'AUTEUR' => $row1->nom_auteur,
                'CODEAUTEUR' => $row1->code_auteur,
                'ENQUETEUR' => $row1->noms_agent,
                'DATE' => $row1->created_at                
            ];

        }
    } 
    else {
        // Gérer le cas où les tableaux n'ont pas la même longueur
        echo 'Les tableaux ont pas la même longueur.';
    }

     return response()->json($data_return);

    }

    return response()->json(['error' => 'Invalid parameters'], 400);
}
   


    
    

    
}
