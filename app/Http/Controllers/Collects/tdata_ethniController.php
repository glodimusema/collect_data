<?php

namespace App\Http\Controllers\Collects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Collects\{tdata_ethni};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tdata_ethniController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $query)
    {
        $data = DB::table('tdata_ethni')
        ->select("tdata_ethni.id",'nom_ethni','code_ethni',
        "tdata_ethni.created_at");

        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);

            $data->where('tdata_ethni.nom_ethni', 'like', '%'.$query.'%')
            ->orderBy("tdata_ethni.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
        
    }


    function fetch_dropdown_2()
    {
        $data = DB::table('tdata_ethni')
        ->select("tdata_ethni.id","tdata_ethni.nom_ethni",'code_ethni',
        "tdata_ethni.created_at")
        ->orderBy("nom_ethni", "asc")->get();
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
 
            $data = tdata_ethni::where("id", $query->id)->update([
                'nom_ethni' =>  $query->nom_ethni,
                'code_ethni' =>  $query->code_ethni
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tdata_ethni::create([

                'nom_ethni' =>$query->nom_ethni,
                'code_ethni' =>  $query->code_ethni
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
        $data = tdata_ethni::where('id', $id)->get();
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
        $data = tdata_ethni::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
