@extends('layouts.main')
@section('title') Master Supplier @endsection
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
                    <a href="{{ route('user.index') }}">Master Supplier</a>
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
                        <a href="{{ route('supplier.create') }}" class="pull-right btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="display table table-striped table-hover" >
                                <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Kode</td>
                                    <td>Nama Suplier</td>
                                    <td>Alamat</td>
                                    <td>Telpon</td>
                                    <td style="width: 15%;">Option</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($suppliers as $idx=>$supplier)
                                <tr>
                                    <td>{{ $idx+1 }}</td>
                                    <td>{{ $supplier->kd_supp }}</td>
                                    <td>{{ $supplier->nm_supp }}</td>
                                    <td>{{ $supplier->alamat }}</td>
                                    <td>{{ $supplier->telpon }}</td>
                                    <td>
                                        <a href="{{ route('supplier.edit', ['supplier'=>$supplier->id]) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form 
                                        action="{{ route('supplier.destroy', ['supplier'=>$supplier->id]) }}" 
                                        method="POST"
                                        style="display: inline"
                                        onsubmit="return confirm('Are you sure delete this data?')">
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
        });
    });
</script>
@endsection
