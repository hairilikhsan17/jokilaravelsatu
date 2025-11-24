<!-- Modal Tambah Obat -->
<div class="modal fade" id="tambahObatModal" tabindex="-1" aria-labelledby="tambahObatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border-radius: 15px 15px 0 0; border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title" id="tambahObatModalLabel" style="font-weight: 600;">
                    <i class="bi bi-capsule-pill me-2"></i>Tambah Data Obat / Alkes
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form id="formTambahObat">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Obat">Obat</option>
                            <option value="Alkes">Alkes</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stok" name="stok" min="0" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="kadaluarsa" class="form-label">Kadaluarsa</label>
                        <input type="date" class="form-control" id="kadaluarsa" name="kadaluarsa">
                    </div>
                    <div class="mb-3">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Nama supplier/pemasok">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select class="form-select" id="satuan" name="satuan">
                                <option value="">Pilih Satuan</option>
                                <option value="tablet">Tablet</option>
                                <option value="botol">Botol</option>
                                <option value="pcs">Pcs</option>
                                <option value="box">Box</option>
                                <option value="strip">Strip</option>
                                <option value="vial">Vial</option>
                                <option value="ampul">Ampul</option>
                                <option value="tube">Tube</option>
                                <option value="sachet">Sachet</option>
                                <option value="unit">Unit</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lokasi" class="form-label">Lokasi Penyimpanan</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Contoh: Rak A1, Gudang 2">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Catatan tambahan (opsional)"></textarea>
                    </div>
                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3" style="border-top: 1px solid #e0e0e0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
