<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestDetail;
use App\Models\PRequest;
use App\Models\Barang;
use DB;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('request.index', ['requests'=> PRequest::with('details.barang', 'user:id,name')->get() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('request.create', ['barangs'=>Barang::select('id', 'kd_barang','nm_brg', 'harga', 'unit')->get()]);
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
            'tgl_request'=> 'required',
            'tgl_butuh'  => 'nullable|after:tgl_request',
        ]);

        DB::transaction(function () use ($request){

            $last = PRequest::selectRaw('MAX(no_request) as number')->first();
            $no_request= "R".sprintf("%05s", substr($last->number, 1, 5)+1);
            $details = [];

            $pr = PRequest::create([
                'no_request' => $no_request,
                'tgl_request'=> $request->tgl_request,
                'tgl_butuh'  => $request->tgl_butuh,
                'user_id'   => auth()->user()->id,
            ]);

            foreach($request->barang_id as $idx=>$barang_id){
                $details[] = ['barang_id'=>$barang_id, 'qty_request'=> $request->qty_request[$idx], 'request_id'=>$pr->id];
            }

            RequestDetail::insert($details);
        });

        return redirect()->route('request.index')->with('message', 'Create PR Successfull!');
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
        return view('request.edit', [
            'request' => PRequest::with('details')->findOrFail($id),
            'barangs'=>Barang::select('id', 'kd_barang','nm_brg', 'harga', 'unit')->get()
        ]);
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
            'tgl_request'=> 'required',
            'tgl_butuh'  => 'nullable|after:tgl_request',
        ]);

        DB::transaction(function () use ($request, $id){
            // $details = [];
            $forms   = collect();
            $details = RequestDetail::where('request_id', $id)->get();

            foreach($request->barang_id as $idx=>$barang_id){
                $forms->push(['id'=>$request->id[$idx] ?? null, 'barang_id'=>$barang_id, 'qty_request'=> $request->qty_request[$idx], 'request_id'=>$id]);
            }

            PRequest::find($id)->update([
                'tgl_request'=> $request->tgl_request,
                'tgl_butuh'  => $request->tgl_butuh,
            ]);

            foreach($details as $detail){
                $form = $forms->where('id', $detail->id)->first();
                if($form){
                    $detail->barang_id  = $form['barang_id'];
                    $detail->qty_request= $form['qty_request'];
                    $detail->request_id= $form['request_id'];
                    $detail->save();
                }else{
                    $detail->delete();
                }
            }

            RequestDetail::insert($forms->whereNull('id')->toArray());
        });

        return redirect()->route('request.index')->with('message', 'Update PR Successfull!');
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
            PRequest::findOrFail($id)->delete();

            RequestDetail::where('request_id', $id)->delete();

            return redirect()->route('request.index')->with('success', 'Delete Request Successfull!');
       } catch (\Throwable $th) {
            return redirect()->route('request.index')->with('fail', 'Delete Request Failed!');
       }
    }
}
