<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Rede;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index()
    {
        $roles = Role::paginate(20);
        return view('roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $redes = Rede::all();
        return view('roles.create',compact('redes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validações
        $request->validate([
            'nome'      => 'required|unique:roles',
        ]);

        // Persistência
        $role = new Role;
        $role->nome = $request->nome;
        if(!empty($request->grupoadmin)) $role->grupoadmin = true;
        $role->save();

        // redes
        if(!empty($request->redes)){
            $role->redes()->sync($request->redes);
        }
        else {
            $role->redes()->detach();
        }

        $request->session()->flash('alert-success', 'Grupo cadastrado com sucesso!');
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $redes = Rede::all();
        return view('roles.edit', compact('role','redes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        // Validações
        $request->validate([
            'nome'      => 'required|unique:roles,nome,'. $role->id

        ]);

        // redes
        if(!empty($request->redes)){
            $role->redes()->sync($request->redes);
        }
        else {
            $role->redes()->detach();
        }

        // Persistência
        $role->nome = $request->nome;

        if(!empty($request->grupoadmin)) 
            $role->grupoadmin = true;
        else
            $role->grupoadmin = false;

        $role->save();

        $request->session()->flash('alert-success', 'Grupo atualizado com sucesso!');
        return redirect()->route('roles.show', $role->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        // Remove pessoas desse grupo
        $role->users()->detach();

        // Remove redes desse grupo
        $role->redes()->detach();

        // Remove grupo
        $role->delete();
        return redirect()->route('roles.index')->with('alert-danger', 'Grupo deletado!');
    }
}
