@extends('layouts.admin.app')

@section('title', 'Promo')

@section('content')

<form action="{{ route('employee.promo.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Gambar 1 -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <label for="photo_1" class="form-label">Gambar 1</label>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $promo->photo_1) }}" alt="Gambar 1" class="img-fluid mb-3" style="max-height: 200px;">
                    <input type="file" name="photo_1" id="photo_1" class="form-control">
                </div>
            </div>
        </div>

        <!-- Gambar 2 -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <label for="photo_2" class="form-label">Gambar 2</label>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $promo->photo_2) }}" alt="Gambar 2" class="img-fluid mb-3" style="max-height: 200px;">
                    <input type="file" name="photo_2" id="photo_2" class="form-control">
                </div>
            </div>
        </div>

        <!-- Gambar 3 -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <label for="photo_3" class="form-label">Gambar 3</label>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $promo->photo_3) }}" alt="Gambar 3" class="img-fluid mb-3" style="max-height: 200px;">
                    <input type="file" name="photo_3" id="photo_3" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

@endsection
