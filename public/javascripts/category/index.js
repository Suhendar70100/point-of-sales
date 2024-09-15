const category = $('.dataTable')
const categoryUrl = `${BASE_URL}/api/category`
const addButton = $('#buttonAdd')
const modalTitle = $('.title')
const submitButton = $('#submit-button')


const formConfig = {
    fields: [
        {
            id: 'name',
            name: 'Nama Kategori'
        },
    ]
}


const getInitData = () => {
    category.DataTable({
        processing: true,
        serverSide: true,
        ajax: `${BASE_URL}/api/category-data`,
        columns: [
            {
                "orderable": false,
                "searchable": false,
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'name', name: 'name'},
            {data: 'aksi', name: 'aksi'},
        ]
    });
}

$(function () {
    getInitData()
})

const resetForm = () => formConfig.fields.forEach(({id}) => $(`#${id}`).val(''))

$(function () {
    addButton.on('click', function () {
        modalTitle.text('Tambah Kategori')
        submitButton.text('Tambah')
        resetForm()
        $('#addCategoryButton').modal('show');
    })

    $('#addCategoryButton').on('hidden.bs.modal', function () {
        resetForm();
        $(this).find('.invalid-feedback').text('');
    });
})

submitButton.on('click', function () {
    const id = $('#id').val()
    $(this).text().toLowerCase() === "ubah" ? update(id) : store()
})

const store = () => {
    $.ajax({
        url: categoryUrl,
        method: 'POST',
        dataType: 'json',
        data: dataForm(),
        success: res => {
            $('#addCategoryButton').modal('hide');
            resetForm();
            toastr.success(res.message, 'Success');
            reloadDatatable(category);
        },
        error: ({responseJSON}) => {
            handleError(responseJSON);
        }
    });
}

const update = id => {
    $.ajax({
        url: `${categoryUrl}/${id}`,
        method: 'PUT',
        dataType: 'json',
        data: dataForm(),
        success: res => {
            $('#addCategoryButton').modal('hide');
            resetForm()
            toastr.success(res.message, 'Success')
            reloadDatatable(category)
        },
        error: ({responseJSON}) => {
            handleError(responseJSON)
        }
    })
}

const dataForm = () => {
    return {
        name: $('#name').val(),
    };
}

const reloadDatatable = table => table.DataTable().ajax.reload(null, false);

const handleError = (responseJSON) => {
    const { errors } = responseJSON;
    formConfig.fields.forEach(({ id, name }) => {
        if (errors.hasOwnProperty(id)) {
            $(`#${id}`).addClass("is-invalid");
            $(`#${id}`).next('.invalid-feedback').text(errors[id][0]);
        } else {
            $(`#${id}`).removeClass('is-invalid').next('.invalid-feedback').text('');
        }
    });
}

$(document).on('click', '.btn-edit', function () {
    const gardenId = $(this).data('id')
    $.ajax({
        url: `${categoryUrl}/${gardenId}`,
        method: 'GET',
        dataType: 'json',
        success: res => {
            $('#id').val(res.id)
            submitButton.text('Ubah')
            modalTitle.text('Ubah Kategori')
            formConfig.fields.forEach(({id}) => {
                    $(`#${id}`).val(res?.[id]);
            })
            $('#addCategoryButton').modal('show');
        },
        error: err => {
            console.log(err)
        }
    })
})


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
                url: `${categoryUrl}/${id}`,
                method: 'DELETE',
                dataType: 'JSON',
                success: res => {
                    toastr.success(res.message, 'Success');
                    reloadDatatable(category);
                },
                error: err => {
                        toastr.error('Gagal menghapus data. Silahkan coba lagi.', 'Error');
                }
            });
        }
    });
});
