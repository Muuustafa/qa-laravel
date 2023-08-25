<?php
namespace App\Http\Controllers;

use App\Http\Requests\CollectiveRequest;
use App\Models\Categorie;
use App\Models\Collective;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CollectiveController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth', 'verified'])->except('show');
    }

    public function index()
    {
        $categories = Categorie::all();
        $collectives = Collective::where('user_id', auth()->user()->id)
            ->latest()->paginate(10);

        return view('collectives.index')->with([
            'collectives' => $collectives,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = Categorie::all();

        return view('collectives.create')->with([
            'categories' => $categories
        ]);
    }


    public function store(CollectiveRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $data['slug'] = Str::slug($request->titre);
        Collective::create($data);

        return response()->json([
			'status' => 200,
		]);

    }

    public function show(Collective $collective)
    {
        return view('collectives.show')->with([
            'collective' => $collective
        ]);
    }

    public function fetchAll()
    {
        $collectives = Collective::all();

        //return response()->json($collectives);
        return view('collectives.index')->with([
            'collectives' => $collectives
        ]);
    }
    public function edit($id) {
		$collective = Collective::find($id);
        
		return response()->json($collective);
	}

    public function update(Request $request)
    {
        $collective = Collective::find($request->id);
        
        if ($collective->owner($collective->user_id)) {
            $this->validate($request, [
                'titre' => 'required|unique:collectives,id,' . $collective->id,
                'description' => 'required',
                'category_id' => 'required|numeric'
            ]);
        
              $data = [
                'user_id' => auth()->user()->id,
                'slug' => Str::slug($request->titre),
                'titre' => $request->titre, 
                'description' => $request->description
            ];
            $collective->update($data);
            
            return response()->json([
                'status' => 200,
            ]);
        }

        abort(403);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
		Collective::find($id);
		Collective::destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Collective supprimé avec succès...'
        ], 200);
		
    }
    
}























?>