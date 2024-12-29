<!-- Button untuk Memunculkan Modal Hapus -->
<button class="btn btn-sm mx-1 btn-danger" data-toggle="modal" data-target="#deletecategoryModal{{ $category->id }}">
    <i class="fa fa-trash"></i> Hapus
</button>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deletecategoryModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="deletecategoryModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Header Modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="deletecategoryModalLabel{{ $category->id }}">Hapus category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form untuk Menghapus category -->
            <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <!-- Body Modal -->
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus category <strong>"{{ $category->name }}"</strong>?</p>
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
