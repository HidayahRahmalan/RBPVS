    <!-- Add Standard pembelajranP modal -->
    <div class="modal fade" id="addSPModal" tabindex="-1" role="dialog" aria-labelledby="addSPModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSPModalLabel">Tambah Standard Pembelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addSPForm">
          <div class="form-group">
            <label for="namaSP">Nama SP:</label>
            <input type="text" class="form-control" id="namaSP" name="namaSP" required>
          </div>
          <div class="form-group">
            <label for="deskripsiSP">Deskripsi SP:</label>
            <textarea class="form-control" id="deskripsiSP" name="deskripsiSP" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="urutanSP">Urutan SP:</label>
            <input type="number" class="form-control" id="urutanSP" name="urutanSP" required>
          </div>
          <input type="hidden" id="skID" name="skID" value="<?php echo $sk_id; ?>"> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" form="addSPForm">Tambah</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Standard pembelajranP modal -->
<div class="modal fade" id="editSPModal" tabindex="-1" role="dialog" aria-labelledby="editSPModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSPModalLabel">Edit Standard Pembelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 

      </div>
      <div class="modal-body">
        <form id="editSPForm">
          <div class="form-group">
            <label for="editNamaSP">Nama SP:</label>
            <input type="text" class="form-control" id="editNamaSP" name="editNamaSP" required>
          </div>
          <div class="form-group">
            <label for="editDeskripsiSP">Deskripsi SP:</label>
            <textarea class="form-control" id="editDeskripsiSP" name="editDeskripsiSP" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="editUrutanSP">Urutan SP:</label>
            <input type="number" class="form-control" id="editUrutanSP" name="editUrutanSP" required>
          </div>
          <input type="hidden" id="editSpID" name="editSpID"> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" 
 form="editSPForm">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</div>

<!-- Tambah kandungan Standard pembelajranP modal -->
<div class="modal fade" id="addKandunganModal" tabindex="-1" role="dialog" aria-labelledby="addKandunganModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addKandunganModalLabel">Tambah Kandungan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addKandunganForm" enctype="multipart/form-data"> 
          <div class="form-group">
            <label for="namaKandungan">Nama Kandungan:</label>
            <input type="text" class="form-control" id="namaKandungan" name="namaKandungan">
          </div>
          <div class="form-group">
            <label for="deskripsiKandungan">Deskripsi Kandungan:</label>
            <textarea class="form-control" id="deskripsiKandungan" name="deskripsiKandungan" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="kandunganPath">Kandungan File:</label>
            <input type="file" class="form-control-file" id="kandunganPath" name="kandunganPath"> 
          </div>
          <div class="form-group">
            <label for="urutanKandungan">Urutan Kandungan:</label>
            <input type="number" class="form-control" id="urutanKandungan" name="urutanKandungan" required>
          </div>
          <input type="hidden" id="spIDForKandungan" name="spIDForKandungan"> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" form="addKandunganForm">Tambah</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Kandungan Modal -->
<div class="modal fade" id="editKandunganModal" tabindex="-1" role="dialog" aria-labelledby="editKandunganModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editKandunganModalLabel">Edit Kandungan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 

      </div>
      <div class="modal-body">
        <form id="editKandunganForm" enctype="multipart/form-data"> 
          <div class="form-group">
            <label for="nama_kandungan">Nama Kandungan:</label>
            <input type="text" class="form-control" id="nama_kandungan" name="nama_kandungan" >
          </div>
          <div class="form-group">
            <label for="deskripsi_kandungan">Deskripsi Kandungan:</label>
            <textarea class="form-control" id="deskripsi_kandungan" name="deskripsi_kandungan" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="kandungan_path">Kandungan File:</label>
            <input type="file" class="form-control-file" id="kandungan_path" name="kandungan_path"> 
            <input type="hidden" id="oldKandunganPath" name="oldKandunganPath">
            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file.</small>
          </div>
          <div class="form-group">
            <label for="urutan_kandungan">Urutan Kandungan:</label>
            <input type="number" class="form-control" id="urutan_kandungan" name="urutan_kandungan" required>
          </div>
          <input type="hidden" id="kandungan_id" name="kandungan_id"> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" form="editKandunganForm">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</div>