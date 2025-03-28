<?php

namespace App\Http\Controllers\Collects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Collects\{tdata_genre};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tdata_genreController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $query)
    {
        $data = DB::table('tdata_genre')
        ->select("tdata_genre.id",'nom_genre','code_genre',
        "tdata_genre.created_at");

        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);

            $data->where('tdata_genre.nom_genre', 'like', '%'.$query.'%')
            ->orderBy("tdata_genre.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
        
    }


    function fetch_dropdown_2()
    {
        $data = DB::table('tdata_genre')
        ->select("tdata_genre.id","tdata_genre.nom_genre",'code_genre',
        "tdata_genre.created_at")
        ->orderBy("nom_genre", "asc")->get();
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
 
            $data = tdata_genre::where("id", $query->id)->update([
                'nom_genre' =>  $query->nom_genre,
                'code_genre' =>  $query->code_genre
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tdata_genre::create([

                'nom_genre' =>$query->nom_genre,
                'code_genre' =>  $query->code_genre
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
        $data = tdata_genre::where('id', $id)->get();
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
        $data = tdata_genre::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
