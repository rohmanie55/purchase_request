@extends('layouts.main')
@section('title') Master User @endsection
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
                    <a href="{{ route('user.index') }}">Master User</a>
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
                        <h4 class="card-title">Tambah User</h4>
                    </div>
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                    <div class="card-body p-4 row justify-content-center">
                        <div class="col-8">
                        <div class="form-group @error('username') has-error has-feedback @enderror">
                            <label>Username</label>
                            <input name="username" value="{{ old('username') }}" type="text" class="form-control" placeholder="Username">
                            @error('username') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('name') has-error has-feedback @enderror">
                            <label>Nama</label>
                            <input name="name" value="{{ old('name') }}" type="text" class="form-control" placeholder="Nama">
                            @error('name') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('password') has-error has-feedback @enderror">
                            <label>Password</label>
                            <input name="password" value="{{ old('password') }}" type="text" class="form-control" placeholder="Password">
                            @error('password') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        <div class="form-group @error('aksess') has-error has-feedback @enderror">
                            <label>Hak Akses</label>
                            <select name="aksess" class="form-control">
                                <option {{ old('aksess')=='departement' ? 'selected' : ''}}>departement</option>
                                <option {{ old('aksess')=='purchasing' ? 'selected' : ''}}>purchasing</option>
                                <option {{ old('aksess')=='ap' ? 'selected' : ''}}>ap</option>
                                <option {{ old('aksess')=='manager' ? 'selected' : ''}}>manager</option>
                            </select>
                            @error('aksess') 
                            <small class="form-text text-danger">
                                <strong>{{ $message }}</strong>
                            </small> 
                            @enderror
                        </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <a class="btn btn-sm btn-danger mr-2" href="{{ route('user.index') }}">
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
