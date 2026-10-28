<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Alumno;
use App\Models\Modulo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class MatriculaController extends Controller
{   
    private const Messages = [
            'alumno_id.required' => 'El alumno es obligatorio',
            'alumno_id.numeric' => 'El alumno no se ha selecionado bien ',
            'alumno.exists' => 'El alumno no existe ',
            'modulo_id.required' => 'El modulo es obligatorio',
            'modulo_id.numeric' => 'El modulo no se ha selecionado bien',
            'modulo.exists' => 'El modulo no existe ',




        ];
    
    private const RULES = [
            'alumno_id' => 'required|numeric|exists:alumno.id',
            'modulo_id' => 'required|numeric|exists:modulo.id',
        ];


    private function getCurso(): Int{
        if(Carbon::now()->month >=9){
            return Carbon::now()->year;
        }else{
            return Carbon::now()->year -1;
        }
    }
    private function getCursoEscolar(): string
{
    return $this->getCurso() . '/' . ($this->getCurso() + 1);
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
public function create(): View
{
    return view('matricula.create', [
        'alumnos' => Alumno::orderBy('apellido')->orderBy('nombre')->get(),
        'curso_escolar' => $this->getCursoEscolar(), // Cambia 'curso escolar' por 'curso_escolar'
        'modulos' => Modulo::pluck('nombre', 'id'),
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), self::RULES, self::Messages);

        if($validator->fails()){
             return back()->withInput()->withErrors($validator);
        }
        $matricula = new Matricula($request->all());
        $matricula->curso = $this->getCurso();
        try{
        $matricula->save();
        return redirect()->route('matricula.index')->with(['success' => 'Se ha creado la matricula']);
        } catch(UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors([
                'error' => 'Error al matricula.',
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Matricula $matricula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matricula $matricula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matricula $matricula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matricula $matricula)
    {
        //
    }
}