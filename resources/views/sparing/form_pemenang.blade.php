
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Pemenang Sparing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/admin/sparing" method="POST" id="editForm">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
          <div class="form-group">
            <label for="inputState">Pilih Tim</label>
            <select id="tim_id" name="tim_id" class="form-control">
              <option value="{{ $row->tim_id }}">{{ $row->tim_id }}</option>
              <option value="{{ $row->tim_lawan }}">{{ $row->tim_lawan }}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="inputState">Pilih Pembayaran</label>
            <select id="hadiah_pemenang" name="hadiah_pemenang" class="form-control">
              <option selected>Choose...</option>
              <option value="cash">Cash</option>
              <option value="transfer">Transfer</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Skor</label>
            <input type="text" class="form-control" name="pesan" id="pesan" placeholder="">
          </div>
          <div class="form-group">
            <label for="exampleFormControlFile1">Upload Bukti</label>
            <input type="file" class="form-control-file" name="bukti_transfer" id="bukti_transfer">
          </div>
          <div class="form-group">
            <label for="">Nama Pengirim</label>
            <input type="text" name="nama_pengirim" class="form-control" id="nama_pengirim" placeholder="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
