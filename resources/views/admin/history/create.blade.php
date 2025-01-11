<button class="btn btn-sm mx-1 btn-primary" data-toggle="modal" data-target="#createHistoryModal">
    <i class="fa fa-plus"></i> Tambah
</button>

<!-- Create Modal -->
<div class="modal fade" id="createHistoryModal" tabindex="-1" role="dialog" aria-labelledby="createHistoryoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createHistoryoryModalLabel">Tambah History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('employee.history.store') }}" method="POST" enctype="multipart/form-data">                
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama History</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama" required>
                    </div>
                    <div class="form-group">
                        <label for="product">Nama Product</label>
                        <input type="text" name="product" id="product" class="form-control" placeholder="Masukkan nama product" required>
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" name="total" id="total" class="form-control" placeholder="100000" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
