@extends('layouts.admin.app')

@section('title', 'promo')

@section('content')

<form action="{{ route('employee.promo.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="photo_1">Gambar 1</label>
        <input type="file" name="photo_1" id="photo_1">
        <img src="{{ asset('storage/' . $promo->photo_1) }}" alt="">
    </div>
    <div class="form-group">
        <label for="photo_2">Gambar 2</label>
        <input type="file" name="photo_2" id="photo_2">
        <img src="{{ asset('storage/' . $promo->photo_2) }}" alt="">
    </div>
    <div class="form-group">
        <label for="photo_3">Gambar 3</label>
        <input type="file" name="photo_3" id="photo_3">
        <img src="{{ asset('storage/' . $promo->photo_3) }}" alt="">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

@endsection