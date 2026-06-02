<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\ClassRoom;
use App\Models\Campus;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $q = Module::query()->with(['classes','enrollments','affiliates'])->latest();
        if ($request->filled('search')) $q->where('name','like','%'.$request->search.'%');
        if ($request->filled('module')) $q->where('id',$request->module);
        return $this->withOrg('modules.index', ['modules'=>$q->paginate(20)]);
    }

    public function create()
    {
        $campuses = Campus::all();
        return $this->withOrg('modules.create', compact('campuses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:modules',
            'description' => 'nullable|string',
            'campus_id'   => 'required|exists:campuses,id',
            'is_active'   => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        Module::create($data);
        return redirect()->route('modules.index')->with('success','Course created.');
    }

    public function show(Module $module)
    {
        $module->load(['classes.teacher','classes.enrollments','enrollments.student','affiliates']);
        return $this->withOrg('modules.show', compact('module'));
    }

    public function edit(Module $module)
    {
        $campuses = Campus::all();
        return $this->withOrg('modules.edit', compact('module','campuses'));
    }

    public function update(Request $request, Module $module)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:modules,code,'.$module->id,
            'description' => 'nullable|string',
            'campus_id'   => 'required|exists:campuses,id',
            'is_active'   => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $module->update($data);
        return redirect()->route('modules.show',$module)->with('success','Course updated.');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('modules.index')->with('success','Course deleted.');
    }
}
