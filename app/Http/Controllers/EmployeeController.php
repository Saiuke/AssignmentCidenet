<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{

    public function index()
    {
        return view('employees.index');
    }

    public function getData()
    {
        $data = Employee::all();
        return Datatables::of($data)->make(true);
    }

    public function create()
    {
        return view('employees.modal-create')->render();
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['bail', 'required', 'max:20'],
            'middle_name' => ['bail', 'required', 'max:20'],
            'last_name' => ['bail', 'required', 'max:20'],
            'other_name' => ['bail', 'required', 'max:50'],
            'work_country' => ['bail', 'required'],
            'document_type' => ['bail', 'required'],
            'document_number' => ['bail', 'required', 'max:20'],
            'department' => ['bail', 'required'],
            'start_date' => ['bail', 'required']
        ]);

        $newEmployee = new Employee([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'other_name' => $request->other_name,
            'work_country' => $request->work_country,
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'email' => $request->first_name . '@example.com' ,
            'department' => $request->department,
            'start_date' => $request->start_date,
            'status' => 'Active',
        ]);

        return json_encode([
            'success' => $newEmployee->save()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Employee $Employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $Employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Employee $employee
     */
    public function edit(Employee $employee)
    {
        return view('employees.modal-create', ['employee' => $employee])->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => ['bail', 'required', 'max:20'],
            'middle_name' => ['bail', 'required', 'max:20'],
            'last_name' => ['bail', 'required', 'max:20'],
            'other_name' => ['bail', 'required', 'max:50'],
            'work_country' => ['bail', 'required'],
            'document_type' => ['bail', 'required'],
            'document_number' => ['bail', 'required', 'max:20'],
            'department' => ['bail', 'required'],
            'start_date' => ['bail', 'required']
        ]);

        $employee->first_name = $request->first_name;
        $employee->middle_name = $request->middle_name;
        $employee->last_name = $request->last_name;
        $employee->other_name = $request->other_name;
        $employee->work_country = $request->work_country;
        $employee->document_type = $request->document_type;
        $employee->document_number = $request->document_number;
        $employee->email = $request->first_name . '@example.com' ;
        $employee->department = $request->department;
        $employee->start_date = $request->start_date;
        $employee->status = 'Active';

        return json_encode([
            'success' => $employee->update()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Employee $Employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $Employee)
    {
        $Employee->delete();
        return response()->json('Deleted succesefully');
    }
}
