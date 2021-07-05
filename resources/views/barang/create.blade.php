@extends('layouts.main')
@section('title') Master Barang @endsection
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
                    <a href="{{ route('barang.index') }}">Master Barang</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Tambah</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Barang</h4>
                    </div>
                    <form action="{{ route('barang.store') }}" method="POST">
                        @csrf
                    <div class="card-body p-4 row justify-content-center">
                        <div class="col-8">
                        <div class="form-group @error('kd_barang') has-error has-feedback @enderror">
                            <label>Kode Barang</label>
                            <input name="kd_barang" value="{{ old('kd_barang') }}" type="text" class="form-control" placeholder="Kode Barang">
                            @error('kd_barang') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('nm_brg') has-error has-feedback @enderror">
                            <label>Nama</label>
                            <input name="nm_brg" value="{{ old('nm_brg') }}" type="text" class="form-control" placeholder="Nama">
                            @error('nm_brg') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('unit') has-error has-feedback @enderror">
                            <label>Unit</label>
                            <input name="unit" value="{{ old('unit') }}" type="text" class="form-control" placeholder="Unit (PCS, SET)">
                            @error('unit') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('harga') has-error has-feedback @enderror">
                            <label>Harga</label>
                            <input name="harga" value="{{ old('harga') }}" type="text" class="form-control" placeholder="Harga">
                            @error('harga') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('stock') has-error has-feedback @enderror">
                            <label>Stock</label>
                            <input name="stock" value="{{ old('stock') }}" type="number" class="form-control" placeholder="Stock">
                            @error('stock') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <a class="btn btn-sm btn-danger mr-2" href="{{ route('barang.index') }}">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button class="btn btn-sm btn-primary">
                            <i class="fas fa-save"></i> Simpan
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
