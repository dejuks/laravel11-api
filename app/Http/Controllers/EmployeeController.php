<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::get();
        if ($employees) {
            return EmployeeResource::collection($employees);
        } else {
            return response()->json([
                'message' => 'No data found'
            ], 200);
        }
    }

    public function store(Request $request, Employee $employee)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'phone' => 'required|unique:employees',
            'department' => 'required',
            'salary' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'ALl fields are required'
            ], 422);
        }
        $emp = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department' => $request->department,
            'salary' => $request->salary,
        ]);
        return new EmployeeResource($emp);

    }

    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);

    }

    public function update(Request $request, Employee $employee)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'department' => 'required',
            'salary' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'All fields are required'
            ], 422);

        }
        $emps = $employee->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'department' => $request->department,
            'salary' => $request->salary
        ]);
        if ($emps){
            return response()->json([
                'message' => 'Employee updated successfully',
                'employee' => new EmployeeResource($employee)
            ],200);
        }
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json([
            'message' => 'Employee deleted successfully'
        ],200);

    }
}
