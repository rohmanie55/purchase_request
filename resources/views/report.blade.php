@extends('layouts.main')
@section('title') Laporan @endsection
@section('content')
<div class="page-inner mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h3 class="card-header">Laporan Bulanan</h3>

                <div class="card-body">
                    <form action="" method="POST" class="form-inline">
                        <div class="form-group">
                            <label>Pilih Bulan:&nbsp;</label>
                            <select name="bln" class="form-control">
                                @for ($bln = 1; $bln <=31 ; $bln++)
                                <option>{{ $bln }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pilih Tahun :&nbsp;</label>
                            <select name="thn" class="form-control">
                                @for ($thn = 2021; $thn <= date('Y') ; $thn++)
                                <option>{{ $thn }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary">Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <h3 class="card-header">Laporan Periodik</h3>

                <div class="card-body">
                    <form action="" method="POST" class="form-inline">
                        <div class="form-group">
                            <label>Pilih Bulan Dari:&nbsp;</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Pilih Bulan Sampai :&nbsp;</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary">Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
