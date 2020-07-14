<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return Company::with('category')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        if($request->logo){
            $name = Str::slug($request->name).'-'.time().'.' . explode('/', explode(':', substr($request->logo, 0, strpos($request->logo, ';')))[1])[1];

            \Image::make($request->logo)->save(public_path('img/company/').$name);
        } else {
            $name = 'image.png';
        }
        
        // $category = $request->category_id;
        // $cat = implode(',', $category);

        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'established_at' => $request->established_at,
            'email' => $request->email,
            'website' => $request->website,
            'address' => $request->address,
            'total_office' => $request->total_office,
            'logo' => $name,
            'details' => $request->details,
        ];

        Company::create($data);

        return response()->json(['success' => 'Company Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Company::with('category')->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        if($request->logo != $company->logo){
            $name = Str::slug($request->name).'-'.time().'.' . explode('/', explode(':', substr($request->logo, 0, strpos($request->logo, ';')))[1])[1];

            \Image::make($request->logo)->save(public_path('img/company/').$name);
            $request->merge(['logo' => $name]);

            if(file_exists('img/company/'.$company->logo))
	        {
	            unlink('img/company/'.$company->logo);
	        }
        } else {
            $name = $company->logo;
        }

        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'established_at' => $request->established_at,
            'email' => $request->email,
            'website' => $request->website,
            'address' => $request->address,
            'total_office' => $request->total_office,
            'logo' => $name,
            'details' => $request->details,
        ];

        $company->update($data);

        return response()->json(['success' => 'Company Updated Successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if(file_exists('img/company/'.$company->logo))
        {
            unlink('img/company/'.$company->logo);
        }

        $company->delete();

        return response()->json(['success' => 'Company Deleted Successfully.']);
    }

    public function search()
    {
        if($search = \Request::get('q')) {
            $company = Company::where(function($query) use ($search){
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('address', 'LIKE', "%$search%");
            })->with('category')->get();
        } else {
            $company = Company::with('category')->latest()->get();
        }

        // return response()->json(['company' => $company]);
        return $company;
    }
}
