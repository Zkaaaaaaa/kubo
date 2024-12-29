@extends('layouts.client.app')

@section('title', 'Detail Product')

@section('content')
    <div class="container mb-5 pb-5">
        <div class="row">
            <form action="">

                <div class="col-md-12 mb-3">
                    <h3><b>Detail Menu</b></h3>
                    <img class="card-img-top" src="{{ $product->photo }}" alt="Card image cap">
                </div>
                <div class="col-md-12 mb-3">
                    <h4><b>Nama : {{ $product->name }}</b></h4>
                    <p>{{ $product->description }}</p>
                    <h4><b>Harga : Rp.{{ number_format($product->price) }}</b></h4>
                    <div class="mb-3">
                        <h4 class="font-weight-bold" for="note">Catatan :</h4>
                        <textarea class="form-control" name="note" id="note" cols="30" rows="10"></textarea>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-light col-12">Masukan Keranjang</button>
                    </div>

            </form>

        </div>
    </div>
@endsection
