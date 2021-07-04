<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\POrder;
use App\Models\PRequest;
use App\Models\OrderDetail;
use App\Models\Barang;
use App\Models\Supplier;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('order.index', ['orders'=> POrder::with('details.barang', 'supplier')->get() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $requests = PRequest::with(['details'=> function ($query) {
            $query->selectRaw('request_details.id,request_id,request_details.barang_id,qty_request, qty_request - COALESCE(SUM(qty_order), 0) as qty_sisa, barangs.id b_id, kd_barang, nm_brg,harga')
            ->leftJoin('order_details', 'request_details.id', '=', 'order_details.detail_id')
            ->leftJoin('barangs', 'barangs.id', '=', 'request_details.barang_id')
            ->groupBy('id');
        }])->get()->transform(function ($item, $key) {
            $item->detaile = $item->details->where('qty_sisa', '>', 0);
            unset($item->details);
            return $item;
        });

        return view('order.create', [
            'suppliers'=> Supplier::select('id', 'kd_supp', 'nm_supp')->get(),
            'requests' => $requests,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::transaction(function () use ($request){

            $last = POrder::selectRaw('MAX(no_order) as number')->first();
            $no_order= "O".sprintf("%05s", substr($last->number, 1, 5)+1);
            $details = [];

            $po = POrder::create([
                'no_order' => $no_order,
                'tgl_order'=> $request->tgl_order,
                'total'    => $request->total,
                'suplier_id'=> $request->supplier_id,
            ]);

            foreach($request->barang_id as $idx=>$barang_id){
                $details[] = [
                    'order_id' =>$po->id,
                    'barang_id'=>$barang_id,
                    'detail_id'=>$request->detail_id[$idx],
                    'qty_order'=>$request->qty_order[$idx],
                    'subtotal' =>$request->subtotal[$idx]
                ];
            }

            OrderDetail::insert($details);
        });

        return redirect()->route('order.index')->with('message', 'Create PO Successfull!');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
