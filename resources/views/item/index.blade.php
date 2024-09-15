@extends("layouts.main")

@section("content")
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4"><span class="text-muted fw-light">Pengaturan /</span> Barang</h4>
        <!-- Column Search -->
        <div class="card">
            <div class="d-flex justify-content-between me-3 align-items-center">
                <h5 class="card-header">Daftar Barang</h5>
                <button type="button"
                class="btn btn-primary" id="buttonAdd"><i class="mdi mdi-plus"></i>Tambah
                </button>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-bordered dataTable">
                    <thead>
                    <tr>
                        <th>NO.</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok Barang</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Column Search -->
    </div>
    @include('item.modal')
@endsection
@push("my-scripts")
    <script src="{{asset('javascripts/item/index.js')}}"></script>
@endpush