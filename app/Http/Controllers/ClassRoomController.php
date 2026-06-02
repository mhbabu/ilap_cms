<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Module;
use App\Models\Campus;
use App\Models\User;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    public function index(Request $request)
    {
        $q = ClassRoom::query()->with(['module','campus','teacher','enrollments'])->latest();
        if ($request->filled('module')) $q->where('module_id',$request->module);
        if ($request->filled('campus')) $q->where('campus_id',$request->campus);
        return $this->withOrg('classes.index', ['classes'=>$q->paginate(20)]);
    }

    public function create()
    {
        $modules = Module::all();
        $campuses = Campus::all();
        $teachers = User::where('role','handler')->get();
        return $this->withOrg('classes.create', compact('modules','campuses','teachers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'code'       => 'required|string|max:50|unique:class_rooms',
            'module_id'  => 'required|exists:modules,id',
            'campus_id'  => 'required|exists:campuses,id',
            'teacher_id' => 'required|exists:users,id',
            'is_active'  => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        ClassRoom::create($data);
        return redirect()->route('classes.index')->with('success','Class created.');
    }

    public function show(ClassRoom $class)
    {
        $class->load(['module','campus','teacher','records','enrollments.student']);
        return $this->withOrg('classes.show', compact('class'));
    }

    public function edit(ClassRoom $class)
    {
        $modules = Module::all();
        $campuses = Campus::all();
        $teachers = User::where('role','handler')->get();
        return $this->withOrg('classes.edit', compact('class','modules','campuses','teachers'));
    }

    public function update(Request $request, ClassRoom $class)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'code'       => 'required|string|max:50|unique:class_rooms,code,'.$class->id,
            'module_id'  => 'required|exists:modules,id',
            'campus_id'  => 'required|exists:campuses,id',
            'teacher_id' => 'required|exists:users,id',
            'is_active'  => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $class->update($data);
        return redirect()->route('classes.show',$class)->with('success','Class updated.');
    }

    public function destroy(ClassRoom $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success','Class deleted.');
    }
}
