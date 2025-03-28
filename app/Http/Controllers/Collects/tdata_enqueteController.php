<?php

namespace App\Http\Controllers\Collects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Collects\{tdata_enquete};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tdata_enqueteController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $query)
    {
        //'id','id_violation','id_ethni','id_genre','id_auteur','refAgent','author','refUser'
        $data = DB::table('tdata_enquete')
        ->join('tdata_violation','tdata_violation.id','=','tdata_enquete.id_violation')
        ->join('tdata_ethni','tdata_ethni.id','=','tdata_enquete.id_ethni')
        ->join('tdata_genre','tdata_genre.id','=','tdata_enquete.id_genre')
        ->join('tdata_auteur','tdata_auteur.id','=','tdata_enquete.id_auteur')
        ->join('tagent' , 'tagent.id','=','tdata_enquete.refAgent')
        ->select("tdata_enquete.id",'id_violation','id_ethni','id_genre',
        'id_auteur','refAgent','tdata_enquete.author','tdata_enquete.refUser',
        "tdata_enquete.created_at",'nom_auteur','code_auteur','nom_violation','code_violation',
        'nom_ethni','code_ethni','nom_genre','code_genre'
        ,'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes',
        'envie','refCompte','codeSecret');

        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);

            $data->where('noms_agent', 'like', '%'.$query.'%')
            ->orderBy("tdata_enquete.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
        
    }


    function fetch_dropdown_2()
    {
        $data = DB::table('tdata_enquete')
        ->join('tdata_violation','tdata_violation.id','=','tdata_enquete.id_violation')
        ->join('tdata_ethni','tdata_ethni.id','=','tdata_enquete.id_ethni')
        ->join('tdata_genre','tdata_genre.id','=','tdata_enquete.id_genre')
        ->join('tdata_auteur','tdata_auteur.id','=','tdata_enquete.id_auteur')
        ->join('tagent' , 'tagent.id','=','tdata_enquete.refAgent')
        ->select("tdata_enquete.id",'id_violation','id_ethni','id_genre',
        'id_auteur','refAgent','tdata_enquete.author','tdata_enquete.refUser',
        "tdata_enquete.created_at",'nom_auteur','code_auteur','nom_violation','code_violation',
        'nom_ethni','code_ethni','nom_genre','code_genre'
        ,'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes',
        'envie','refCompte','codeSecret')
        ->orderBy("tdata_enquete.id", "asc")->get();
        return response()->json([
            'data'  => $data
        ]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $query
     * @return \Illuminate\Http\Response
     */
    public function store(Request $query)
    {
        
        if ($query->id !='') 
        {
            //'id','id_violation','id_ethni','id_genre','id_auteur','refAgent','author','refUser'
            $data = tdata_enquete::where("id", $query->id)->update([
                'id_violation' =>  $query->id_violation,
                'id_ethni' =>  $query->id_ethni,
                'id_genre' =>  $query->id_genre,
                'id_auteur' =>  $query->id_auteur,
                'refAgent' =>  $query->refAgent,
                'author' =>  $query->author,
                'refUser' =>  $query->refUser
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tdata_enquete::create([
               'id_violation' =>  $query->id_violation,
                'id_ethni' =>  $query->id_ethni,
                'id_genre' =>  $query->id_genre,
                'id_auteur' =>  $query->id_auteur,
                'refAgent' =>  $query->refAgent,
                'author' =>  $query->author,
                'refUser' =>  $query->refUser
            ]);

            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);
        }
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
        $data = tdata_enquete::where('id', $id)->get();
        return response()->json(['data' => $data]);
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
        $data = tdata_enquete::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
