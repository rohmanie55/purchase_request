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
                        <h4 class="card-title">Edit Pembelian</h4>
                    </div>
                    <form action="{{ route('pembelian.update', ['pembelian'=>$pembelian->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="card-body p-4 row justify-content-center">
                        <div class="col-10">
                        <div class="form-group @error('no_beli') has-error has-feedback @enderror">
                            <label>No Beli</label>
                            <input name="no_beli" value="{{ old('no_beli') ?? $pembelian->no_beli }}" type="text" class="form-control" placeholder="No Beli" required>
                            @error('no_beli') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('no_faktur') has-error has-feedback @enderror">
                            <label>No Faktur</label>
                            <input name="no_faktur" value="{{ old('no_faktur') ?? $pembelian->no_faktur }}" type="text" class="form-control" placeholder="No Faktur" required>
                            @error('no_faktur') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('tgl_beli') has-error has-feedback @enderror">
                            <label>Tgl Beli</label>
                            <input name="tgl_beli" value="{{ old('tgl_beli') ?? $pembelian->tgl_beli }}" type="date" class="form-control" required>
                            @error('tgl_beli') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Pilih PO</label>
                            <select id="order_id" name="order_id" class="form-control" onchange="loadRequest()" required>
                                @foreach ($orders->where('details', '<>', null) as $order)
                                <option value="{{ $order->id }}" {{ $order->id==$pembelian->order_id ? 'selected' : ''}}>{{ $order->no_order }}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="col-10 row pt-4" id="barang_field">
                            @foreach ($orders->where('id', $pembelian->order_id)->first()->details as $idx=>$detail)
                            <div class="form-group col-7">
                                <label>Nama Barang</label>
                                <input type="hidden" name="detail_id[]" value="{{$detail->id}}">
                                <input type="hidden" name="barang_id[]" value="{{$detail->b_id}}">
                                <input type="hidden" name="harga[]" value="{{ $detail->harga}}">
                                <input name='barang[]' class="form-control" value="{{ $detail->kd_barang}} - {{$detail->nm_brg}} @ {{ $detail->harga }}" readonly>
                            </div>
                            <div class="form-group col-2">
                                <label>Qty</label>
                                <input name="qty_brg[]" onchange="sumTotal({{$idx}})" min="0"  type="number" class="form-control" value="{{ $pembelian->details->where('detail_id', $detail->id)->first()->qty_brg }}" placeholder="Qty" required>
                            </div>
                            <div class="form-group col-3">
                                <label>Subtotal</label>
                                <input type="number" class="form-control" readonly name="subtotal[]" value="{{ $pembelian->details->where('detail_id', $detail->id)->first()->subtotal }}">
                            </div>
                            <div class="col-9 text-right total"><b>Total:</b></div><div class="col-3 total"><input name="total" type="number" value="{{ $pembelian->total }}" class="form-control" readonly></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <a class="btn btn-sm btn-danger mr-2" href="{{ route('pembelian.index') }}">
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
const requests= {!! json_encode($orders->toArray(), JSON_HEX_TAG) !!}

loadRequest = ()=>{
    const req_id  = $("#order_id").val() || requests[0].id

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
        <input name="qty_brg[]" onchange="sumTotal(${idx})" min="0" max="${detail.qty_sisa}" type="number" class="form-control" value="${detail.qty_sisa}" placeholder="Qty" required>
    </div>
    <div class="form-group col-3">
        <label>Subtotal</label>
        <input type="number" class="form-control" readonly name="subtotal[]" value="${detail.qty_sisa*detail.harga}">
    </div>
    `
    $('#barang_field').append(field)
}

sumTotal=(idx) =>{
    $("input[name='subtotal[]']")[idx].value =  $("input[name='qty_brg[]']")[idx].value*$("input[name='harga[]']")[idx].value
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
</script>
@endsection
