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
                    <a href="{{ route('request.index') }}">Purchase Request</a>
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
                        <h4 class="card-title">Edit Purchase Request</h4>
                    </div>
                    <form action="{{ route('request.update', ['request'=>$request->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="card-body p-4 row justify-content-center">
                        <div class="col-10">
                        <div class="form-group @error('tgl_request') has-error has-feedback @enderror">
                            <label>Tgl Request</label>
                            <input name="tgl_request" value="{{ old('tgl_request') ?? $request->tgl_request }}" type="date" class="form-control" placeholder="Tgl Request" required>
                            @error('tgl_request') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('tgl_butuh') has-error has-feedback @enderror">
                            <label>Tgl Butuh</label>
                            <input name="tgl_butuh" value="{{ old('tgl_butuh') ?? $request->tgl_butuh }}" type="date" class="form-control" placeholder="Tgl Butuh" required>
                            @error('tgl_butuh') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        </div>
                        <div class="col-10 row pt-4" id="barang_field">
                            <div class="col-9">
                                <h3>Pilih barang :</h3>
                            </div>
                            <div class="col-3">
                                <button type="button" onclick="addField()" class="btn btn-sm btn-info pull-right"> <i class="fas fa-plus"></i></button>
                            </div>
                            @foreach ($request->details as $idx=>$detail)
                            <div class="form-group barang col-8">
                                <label>Nama Barang</label>
                                <input type="hidden" name="id[]" value="{{ $detail->id }}">
                                <select name="barang_id[]" class="form-control">
                                    @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id }}" {{ $barang->id==$detail->barang_id ? 'selected' : ''}}>{{ $barang->kd_barang }} - {{ $barang->nm_brg }} @ {{ $barang->harga }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group qty col-3">
                                <label>Qty</label>
                                <input name="qty_request[]" value="{{ $detail->qty_request }}" min="0" required type="number" class="form-control" placeholder="Qty">

                            </div>
                            <div class="col-1 action">
                                <label>&nbsp;</label>
                                <button type="button" onclick="removeField({{ $idx }})" class="btn btn-sm btn-danger pull-right mt-3"> <i class="fas fa-trash"></i></button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <a class="btn btn-sm btn-danger mr-2" href="{{ route('request.index') }}">
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
    const barangs = {!! json_encode($barangs->toArray(), JSON_HEX_TAG) !!}

    addField = () =>{
        let options = ''
        barangs.forEach(barang=> options +=`<option value="${barang.id}">${barang.kd_barang} - ${barang.nm_brg}@${barang.harga}</option>`)
        const field = `
        <div class="form-group col-8 barang">
            <label>Nama Barang</label>
            <select name="barang_id[]" class="form-control">
            ${options}
            </select>
        </div>
        <div class="form-group col-3 qty">
            <label>Qty</label>
            <input name="qty_request[]" min="0" required type="number"  class="form-control" placeholder="Qty">
        </div>
        <div class="col-1 action">
            <label>&nbsp;</label>
            <button type="button" onclick="removeField(${$(".barang").length})" class="btn btn-sm btn-danger pull-right mt-3"> <i class="fas fa-trash"></i></button>
        </div>
        `
        $('#barang_field').append(field)
    }

    removeField = (idx) =>{
        $( ".barang" )[idx].remove();
        $( ".qty" )[idx].remove();
        $( ".action" )[idx].remove();
    }
</script>
@endsection
