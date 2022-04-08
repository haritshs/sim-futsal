<div class="modal fade" id="pendaftaran" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                    <form method="POST" action="{{ url('pendaftaran_turnamen.store') }}">
                        {{ csrf_field() }}
                        <input type="text" name="nama_team" placeholder="" value="{{ old('nama_team') }}">
                        
                        <div style="display: block;">
                            <button type="submit" class="button"><span>Daftar</span></button>
                        </div>

                    </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>