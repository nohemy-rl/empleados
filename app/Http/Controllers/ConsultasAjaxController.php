<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Departamento;
use Illuminate\Http\Request;

class ConsultasAjaxController extends Controller
{
    public function getdepartamentobyempresa($empresa_id)
    {
        $departamentoEmpresa = Departamento::select('id','departamento')
                    ->where('empresa_id', '=', $empresa_id)
                    ->get();
        return response()->json($departamentoEmpresa);  
    }
}
