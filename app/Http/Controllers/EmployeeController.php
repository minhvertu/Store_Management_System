<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Exports\EmployeeExport;
use Maatwebsite\Excel\Facades\Excel;
class EmployeeController extends Controller
{
    //
    // public function __construct()
    // {
    //     $this->middleware('auth:api'); //bắt buộc khi sử dụng phải đăng nhập
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Employee::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->can('create-employees')) {
            $employee = new Employee();
            $employee->name = $request->input('name');
            $employee->salary_code = $request->input('salary_code');
            $employee->employee_code = $request->input('employee_code');
            $employee->card_id = $request->input('card_id');
            $employee->phone_number = $request->input('phone_number');
            $employee->save();

            return response()->json($employee);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to create Employee!'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
        return $employee;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $employee = Employee::find($id);
        return response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $employee = Employee::find($id);
        $employee->update($request->all());

        return response()->json('The post successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        if ($request->user()->can('delete-employees')) {
            $employee = Employee::find($id);
            $employee->delete();
            return response([
                'status' => true,
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to delete Employee!'
        ], 200);
    }

    public function get_employee_data()
    {
        return Excel::download(new EmployeeExport, 'employees.xlsx');
    }
}
