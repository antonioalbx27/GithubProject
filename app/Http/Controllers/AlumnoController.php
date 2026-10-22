<?php

namespace App\Http\Controllers;
use Illuminate\Database\UniqueConstraintViolationException;
use App\Models\Alumno;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AlumnoController extends Controller
{
    private const RULES = [
            'nombre' => 'required|string|max:100|min:2',
            'apellido' => 'required|string|max:130|min:100',
            'fnac' => 'nullable|date|before_or_equal:today',
            'genero' => 'nullable|in:masculino,femenino,otro',
            'notaacceso'=> 'nullable|numeric|gte:0|lte:10|decimal:2',
        ];

    public function create(): View
    {
        //
        return view('alumno.create', []);
    }

    public function destroy(Alumno $alumno): RedirectResponse
    {   
        try{
            $alumno->delete();
        } catch(\Exception $e){
            return back()->withErrors([
                'error' => 'No se ha podido borrar el alumno.',
                //'nombre' => 'Este campo forma parte de la clave unica',
                //'apellido' => 'Este campo forma parte de la clave unica'
            ]);
        }
        return redirect()->route('alumno.index')->with(['success' => 'Se ha borradp el alumno']);

    }

    public function edit(Alumno $alumno): View
    {
        //
        return view('alumno.edit', ['alumno'=>$alumno]);
    }

     private static function getMessages():array {
          return [
            'nombre.required' => '',
            'nombre.string' => '',
            'nombre.max' => '',
            'nombre.min' => '',
            'apellido.required' => '',
            'apellido.string' => '',
            'apellido.max' => '',
            'apellido.min' => '',
            'fnac.date' => '',
            'fnac.before_or_equal' => '',
            'genero.in' => '',
            'notaacceso.numeric' => '',
            'notaacceso.gte' => '',
            'notaacceso.lte' => '',
            'notaacceso.decimal' => '',


        ];
    }

    public function index(): View
    {
        return view('alumno.index', ['alumnos' => Alumno::all()]);
        session()->forget('success');
    }

    public function show(Alumno $alumno): View
    {
        //

        return view('alumno.show', ['alumno'=>$alumno]);
    }

    function store(Request $request): RedirectResponse{
        //1º Validar

       $messages = self::getMessages();
        
        $validator = Validator::make($request->all(), self::RULES, $messages);

        if($validator->fails()){
             return back()->withInput()->withErrors($validator);
        }

        $alumno = new Alumno($request->all());
        try{
        $alumno->save();
        } catch(UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors([
                'error' => 'Nombre y apellidos ya existentes.',
                //'nombre' => 'Este campo forma parte de la clave unica',
                //'apellido' => 'Este campo forma parte de la clave unica'
            ]);
        } catch(\Exception $e){
             return back()->withInput()->withErrors([
                'error' => 'No se ha podido crear el alumno.',
                //'nombre' => 'Este campo forma parte de la clave unica',
                //'apellido' => 'Este campo forma parte de la clave unica'
            ]);
            
        }
        
        return redirect()->route('alumno.index')->with(['success' => 'Se ha creado el alumno']);
    }

    /*
    function store(Request $request) RedirectResponse{
        //dd($request->all());
        //protected $fillable = ['nombre', 'apellidos', 'fnac', 'genero', 'nacceso'];
        $alumno = new Alumno($request->all());
        /*$alumno->nombre = $request->nombre;
        $alumno->apellidos = $request->apellidos;
        $alumno->genero = $request->genero;
        $alumno->fnac = $request->fnac;
        $alumno->nacceso = $request->nacceso;
        $alumno->save();
        //dd($alumno);
        echo 'parece que todo ha ido bien.';
    }
    */

    public function update(Request $request, Alumno $alumno): RedirectResponse
    {
        
 $alumno -> update($request->all());
        try{
        $alumno->update();
        } catch(UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors([
                'error' => 'Nombre y apellidos ya existentes.',
                //'nombre' => 'Este campo forma parte de la clave unica',
                //'apellido' => 'Este campo forma parte de la clave unica'
            ]);
        } catch(\Exception $e){
             return back()->withInput()->withErrors([
                'error' => 'Error al editar el alumno.',
                //'nombre' => 'Este campo forma parte de la clave unica',
                //'apellido' => 'Este campo forma parte de la clave unica'
            ]);
            
        }
        return redirect()->route('alumno.index');
    }
}

