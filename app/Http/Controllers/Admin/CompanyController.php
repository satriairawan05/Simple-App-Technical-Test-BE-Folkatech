<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;

class CompanyController extends Controller
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
        return view('admin.company.index',[
            'companies' => Company::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request)
    {
        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;
        if($request->file('logo') != null){
            $company->logo = $request->file('logo')->store('company-images');
        }
        $company->save();

        return redirect()->to(route('company.index'))->with('success','Data '. $company->name . ' Berhasil di tambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('admin.company.edit',['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        if ($request->file('logo') != $company->logo) {
            \Illuminate\Support\Facades\Storage::delete($company->logo);
        }

        if($request->file('logo')){
            $company->logo = $request->file('logo')->store('company-images');
        }

        $company->save();

        return redirect()->to(route('company.index'))->with('success','Data '. $company->name . ' Berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->to(route('company.index'))->with('success','Data '. $company->name . ' Berhasil di hapus!');
    }
}
