<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('barang.index', ['barangs'=> Barang::get() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('barang.create');
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
            'kd_barang' => 'required|max:100|unique:barangs',
            'nm_brg' => 'required|max:255',
            'harga' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')->with('message', 'Create Barang Successfull!');
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
        return view('barang.edit', ['barang' => Barang::findOrFail($id)]);
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
            'kd_barang' => 'required|max:100|unique:barangs,kd_barang,'.$id,
            'nm_brg' => 'required|max:255',
            'harga' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        Barang::find($id)->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Update Barang Successfull!');
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
            Barang::findOrFail($id)->delete();

            return redirect()->route('barang.index')->with('success', 'Delete Barang Successfull!');
       } catch (\Throwable $th) {
            return redirect()->route('barang.index')->with('fail', 'Delete Barang Failed!');
       }
    }
}
