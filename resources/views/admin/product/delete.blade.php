<!-- Button untuk Memunculkan Modal Hapus -->
<button class="btn btn-sm mx-1 btn-danger" data-toggle="modal" data-target="#deleteProductModal{{ $product->id }}">
    <i class="fa fa-trash"></i> Hapus
</button>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteProductModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Header Modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel{{ $product->id }}">Hapus Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form untuk Menghapus Produk -->
            <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <!-- Body Modal -->
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus produk <strong>"{{ $product->name }}"</strong>?</p>
                </div>

                <!-- Footer Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
