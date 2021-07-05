@extends('layouts.main')
@section('title') Purchase Order @endsection
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
                    <a href="{{ route('order.index') }}">Purchase Order</a>
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
                        <a href="{{ route('order.create') }}" class="pull-right btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="display table table-striped table-hover"  width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Order</th>
                                    <th>Tgl Order</th>
                                    <th>Supplier</th>
                                    <th>Total</th>
                                    <th class="none">Detail Order</th>
                                    <th style="width: 15%;">Option</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $idx=>$order)
                                <tr>
                                    <td>{{ $idx+1 }}</td>
                                    <td>{{ $order->no_order }}</td>
                                    <td>{{ $order->tgl_order }}</td>
                                    <td>{{ $order->supplier->kd_supp ?? "" }} - {{ $order->supplier->nm_supp }}</td>
                                    <td>@currency($order->total)</td>
                                    <td>
                                        <table style="width: 100%">
                                            @foreach ($order->details as $idx=>$detail)
                                            <tr>
                                                <td>{{$detail->barang->kd_barang }} - {{ $detail->barang->nm_brg }}</td>
                                                <td>{{ $detail->qty_order }}</td>
                                                <td>@currency($detail->subtotal)</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>
                                        <a href="{{ route('order.edit', ['order'=>$order->id]) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form 
                                        action="{{ route('order.destroy', ['order'=>$order->id]) }}" 
                                        method="POST"
                                        style="display: inline"
                                        onsubmit="return beforeDelete()">
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
