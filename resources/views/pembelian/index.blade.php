@extends('layouts.main')
@section('title') Pembelian @endsection
@section('content')
<div class="page-inner">
    <div class="page-inner">
        <div class="page-header">
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="/">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pembelian.index') }}">Pembelian</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if(session()->has('fail'))
                    <div class="alert alert-danger">
                        {{ session()->get('fail') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('pembelian.create') }}" class="pull-right btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="display table table-striped table-hover" >
                                <thead>
                                <tr>
                                    <td>#</td>
                                    <td>No Beli</td>
                                    <td>Tgl Beli</td>
                                    <td>No Faktur</td>
                                    <td>Total Beli</td>
                                    <th class="none">Detail Pembelian</th>
                                    <td style="width: 15%;">Option</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($pembelians as $idx=>$pembelian)
                                <tr>
                                    <td>{{ $idx+1 }}</td>
                                    <td>{{ $pembelian->no_beli }}</td>
                                    <td>{{ $pembelian->tgl_beli }}</td>
                                    <td>{{ $pembelian->no_faktur }}</td>
                                    <td>@currency($pembelian->total)</td>
                                    <td>
                                        <table style="width: 100%">
                                            <tr>
                                                <td>No Order</td>
                                                <td>Tgl Order</td>
                                                <td>Barang</td>
                                                <td>Qty</td>
                                                <td>Subtotal</td>
                                            </tr>
                                            @foreach ($pembelian->details as $idx=>$detail)
                                            <tr>
                                                <td>{{ $pembelian->order->no_order}}</td>
                                                <td>{{ $pembelian->order->tgl_order}}</td>
                                                <td>{{$detail->barang->kd_barang }} - {{ $detail->barang->nm_brg }}</td>
                                                <td>{{ $detail->qty_brg }}</td>
                                                <td>@currency($detail->subtotal)</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>
                                        <a href="{{ route('pembelian.edit', ['pembelian'=>$pembelian->id]) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form 
                                        action="{{ route('pembelian.destroy', ['pembelian'=>$pembelian->id]) }}" 
                                        method="POST"
                                        style="display: inline"
                                        onsubmit="return confirm('Are you sure to delete?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script >
    $(document).ready(function() {
        $('#table').DataTable({
            'responsive': true
        });
    });
</script>
@endsection
