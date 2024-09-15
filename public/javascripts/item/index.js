const item = $('.dataTable')
const itemUrl = `${BASE_URL}/api/item`
const addButton = $('#buttonAdd')
const modalTitle = $('.title')
const submitButton = $('#submit-button')
const listCategory = $('.list-category')


const formConfig = {
    fields: [
        {
            id: 'name',
            name: 'Nama Barang'
        },
        {
            id: 'category_id',
            name: 'Kategory'
        }, 
        {
            id: 'stock',
            name: 'Stok'
        },
    ]
}

const getCategory = () => {
    listCategory.select2({
        dropdownParent: $('#addItemButton'),
        placeholder: 'Pilih Kategori',
        allowClear: true,
    })
}


const getInitData = () => {
    item.DataTable({
        processing: true,
        serverSide: true,
        ajax: `${BASE_URL}/api/item-data`,
        columns: [
            {
                "orderable": false,
                "searchable": false,
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'name', name: 'name'},
            {data: 'category', name: 'category'},
            {data: 'stock', name: 'stock'},
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
        modalTitle.text('Tambah Barang')
        submitButton.text('Tambah')
        resetForm()
        $('#addItemButton').modal('show');
        getCategory();
    })

    $('#addItemButton').on('hidden.bs.modal', function () {
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
        name: $('#name').val(),
        category_id: $('#category_id').val(),
        stock: $('#stock').val(),
    };
}

const store = () => {
    $.ajax({
        url: itemUrl,
        method: 'POST',
        dataType: 'json',
        data: dataForm(),
        success: res => {
            $('#addItemButton').modal('hide');
            resetForm();
            toastr.success(res.message, 'Success');
            reloadDatatable(item);
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
        } else if ($(`#${id}`).hasClass('list-category')) {
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
        url: `${itemUrl}/${deviceId}`,
        method: 'GET',
        dataType: 'json',
        success: res => {
            $('#id').val(res.id)
            submitButton.text('Ubah')
            modalTitle.text('Ubah Barang')
            formConfig.fields.forEach(({id}) => {
                if (id === 'category_id') {
                    $(`#${id}`).select2({
                        dropdownParent: $("#addItemButton"),
                        placeholder: "Pilih Kategory",
                    }).val(res?.[id]).trigger('change')
                } else {
                    $(`#${id}`).val(res?.[id]);
                }
            })
            $('#addItemButton').modal('show');
        },
        error: err => {
            console.log(err)
        }
    })
})


const update = id => {
    $.ajax({
        url: `${itemUrl}/${id}`,
        method: 'PUT',
        dataType: 'json',
        data: dataForm(),
        success: res => {
            $('#addItemButton').modal('hide');
            resetForm()
            toastr.success(res.message, 'Success')
            reloadDatatable(item)
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
                url: `${itemUrl}/${id}`,
                method: 'DELETE',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: res => {
                    toastr.success(res.message, 'Success');
                    reloadDatatable(item);
                },
                error: err => {
                        toastr.error('Gagal menghapus data. Silahkan coba lagi.', 'Error');
                }
            });
        }
    });
});
