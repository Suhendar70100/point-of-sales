@extends("layouts.main")

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="mb-2">Point Of Sale</h4>
                </div>
                <div class="card-body d-flex justify-content-between flex-wrap gap-3" id="overview-card">
                    
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body" id="highest-transaction-card">
                    
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body" id="lowest-transaction-card">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push("my-scripts")
<script>
    $(document).ready(function() {
        $.getJSON("/api/dashboard-data", function(response) {
            $("#overview-card").html(`
                <div class="d-flex gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded">
                            <i class="mdi mdi-folder mdi-24px"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h4 class="mb-0">${response.totalCategories}</h4>
                        <small class="text-muted">Kategori</small>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-warning rounded">
                            <i class="mdi mdi-package-variant mdi-24px"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h4 class="mb-0">${response.totalItems}</h4>
                        <small class="text-muted">Barang</small>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-info rounded">
                            <i class="mdi mdi-trending-up mdi-24px"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h4 class="mb-0">${response.totalTransactions}</h4>
                        <small class="text-muted">Transaksi</small>
                    </div>
                </div>
            `);

            $("#highest-transaction-card").html(`
                <h5>Transaksi Terbanyak</h5>
                <h4>${response.highestTransaction.total_quantity}</h4>
                <small>Barang: ${response.highestTransaction.item.name}</small>
            `);

            $("#lowest-transaction-card").html(`
                <h5>Transaksi Paling Sedikit</h5>
                <h4>${response.lowestTransaction.total_quantity}</h4>
                <small>Barang: ${response.lowestTransaction.item.name}</small>
            `);
        });
    });
</script>
@endpush
