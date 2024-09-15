<input type="hidden" id="id">

<div class="modal fade" id="addItemButton" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body p-md-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2 pb-1 title">Tambah Barang Baru</h3>
        </div>
        <form id="addNewCCForm" class="row g-4" onsubmit="return false">
          <div class="col-12">
              <div class="form-floating form-floating-outline">
                <input id="name" name="name" class="form-control credit-card-mask" type="text" placeholder="Nama Kategori"/>
                <div class="invalid-feedback"></div>
                <label for="modalAddCard">Nama Barang</label>
              </div>
          </div>
          <div class="col-12">
            <div class="form-floating form-floating-outline">
              <select id="category_id" name="category_id" class="form-control list-category">
                <option value=""></option>
                @foreach($category as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>        
              <div class="invalid-feedback"></div>
              <label for="modalAddCard">Nama Kategori</label>
            </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input id="stock" name="stock" class="form-control credit-card-mask" type="number" placeholder="Stok Barang"/>
            <div class="invalid-feedback"></div>
            <label for="modalAddCard">Stock Barang</label>
          </div>
      </div>
          <div class="col-12 text-center">
            <button type="submit" id="submit-button" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-outline-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>