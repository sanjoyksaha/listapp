<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
// use Image;

class UserController extends Controller
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
        // $this->authorize('isAdmin');
        if(Gate::allows('isAdmin')){
        return User::latest()->paginate('10');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $this->authorize('isAdmin');
        $image= "image.png";
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'image' => $image,
        ]);
        return response()->json(['message'=>'User Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('isAdmin');
        // $this->authorize('isAdmin');
        if(!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return response()->json(['message'=>'User Info Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $this->authorize('isAdmin');
        $user->delete();

        return response()->json(['message'=>'User Deleted Successfully']);
    }

    public function active(User $user)
    {
        $this->authorize('isAdmin');
        $user->status = true;
        $user->save();

        return response()->json(['message' => 'Now is Active']);
    }

    public function inactive(User $user)
    {
        $this->authorize('isAdmin');
        $user->status = false;
        $user->save();

        return response()->json(['message' => 'Now is Inactive']);
    }

    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(UserRequest $request)
    {
        $user = auth('api')->user();
        $oldImage = $user->image;

        if($request->image != $oldImage){
            $name = $user->name.'-'.time().'.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];

            \Image::make($request->image)->save(public_path('img/profile/').$name);
            $request->merge(['image' => $name]);

            if(file_exists('img/profile/'.$oldImage))
	        {
	            unlink('img/profile/'.$oldImage);
	        }
        } else {
            $request->image = $oldImage;
        }

        if(!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return response()->json(['message' => 'Profile Updated Successfully.']);
    }
}
