<input type="hidden" id="id">

<div class="modal fade" id="addTransactionButton" tabindex="-1" aria-hidden="true">
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
              <select id="item_id" name="item_id" class="form-control list-item">
                <option value=""></option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>        
              <div class="invalid-feedback"></div>
              <label for="modalAddCard">Nama Barang</label>
            </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input id="quantity" name="quantity" class="form-control credit-card-mask" type="number" placeholder="Jumlah"/>
            <div class="invalid-feedback"></div>
            <label for="modalAddCard">Jumlah Barang</label>
          </div>
      </div>
      <div class="col-12">
        <div class="form-floating form-floating-outline">
          <input id="transaction_date" name="transaction_date" class="form-control credit-card-mask" type="date" placeholder="Tanggal Transaksi"/>
          <div class="invalid-feedback"></div>
          <label for="modalAddCard">Tanggal Transaksi</label>
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