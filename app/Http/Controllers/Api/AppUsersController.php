<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\AppUsers;
use Validator;

class AppUsersController extends BaseController
{
    public function index()
    {
        $users_app = AppUsers::all();
        return $this->sendResponse($users_app->toArray(), 'List Users succesfully');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, 
        [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'zipcode' => 'required',   
        ]);

        if($validator->fails()) {
            return $this->sendError('error validation', $validator->errors());
        }

        $user = new AppUsers([
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'zipcode' => $request->get('zipcode'),
        ]);
        
        $users_app = array();
        $users_app = AppUsers::where('email','=',$request->get('email'))->first();
        
        if (!$users_app) {
            $user->save();
            $confirme_user = AppUsers::where('email','=',$request->get('email'))->first();
            return $this->sendResponse($confirme_user->toArray(), 'User register succesfully');
        } else {
            return $this->sendError('User already exists', 400);
        }

        //return response()->json(compact('users_app', 'message', 'error'));
        //return $this->sendResponse($user->toArray(), 'User created succesfully');
    }

    public function show($id)
    {
        $user = AppUsers::find($id);

        if(is_null($user)) {
            return $this->sendError('User not found!');
        }
        return $this->sendResponse($user->toArray(), 'User listed succesfully');
    }

    public function update(Request $request, User $user)
    {
        $input = $request->all();
        $validator = Validator::make($input, 
        [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'zipcode' => 'required',   
        ]);

        if($validator->fails()) {
            return $this->sendError('error validation', $validator->errors());
        }

        $user->firstname = $input['firstname'];
        $user->lastname  = $input['lastname'];
        $user->email     = $input['email'];
        $user->phone     = $input['phone'];
        $user->address   = $input['address'];
        $user->zipcode   = $input['zipcode'];
        $user->save();
        
        return $this->sendResponse($user->toArray(), 'User updated succesfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->sendResponse($user->toArray(), 'User deleted succesfully');
    }
}