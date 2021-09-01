<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use JsValidator;

class UsuarioController extends Controller
{
    protected $validationRules;
    protected $attributeNames;
    protected $errorMessages;
    protected $model;

    public function __construct(User $model)
    {
        $this->validationRules = [
            'name' => 'required|string|between:5,190',
            'email' => 'required|email|max:100|string',
            'password' => 'sometimes|nullable|confirmed|between:5,50|string',
            'password_confirmation'=> 'sometimes|nullable|between:5,50|string',
        ];
       $this->attributeNames = [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'password_confirmation'=> 'repetir contraseña',
       ];
       $this->errorMessages = [
           'required' => 'El campo :attribute es obligatorio.',
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
        $usuarios = $this->setQuery($request)->get();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuario = new User();
        $validator = JsValidator::make($this->validationRules, $this->errorMessages, $this->attributeNames, '#form');
        return view('usuarios.form', compact('usuario', 'validator'));
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
        $request = $this->normalizaDatos($request);
        $usuario = User::create($request->all());     
        flash('El registro ha sido agregado')->important();
        return redirect('/usuario');
    }

    public function setpassword(User $usuario)
    {
        $validator = JsValidator::make([
            'password' => 'required|confirmed|min:9|max:50|string',
            'password_confirmation'=> 'required|min:9|max:50|string',
        ], $this->errorMessages, $this->attributeNames, '#form');
        return view('usuarios.setpassword', compact('usuario', 'validator'));
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
    public function edit($usuario)
    {
        $validator = JsValidator::make($this->validationRules, $this->errorMessages, $this->attributeNames, '#form');
        return view('usuarios.form', compact('usuario', 'validator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $usuario)
    {
        $this->setValidator($request)->validate();
        $request = $this->normalizaDatos($request);
        $usuario->update($request->all());
        
        flash('El registro ha sido actualizado')->important();
        if(isset($request->_setpassword) and $request->_setpassword == '1') {
            return redirect('/login');
        }
        
        return redirect('/usuario');
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

    private function normalizaDatos(Request $request,$id=0)
    {

        if(isset($request->password) && !empty($request->password)){
            $request['password'] = bcrypt($request->password);
        }

        

        return $request;
    }

    protected function setValidator(Request $request, $id=0)
    {
        if($id != 0){
            $this->validationRules = array_merge($this->validationRules, [
                'email' => 'required|email|unique:users,email,'.$id.',id|string|max:100'
            ]);
        }
        
        if($id == 0){
            $this->validationRules = array_merge($this->validationRules, [
                'email' => 'required|email|unique:users,email|string|max:100'
            ]);
        }
        if(isset($request->_setpassword) and $request->_setpassword == '1'){
            $this->validationRules = [
                'password' => 'required|confirmed|min:5|max:50|string',
                'password_confirmation'=> 'required|min:5|max:50|string',
            ];
        }


        return Validator::make($request->all(), $this->validationRules, $this->errorMessages)->setAttributeNames($this->attributeNames);
    }

    private function setQuery($request)
    {
       
        $query = $this->model;

        if ($request->filled('name')) {
             $query = $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }
       if($request->filled('email')) {
            $query = $query->where('email', 'LIKE', '%' . $request->input('email') . '%');
        }
        
        return $query;
    }
}
