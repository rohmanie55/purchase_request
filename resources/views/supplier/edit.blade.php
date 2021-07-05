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
                    <a href="{{ route('supplier.index') }}">Master Supplier</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Edit</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Supplier</h4>
                    </div>
                    <form action="{{ route('supplier.update', ['supplier'=>$supplier->id]) }}" method="POST">
                        @method('PUT')
                        @csrf
                    <div class="card-body p-4 row justify-content-center">
                        <div class="col-8">
                        <div class="form-group @error('kd_supp') has-error has-feedback @enderror">
                            <label>Kode Supplier</label>
                            <input name="kd_supp" value="{{ old('kd_supp') ?? $supplier->kd_supp }}" type="text" class="form-control" placeholder="Kode Supplier">
                            @error('kd_supp') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('nm_supp') has-error has-feedback @enderror">
                            <label>Nama</label>
                            <input name="nm_supp" value="{{ old('nm_supp') ?? $supplier->nm_supp }}" type="text" class="form-control" placeholder="Nama">
                            @error('nm_supp') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('alamat') has-error has-feedback @enderror">
                            <label>Alamat</label>
                            <input name="alamat" value="{{ old('alamat') ?? $supplier->alamat }}" type="text" class="form-control" placeholder="Alamat">
                            @error('alamat') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('telpon') has-error has-feedback @enderror">
                            <label>Telpon</label>
                            <input name="telpon" value="{{ old('telpon') ?? $supplier->telpon }}" type="text" class="form-control" placeholder="Telpon">
                            @error('telpon') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <a class="btn btn-sm btn-danger mr-2" href="{{ route('supplier.index') }}">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button class="btn btn-sm btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                    </form>
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
