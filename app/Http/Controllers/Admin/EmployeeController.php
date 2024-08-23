<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Notifications\CompanyToEmployeeNotification;

class EmployeeController extends Controller
{
    /**
     * Constructor for Controller.
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.employee.index',[
            'employee' => Employee::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employee.create',[
            'company' => \App\Models\Company::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeStoreRequest $request)
    {
        $employee = new Employee();
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->company_id = $request->company_id;
        $employee->save();

        $employeeName = $employee->firstname . ' ' . $employee->lastname;

        $company = \App\Models\Company::where('id',$employee->company_id)->first();
        $company->notify(new CompanyToEmployeeNotification($company->email, $employee->email, $employeeName));

        return redirect()->to(route('employee.index'))->with('success','Data '. $employee->email . ' Berhasil di tambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('admin.employee.edit',[
            'company' => \App\Models\Company::all(),
            'd' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->company_id = $request->company_id;
        $employee->save();

        return redirect()->to(route('employee.index'))->with('success','Data '. $employee->email . ' Berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->to(route('employee.index'))->with('success','Data '. $employee->email . ' Berhasil di hapus!');
    }
}
