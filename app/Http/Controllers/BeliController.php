<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\POrder;
use DB;

class BeliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pembelian.index', ['pembelians'=> Pembelian::with('details.barang')->get() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orders = POrder::with(['details'=> function ($query) {
            $query->selectRaw('order_details.id,order_id,order_details.barang_id,qty_order, qty_order - COALESCE(SUM(qty_brg), 0) as qty_sisa, barangs.id b_id, kd_barang, nm_brg,harga')
            ->leftJoin('pembelian_details', 'order_details.id', '=', 'pembelian_details.detail_id')
            ->leftJoin('barangs', 'barangs.id', '=', 'order_details.barang_id')
            ->groupBy('id');
        }])->whereNotNull('approve_at')->get()->transform(function ($item, $key) {
            $item->detaile = $item->details->where('qty_sisa', '>', 0);
            $item->detaile = $item->detaile->count()>0 ? $item->detaile : null;
            unset($item->details);
            return $item;
        });

        return view('pembelian.create', [
            'orders' => $orders,
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
        $request->validate([
            'no_beli'  => 'required|max:100',
            'no_faktur'=> 'required|max:100',
            'tgl_beli' => 'required'
        ]);

        DB::transaction(function () use ($request){

            $details = [];

            $pb = Pembelian::create([
                'no_beli'   => $request->no_beli,
                'no_faktur' => $request->no_faktur,
                'tgl_beli' => $request->tgl_beli,
                'total'     => $request->total,
                'order_id'=> $request->order_id,
            ]);

            foreach($request->barang_id as $idx=>$barang_id){
                if($request->qty_brg[$idx]>0){
                    $details[] = [
                        'beli_id' =>$pb->id,
                        'barang_id'=>$barang_id,
                        'detail_id'=>$request->detail_id[$idx],
                        'qty_brg'=>$request->qty_brg[$idx],
                        'subtotal' =>$request->subtotal[$idx]
                    ];
                }
            }

            PembelianDetail::insert($details);
        });

        return redirect()->route('pembelian.index')->with('message', 'Create Pembelian Successfull!');
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
        $orders = POrder::with(['details'=> function ($query) {
            $query->selectRaw('order_details.id,order_id,order_details.barang_id,qty_order, qty_order - COALESCE(SUM(qty_brg), 0) as qty_sisa, barangs.id b_id, kd_barang, nm_brg,harga')
            ->leftJoin('pembelian_details', 'order_details.id', '=', 'pembelian_details.detail_id')
            ->leftJoin('barangs', 'barangs.id', '=', 'order_details.barang_id')
            ->groupBy('id');
        }])->whereNotNull('approve_at')->get()->transform(function ($item, $key) {
            $item->detaile = $item->details->where('qty_sisa', '>', 0);
            $item->detaile = $item->detaile->count()>0 ? $item->detaile : null;
            return $item;
        });

        return view('pembelian.edit', [
            'pembelian'=> Pembelian::with('details')->find($id),
            'orders'   => $orders,
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
        DB::transaction(function () use ($request, $id){

            $details = [];

            Pembelian::find($id)->update([
                'no_beli'   => $request->no_beli,
                'no_faktur' => $request->no_faktur,
                'tgl_beli' => $request->tgl_beli,
                'total'     => $request->total,
                'order_id'=> $request->order_id,
            ]);

            PembelianDetail::where('beli_id', $id)->delete();

            foreach($request->barang_id as $idx=>$barang_id){
                $details[] = [
                    'beli_id' =>$id,
                    'barang_id'=>$barang_id,
                    'detail_id'=>$request->detail_id[$idx],
                    'qty_brg'=>$request->qty_brg[$idx],
                    'subtotal' =>$request->subtotal[$idx]
                ];
            }

            PembelianDetail::insert($details);
        });

        return redirect()->route('pembelian.index')->with('message', 'Update Pembelian Successfull!');
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
            Pembelian::findOrFail($id)->delete();

            PembelianDetail::where('order_id', $id)->delete();

            return redirect()->route('pembelian.index')->with('success', 'Delete Pembelian Successfull!');
       } catch (\Throwable $th) {
            return redirect()->route('pembelian.index')->with('fail', 'Delete Pembelian Failed!');
       }
    }
}
