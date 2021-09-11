@extends('layouts.main')
@section('title') Laporan @endsection
@section('content')
<div class="page-inner mt-5">
    <div class="row justify-content-center">
        @if (auth()->user()->aksess=='departement' || auth()->user()->aksess=='manager')
        <div class="col-12 col-md-5">
            <div class="card">
                <h3 class="card-header">Laporan Bulanan Request</h3>

                <div class="card-body">
                    <form action="{{ route('print', ['report'=>'request']) }}" method="POST" class="form-inline" target="_blank">
                        @csrf
                        <div class="form-group">
                            <label> Bulan:&nbsp;</label>
                            <select name="bln" class="form-control">
                                @for ($bln = 1; $bln <=12 ; $bln++)
                                <option>{{ $bln }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Tahun :&nbsp;</label>
                            <select name="thn" class="form-control">
                                @for ($thn = 2020; $thn <= date('Y') ; $thn++)
                                <option {{ $thn==date('Y') ? 'selected' : ''}}>{{ $thn }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-7">
            <div class="card">
                <h3 class="card-header">Laporan Periodik Request</h3>
                <div class="card-body">
                    <form action="{{ route('print', ['report'=>'request']) }}" method="POST" class="form-inline" target="_blank">
                        @csrf
                        <div class="form-group">
                            <label>Dari:&nbsp;</label>
                            <input type="date" name="dari" value="{{ now()->subDays(30)->format('Y-m-d') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Sampai :&nbsp;</label>
                            <input type="date" name="sampai" value="{{ now()->format('Y-m-d') }}" class="form-control">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @if (auth()->user()->aksess=='purchasing' || auth()->user()->aksess=='manager')
        <div class="col-12 col-md-5">
            <div class="card">
                <h3 class="card-header">Laporan Bulanan Order</h3>

                <div class="card-body">
                    <form action="{{ route('print', ['report'=>'order']) }}" method="POST" class="form-inline" target="_blank">
                        @csrf
                        <div class="form-group">
                            <label> Bulan:&nbsp;</label>
                            <select name="bln" class="form-control">
                                @for ($bln = 1; $bln <=12 ; $bln++)
                                <option>{{ $bln }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Tahun :&nbsp;</label>
                            <select name="thn" class="form-control">
                                @for ($thn = 2020; $thn <= date('Y') ; $thn++)
                                <option {{ $thn==date('Y') ? 'selected' : ''}}>{{ $thn }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-7">
            <div class="card">
                <h3 class="card-header">Laporan Periodik Order</h3>
                <div class="card-body">
                    <form action="{{ route('print', ['report'=>'order']) }}" method="POST" class="form-inline" target="_blank">
                        @csrf
                        <div class="form-group">
                            <label>Dari:&nbsp;</label>
                            <input type="date" name="dari" value="{{ now()->subDays(30)->format('Y-m-d') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Sampai :&nbsp;</label>
                            <input type="date" name="sampai" value="{{ now()->format('Y-m-d') }}" class="form-control">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @if (auth()->user()->aksess=='ap' || auth()->user()->aksess=='manager')
        <div class="col-12 col-md-5">
            <div class="card">
                <h3 class="card-header">Laporan Bulanan Pembelian</h3>

                <div class="card-body">
                    <form action="{{ route('print', ['report'=>'pembelian']) }}" method="POST" class="form-inline" target="_blank">
                        @csrf
                        <div class="form-group">
                            <label> Bulan:&nbsp;</label>
                            <select name="bln" class="form-control">
                                @for ($bln = 1; $bln <=12 ; $bln++)
                                <option>{{ $bln }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Tahun :&nbsp;</label>
                            <select name="thn" class="form-control">
                                @for ($thn = 2020; $thn <= date('Y') ; $thn++)
                                <option {{ $thn==date('Y') ? 'selected' : ''}}>{{ $thn }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-7">
            <div class="card">
                <h3 class="card-header">Laporan Periodik Pembelian</h3>
                <div class="card-body">
                    <form action="{{ route('print', ['report'=>'pembelian']) }}" method="POST" class="form-inline" target="_blank">
                        @csrf
                        <div class="form-group">
                            <label>Dari:&nbsp;</label>
                            <input type="date" value="{{ now()->subDays(30)->format('Y-m-d') }}" name="dari" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Sampai :&nbsp;</label>
                            <input type="date" value="{{ now()->format('Y-m-d') }}" name="sampai" class="form-control">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
