<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MatriculaController extends Controller
{

    private function getCurso(): Int{
        if(Carbon::now()->month >=9){
            return Carbon::now()->year;
        }else{
            return Carbon::now()->year -1;
        }
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
            'curso escolar'=> '2026/2027',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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