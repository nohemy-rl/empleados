<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Departamento;
use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Laracasts\Flash\Flash;
use JsValidator;
use File;

class EmpleadoController extends Controller
{
    protected $validationRules;
    protected $attributeNames;
    protected $errorMessages;
    protected $model;

    public function __construct(Empleado $model)
    {
     $this->validationRules = [
        'empresa_id'=>'required',
        'departamento_id'=>'required',
        'nombre'=>'required',
        'paterno'=>'required',
        'materno'=>'required',
        'correo_electronico'=>'required',
        'fecha_ingreso'=>'required',
        'fecha_nacimiento'=>'required',
       ];
       $this->attributeNames = [
        'empresa_id'=>'empresa',
        'departamento_id'=>'departamento',
        'nombre'=>'nombre',
        'paterno'=>'paterno',
        'materno'=>'materno',
        'correo_electronico'=>'correo electronico',
        'fecha_ingreso'=>'fecha ingreso',
        'fecha_nacimiento'=>'fecha nacimiento',
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
        $empresas=Empresa::all()->pluck('empresa', 'id')->prepend('-Selecciona-', '');       
        $empleado = new Empleado();
        $empleados = $this->setQuery($request)->get();
        return view('empleados.index', compact('empleados','empresas','empleado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleado = new Empleado();
        $empresas=Empresa::all()->pluck('empresa', 'id')->prepend('-Selecciona-', '');
        $validator = JsValidator::make($this->validationRules, $this->errorMessages, $this->attributeNames, '#form');
        return view('empleados.form', compact('empleado','empresas', 'validator'));
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
            $this->setMessage('Empleado duplicado');
        }else{
            $request = $this->normalizaDatos($request);
            Empleado::create($request->all());
            $this->setMessage('Empleado registrado exitosamente');
        }
        return redirect('/empleado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        return view('empleados.ficha', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        $empresas=Empresa::all()->pluck('empresa', 'id')->prepend('-Selecciona-', '');       
        $validator = JsValidator::make($this->validationRules, $this->errorMessages, $this->attributeNames, '#form');
        return view('empleados.form', compact('empleado','empresas', 'validator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        $this->setValidator($request,$empleado->id)->validate();
        $request = $this->normalizaDatos($request,$empleado->id);
        $empleado->update($request->all());
        $this->setMessage('empleado modificado exitosamente');
        return redirect('/empleado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        $this->setMessage('empleado eliminado exitosamente');
        return redirect('/empleado');
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
        return Empleado::where([
            'nombre'=>$request['nombre'],
            'paterno'=>$request['paterno'],
            'materno'=>$request['materno'],
            'fecha_nacimiento'=>$request['fecha_nacimiento'],
            'correo_electronico'=>$request['correo_electronico'],                    
            'departamento_id'=>$request['departamento_id'],
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

        $cliente_id=($request->filled('cliente_id')) ? $request->cliente_id : 0;

        if ($request->filled('empleado')) {
            $query = $query->where('nombre', 'LIKE', '%' . $request->input('empleado') . '%')
                ->orWhere('paterno', 'LIKE', '%' . $request->input('empleado') . '%')
                ->orWhere('materno', 'LIKE', '%' . $request->input('empleado') . '%')
            ;
        }
        if ($request->filled('empresa_id')) {
            $query = $query->where('empresa_id', $request->input('empresa_id'));
        }
        if ($request->filled('departamento_id')) {
            $query = $query->where('departamento_id', $request->input('departamento_id'));
        }
        return $query;
    }
}
