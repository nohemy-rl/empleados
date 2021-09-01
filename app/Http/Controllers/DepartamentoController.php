<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Laracasts\Flash\Flash;
use JsValidator;
use File;

class DepartamentoController extends Controller
{
    protected $validationRules;
    protected $attributeNames;
    protected $errorMessages;
    protected $model;

    public function __construct(Departamento $model)
    {
     $this->validationRules = [
        'empresa_id'=>'required',
        'departamento'=>'required',
       ];
       $this->attributeNames = [
        'empresa_id'=>'empresa',
        'departamento'=>'departamento',
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
        $departamentos = $this->setQuery($request)->get();
        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamento = new Departamento();
        $empresas=Empresa::all()->pluck('empresa', 'id')->prepend('-Selecciona-', '');
        $validator = JsValidator::make($this->validationRules, $this->errorMessages, $this->attributeNames, '#form');
        return view('departamentos.form', compact('departamento','empresas', 'validator'));
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
            $this->setMessage('Departamento duplicado');
        }else{
            $request = $this->normalizaDatos($request);
            Departamento::create($request->all());
            $this->setMessage('Departamento registrado exitosamente');
        }
        return redirect('/departamento');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function show(Departamento $departamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Departamento $departamento)
    {
        $empresas=Empresa::all()->pluck('empresa', 'id')->prepend('-Selecciona-', '');
        $validator = JsValidator::make($this->validationRules, $this->errorMessages, $this->attributeNames, '#form');
        return view('departamentos.form', compact('departamento','empresas', 'validator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departamento $departamento)
    {
        $this->setValidator($request,$departamento->id)->validate();
        $request = $this->normalizaDatos($request,$departamento->id);
        $departamento->update($request->all());
        $this->setMessage('departamento modificado exitosamente');
        return redirect('/departamento');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departamento $departamento)
    {
        $departamento->delete();
        $this->setMessage('departamento eliminado exitosamente');
        return redirect('/departamento');
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
        return Departamento::where([
                    'departamento'=>$request['departamento'],
                    'empresa_id'=>$request->empresa_id
                    ])->count();
    }

    //retorno de mensajes en el proyecto
    private function setMessage($mensaje)
    {
        return  flash($mensaje)->success()->important();
    }

    private function setQuery($request)
    {
        $query = $this->model;
        if ($request->filled('departamento')) {
            $query = $query->where('departamento', 'LIKE', '%' . $request->input('departamento') . '%');
       }
        return $query;
    }
}
