<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Carbon\Carbon;
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
        $data = Employee::orderBy('id', 'desc')->get();
        return Datatables::of($data)->make(true);
    }

    public function create()
    {
        return view('employees.modal-create')->render();
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['bail', 'required', 'max:20', 'regex:/^[a-zA-Z]+$/u'],
            'middle_name' => ['bail', 'required', 'max:20', 'regex:/^[a-zA-Z]+$/u'],
            'last_name' => ['bail', 'required', 'max:20', 'regex:/^[a-zA-Z]+$/u'],
            'other_name' => ['bail', 'max:50', 'regex:/^[a-zA-Z\s]+$/u'],
            'work_country' => ['bail', 'required'],
            'document_type' => ['bail', 'required', 'max:20'],
            'document_number' => ['bail', 'required', 'max:20', 'unique:employees'],
            'department' => ['bail', 'required'],
            'start_date' => ['bail', 'required', 'before_or_equal:today', 'after_or_equal:' . Carbon::now()->subMonth()->format('Y-m-d')]
        ]);

        $newEmployee = new Employee([
            'first_name' => strtoupper($request->first_name),
            'middle_name' => strtoupper($request->middle_name),
            'last_name' => strtoupper($request->last_name),
            'other_name' => strtoupper($request->other_name),
            'work_country' => $request->work_country,
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'department' => $request->department,
            'start_date' => $request->start_date,
            'status' => 'Active',
        ]);

        try {
            if ($newEmployee->save()) {
                return json_encode([
                    'success' => $newEmployee->generateEmailAddress()
                ]);
            }
        } catch (\Exception $error) {
            throw $error;
        }
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
            'first_name' => ['bail', 'required', 'max:20', 'regex:/^[a-zA-Z]+$/u'],
            'middle_name' => ['bail', 'required', 'max:20', 'regex:/^[a-zA-Z]+$/u'],
            'last_name' => ['bail', 'required', 'max:20', 'regex:/^[a-zA-Z]+$/u'],
            'other_name' => ['bail', 'max:50', 'regex:/^[a-zA-Z\s]+$/u'],
            'work_country' => ['bail', 'required'],
            'document_type' => ['bail', 'required', 'max:20'],
            'document_number' => ['bail', 'required', 'max:20', 'unique:employees,document_number,' . $employee->id],
            'department' => ['bail', 'required'],
            'start_date' => ['bail', 'required', 'before_or_equal:today', 'after_or_equal:' . Carbon::now()->subMonth()->format('Y-m-d')]
        ]);

        $employee->first_name = $request->first_name;
        $employee->middle_name = $request->middle_name;
        $employee->last_name = $request->last_name;
        $employee->other_name = $request->other_name;
        $employee->work_country = $request->work_country;
        $employee->document_type = $request->document_type;
        $employee->document_number = $request->document_number;
        $employee->department = $request->department;
        $employee->start_date = $request->start_date;
        $employee->status = 'Active';

        try {
            if ($employee->save()) {
                $employee->generateEmailAddress();
                return json_encode([
                    'success' => $employee->generateEmailAddress()
                ]);
            }
        } catch (\Exception $error) {
            throw $error;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Employee $Employee
     */
    public function destroy(Employee $Employee)
    {
        $Employee->delete();
        return response()->json('Deleted succesefully');
    }
}
