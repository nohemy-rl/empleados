<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Laracasts\Flash\Flash;
use JsValidator;
use File;

class EmpresaController extends Controller
{
    protected $validationRules;
    protected $attributeNames;
    protected $errorMessages;
    protected $model;

    public function __construct(Empresa $model)
    {
     $this->validationRules = [
            'empresa'=>'required',
       ];
       $this->attributeNames = [
           'empresa'=>'empresa',
       ];
       $this->errorMessages = [
           'required' => 'El campo :attribute es requerido',
       ];
      $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $empresas = $this->setQuery($request)->get();
        return view('empresas.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresa = new Empresa();
        $validator = JsValidator::make($this->validationRules, $this->errorMessages, $this->attributeNames, '#form');
        return view('empresas.form', compact('empresa', 'validator'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->setValidator($request)->validate();
        if ($this->setUnique($request)>0){
            $this->setMessage('Empresa duplicada');
        }else{
            $request = $this->normalizaDatos($request);
            Empresa::create($request->all());
            $this->setMessage('Empresa registrada exitosamente');
        }
        return redirect('/empresa');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        $validator = JsValidator::make($this->validationRules, $this->errorMessages, $this->attributeNames, '#form');
        return view('empresas.form', compact('empresa', 'validator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresa $empresa)
    {
        $this->setValidator($request,$empresa->id)->validate();
        $request = $this->normalizaDatos($request,$empresa->id);
        $empresa->update($request->all());
        $this->setMessage('empresa modificada exitosamente');
        return redirect('/empresa');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        $this->setMessage('empresa eliminada exitosamente');
        return redirect('/empresa');
    }

    private function normalizaDatos(Request $request, $id=0)
    {
        if($id == 0){
            $request['usuario_creacion_id'] = auth()->user()->id;
        }else{
            $request['usuario_actualizacion_id'] = auth()->user()->id;
        }
        
        return $request;
    }
    
    protected function setValidator(Request $request, $id=0)
    {
        return Validator::make($request->all(), $this->validationRules, $this->errorMessages)->setAttributeNames($this->attributeNames);
    }

    private function setUnique(Request $request){
        return Empresa::where('empresa',$request['empresa'])->count();
    }

    //retorno de mensajes en el proyecto
    private function setMessage($mensaje)
    {
        return  flash($mensaje)->success()->important();
    }

    private function setQuery($request)
    {
        $query = $this->model;
        if ($request->filled('empresa')) {
            $query = $query->where('empresa', 'LIKE', '%' . $request->input('empresa') . '%');
       }
        return $query;
    }
}
