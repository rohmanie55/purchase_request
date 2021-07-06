@extends('layouts.main')
@section('title') Purchase Request @endsection
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
                    <a href="{{ route('user.index') }}">Purchase Request</a>
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
                        <a href="{{ route('request.create') }}" class="pull-right btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="display table table-striped "  width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Request</th>
                                    <th>Tgl Request</th>
                                    <th>Tgl Butuh</th>
                                    <th>User Request</th>
                                    <th class="none">Detail Request</th>
                                    <th style="width: 15%;">Option</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($requests as $idx=>$request)
                                <tr>
                                    <td>{{ $idx+1 }}</td>
                                    <td>{{ $request->no_request }}</td>
                                    <td>{{ $request->tgl_request }}</td>
                                    <td>{{ $request->tgl_butuh }}</td>
                                    <td>{{ $request->user->name }}</td>
                                    <td>
                                        <table style="width: 100%">
                                            <tr>
                                                <td>Barang</td>
                                                <td>Jumlah</td>
                                            </tr>
                                            @foreach ($request->details as $idx=>$detail)
                                            <tr>
                                                <td>{{$detail->barang->kd_barang }} - {{ $detail->barang->nm_brg }}</td>
                                                <td>{{ $detail->qty_request }} {{ $detail->barang->unit }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>
                                        <a href="{{ route('request.edit', ['request'=>$request->id]) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form 
                                        action="{{ route('request.destroy', ['request'=>$request->id]) }}" 
                                        method="POST"
                                        style="display: inline"
                                        onsubmit="return confirm('Are you sure to delete this data?')">
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
