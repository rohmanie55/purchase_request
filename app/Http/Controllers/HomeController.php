<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PRequest;
use App\Models\POrder;
use App\Models\Pembelian;
use PDF;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }

    public function report()
    {
        return view('report.index');
    }

    public function print($report, Request $request)
    {
        switch ($report) {
            case 'request':
                $data = PRequest::with('details.barang', 'user:id,name')
                        ->when(!is_null($request->thn) && !is_null($request->bln), function($query) use($request){
                            $query->whereMonth('tgl_request', $request->bln)->whereYear('tgl_request', $request->thn);
                        })
                        ->when(!is_null($request->dari) && !is_null($request->sampai), function($query) use($request){
                            $query->whereBetween('tgl_request', [$request->dari, $request->sampai]);
                        })->get();
                return PDF::loadView('report.request', ['data'=>$data])->stream("purchase_request_report.pdf", array("Attachment" => false));
                // return view('report.request', ['data'=>$data]);
                break;
            case 'order':
                $data = POrder::with('details.barang','supplier', 'approve:id,name')
                ->when(!is_null($request->thn) && !is_null($request->bln), function($query) use($request){
                    $query->whereMonth('tgl_order', $request->bln)->whereYear('tgl_order', $request->thn);
                })
                ->when(!is_null($request->dari) && !is_null($request->sampai), function($query) use($request){
                    $query->whereBetween('tgl_order', [$request->dari, $request->sampai]);
                })
                ->whereNotNull('approve_id')
                ->get();

                return PDF::loadView('report.order', ['data'=>$data])->setPaper('a4', 'landscape')->stream("purchase_order_report.pdf", array("Attachment" => false));
                break;
            case 'pembelian':
                $data = Pembelian::with('details.barang')
                ->when(!is_null($request->thn) && !is_null($request->bln), function($query) use($request){
                    $query->whereMonth('tgl_beli', $request->bln)->whereYear('tgl_beli', $request->thn);
                })
                ->when(!is_null($request->dari) && !is_null($request->sampai), function($query) use($request){
                    $query->whereBetween('tgl_beli', [$request->dari, $request->sampai]);
                })->get();

                return PDF::loadView('report.pembelian', ['data'=>$data])->setPaper('a4', 'landscape')->stream("purchase_pembelian_report.pdf", array("Attachment" => false));
                break;
        }
    }
}
