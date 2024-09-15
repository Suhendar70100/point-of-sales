const transaction = $('.dataTable')
const transactionUrl = `${BASE_URL}/api/transaction`
const addButton = $('#buttonAdd')
const modalTitle = $('.title')
const submitButton = $('#submit-button')
const listItems = $('.list-item')


const formConfig = {
    fields: [
        {
            id: 'item_id',
            name: 'Transaksi'
        }, 
        {
            id: 'quantity',
            name: 'Jumlah Transaksi'
        },
        {
            id: 'transaction_date',
            name: 'Tanggal Transaksi'
        },
    ]
}

const getCategory = () => {
    listItems.select2({
        dropdownParent: $('#addTransactionButton'),
        placeholder: 'Pilih BArang',
        allowClear: true,
    })
}


const getInitData = () => {
    transaction.DataTable({
        processing: true,
        serverSide: true,
        ajax: `${BASE_URL}/api/transaction-data`,
        columns: [
            {
                "orderable": false,
                "searchable": false,
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'item', name: 'item'},
            {data: 'quantity', name: 'quantity'},
            {
                data: 'transaction_date', 
                name: 'transaction_date',
                render: function(data, type, row) {
                    return moment(data).format('D MMMM YYYY');
                }
            },
            {data: 'aksi', name: 'aksi'},
        ]
    });
}

$(function () {
    getInitData()
})

const resetForm = () => formConfig.fields.forEach(({id}) => $(`#${id}`).val(''))

const reloadDatatable = table => table.DataTable().ajax.reload(null, false);

$(function () {
    addButton.on('click', function () {
        modalTitle.text('Tambah Transaksi')
        submitButton.text('Tambah')
        resetForm()
        $('#addTransactionButton').modal('show');
        getCategory();
    })

    $('#addTransactionButton').on('hidden.bs.modal', function () {
        resetForm();
        $(this).find('.invalid-feedback').text('');
    });
})

submitButton.on('click', function () {
    const id = $('#id').val()
    console.log(id);
    $(this).text().toLowerCase() === "ubah" ? update(id) : store()
})

const dataForm = () => {
    return {
        item_id: $('#item_id').val(),
        quantity: $('#quantity').val(),
        transaction_date: $('#transaction_date').val(),
    };
}

const store = () => {
    $.ajax({
        url: transactionUrl,
        method: 'POST',
        dataType: 'json',
        data: dataForm(),
        success: res => {
            $('#addTransactionButton').modal('hide');
            resetForm();
            toastr.success(res.message, 'Success');
            reloadDatatable(transaction);
        },
        error: ({responseJSON}) => {
            handleError(responseJSON);
        }
    });
}

const handleError = (responseJSON) => {
    const {errors} = responseJSON
    formConfig.fields.forEach(({id}) => {
        if (!errors.hasOwnProperty(id)) {
            $('#' + id).removeClass('is-invalid')
        } else if ($(`#${id}`).hasClass('list-item')) {
            getCategory()
            $(`#${id}`).addClass("is-invalid").next().next().text(errors[id][0]);
        } else {
            $(`#${id}`).addClass("is-invalid").next().text(errors[id][0]);
        }
    })
}


$(document).on('click', '.btn-edit', function () {
    const deviceId = $(this).data('id')
    $.ajax({
        url: `${transactionUrl}/${deviceId}`,
        method: 'GET',
        dataType: 'json',
        success: res => {
            $('#id').val(res.id)
            submitButton.text('Ubah')
            modalTitle.text('Ubah Transaksi')
            formConfig.fields.forEach(({id}) => {
                if (id === 'category_id') {
                    $(`#${id}`).select2({
                        dropdownParent: $("#addTransactionButton"),
                        placeholder: "Pilih Barang",
                    }).val(res?.[id]).trigger('change')
                } else {
                    $(`#${id}`).val(res?.[id]);
                }
            })
            $('#addTransactionButton').modal('show');
        },
        error: err => {
            console.log(err)
        }
    })
})


const update = id => {
    $.ajax({
        url: `${transactionUrl}/${id}`,
        method: 'PUT',
        dataType: 'json',
        data: dataForm(),
        success: res => {
            $('#addTransactionButton').modal('hide');
            resetForm()
            toastr.success(res.message, 'Success')
            reloadDatatable(transaction)
        },
        error: ({responseJSON}) => {
            handleError(responseJSON)
        }
    })
}

$(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');

    Swal.fire({
        title: 'Anda Yakin?',
        text: "Data yang dihapus tidak bisa dikembalikan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Tidak',
        customClass: {
            confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
            cancelButton: 'btn btn-label-secondary waves-effect'
        },
        buttonsStyling: false
    }).then(result => {
        if (result.value) {
            $.ajax({
                url: `${transactionUrl}/${id}`,
                method: 'DELETE',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: res => {
                    toastr.success(res.message, 'Success');
                    reloadDatatable(transaction);
                },
                error: err => {
                        toastr.error('Gagal menghapus data. Silahkan coba lagi.', 'Error');
                }
            });
        }
    });
});
