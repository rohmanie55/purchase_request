<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', ['users'=> User::get() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:100|unique:users',
            'name' => 'required|max:255',
            'password' => 'required',
            'aksess' => 'required',
        ]);
        //hasing
        $request['password'] = bcrypt($request->password);

        User::create($request->all());

        return redirect()->route('user.index')->with('message', 'Create User Successfull!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('users.edit', ['user' => User::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|max:100|unique:users,username,'.$id,
            'name' => 'required|max:255',
            'aksess' => 'required',
        ]);
        //hasing
        if($request->password)
            $request['password'] = bcrypt($request->password);
        else
            unset($request['password']);

        User::find($id)->update($request->all());

        return redirect()->route('user.index')->with('success', 'Update User Successfull!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       try {
            User::findOrFail($id)->delete();

            return redirect()->route('user.index')->with('success', 'Delete User Successfull!');
       } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('fail', 'Delete User Failed!');
       }
    }
}
