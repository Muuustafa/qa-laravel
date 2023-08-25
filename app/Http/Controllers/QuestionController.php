<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Collective;
use App\Models\Commentaire;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth', 'verified'])->except('show','voteUp','voteDown','getQuestionComments');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collectives = Collective::all();
        $categories = Categorie::all();
        $questions = Question::where('user_id', auth()->user()->id)
            ->latest()->paginate(10);

        return view('questions.index')->with([
            'questions' => $questions,
            'collectives' => $collectives,
            'categories' => $categories
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Categorie::all();
        $collectives = Collective::all();

        return view('questions.create')->with([
            'collectives' => $collectives,
            'categories' => $categories
        ]);
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
        $this->validate($request,[
            'titre' => 'required|unique:questions',
            'body' => 'required',
            'category_id' => 'required|numeric'
        ]);
        
        $data = $request -> except('_token');
        $data['user_id'] =auth()->user()->id;
        $data['slug'] = Str::slug($request->titre);
        Question::create($data);
        
        return response()->json([
            'status' => 200,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
        return view('questions.show')->with([
            'questions' => $question
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        
        return response()->json($question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $question = Question::find($request->id);
        if($question ->owner($question->user_id)){
            $this->validate($request,[
                'titre' => 'required|min:10|unique:questions,id,'.$question->id,
                'body' => 'required|min:10',
                'category_id' => 'required|numeric'
            ]);

            //$data = $request -> except('_token','_method');
            $data = [
                'user_id' => auth()->user()->id,
                'slug' => Str::slug($request->titre),
                //'body' => $request->body,
                //'category_id' => $request->category_id,
                //'collective_id' => $request->collective_id
            ];

            $question->update($data);
            
            return response()->json([
                'status' => 200,
            ]);
        
        
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $id = $request->id;
        Question::find($id);
        Question::destroy($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Question supprimé avec succès...'
            ], 200); 
    
    }

    public function voteUp($id){
        $question = Question::find($id);
        $question-> increment('votes');
    }

    public function voteDown($id){
        $question = Question::find($id);
        $question-> decrement('votes');
    }

    public function getQuestionComments($id){

        $comments = Commentaire::where('question_id',$id)->with('user')->latest()->get();
        return response()->json($comments);
    }

    public function validateQuestion($id) {
        $question = Question::find($id);
    
        if ($question) {
            $question->update(['validation' => true]); // Marquer la question comme validée
            return response()->json(['success' => true, 'message' => 'Question validée avec succès']);
        } else {
            return response()->json(['success' => false, 'message' => 'Question non trouvée'], 404);
        }
    }

}
