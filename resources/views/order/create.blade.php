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
                        <h4 class="card-title">Tambah Purchase Order</h4>
                    </div>
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                    <div class="card-body p-4 row justify-content-center">
                        <div class="col-10">
                        <div class="form-group @error('tgl_order') has-error has-feedback @enderror">
                            <label>Tgl Order</label>
                            <input name="tgl_order" value="{{ old('tgl_order') }}" type="date" class="form-control" placeholder="Tgl Order">
                            @error('tgl_order') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('suplier_id') has-error has-feedback @enderror">
                            <label>Pilih Supplier</label>
                            <select name="supplier_id" class="form-control">
                                @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ $supplier->id==old('supplier_id') ? 'selected' : ''}}>{{ $supplier->kd_supp }} - {{ $supplier->nm_supp }}</option>
                                @endforeach
                            </select>
                            @error('suplier_id') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('request_id') has-error has-feedback @enderror">
                            <label>Pilih PR</label>
                            <select id="request_id" name="request_id" class="form-control" onchange="loadRequest()">
                                @foreach ($requests->where('detaile', '<>', null) as $request)
                                <option value="{{ $request->id }}" >{{ $request->no_request }}</option>
                                @endforeach
                            </select>
                            @error('request_id') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        </div>
                        <div class="col-10 row pt-4" id="barang_field">

                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <a class="btn btn-sm btn-danger mr-2" href="{{ route('order.index') }}">
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
    const requests= {!! json_encode($requests->toArray(), JSON_HEX_TAG) !!}

    loadRequest = ()=>{
        const req_id  = $("#request_id").val() || requests[0].id

        const request = requests.find(req=>req.id==req_id)

        $('#barang_field').empty();
        request.detaile.forEach((detail, idx) => addField(detail, idx));

        getTotal()
    }

    addField = (detail, idx) =>{
        const field = `
        <div class="form-group col-7">
            <label>Nama Barang</label>
            <input type="hidden" name="detail_id[]" value="${detail.id}">
            <input type="hidden" name="barang_id[]" value="${detail.b_id}">
            <input type="hidden" name="harga[]" value="${detail.harga}">
            <input name='barang[]' class="form-control" value="${detail.kd_barang} - ${detail.nm_brg} @ ${convertToRupiah(detail.harga)}" readonly>
        </div>
        <div class="form-group col-2">
            <label>Qty</label>
            <input name="qty_order[]" onchange="sumTotal(${idx})" min="0" max="${detail.qty_sisa}" type="number" class="form-control" value="${detail.qty_sisa}" placeholder="Qty">
        </div>
        <div class="form-group col-3">
            <label>Subtotal</label>
            <input type="number" class="form-control" readonly name="subtotal[]" value="${detail.qty_sisa*detail.harga}">
        </div>
        `
        $('#barang_field').append(field)
    }

    sumTotal=(idx) =>{
        $("input[name='subtotal[]']")[idx].value =  $("input[name='qty_order[]']")[idx].value*$("input[name='harga[]']")[idx].value
        $('.total').remove()
        getTotal()
    }

    getTotal = ()=>{
        let total = 0;
        for (let index = 0; index < $("input[name='subtotal[]']").length; index++) {
            const element = $("input[name='subtotal[]']")[index];
            total += parseFloat(element.value)
        }
        $('#barang_field').append(`<div class="col-9 text-right total"><b>Total:</b></div><div class="col-3 total"><input name="total" type="number" value="${total}" class="form-control" readonly></div>`)
    }

    loadRequest();
</script>
@endsection
