$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function debounce(func, delay) {
    let timer;
    return function() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(this, arguments);
        }, delay);
    };
}

const user = (function (){
    let module = {};

    let resultAjax = function (url, method = 'POST', data = null){
        return $.ajax({
            url: url,
            data: data,
            method: method,
            typeData: 'json',
            processData: false,
            contentType: false,
            async: false
        });
    }

    let confirm = function (){
        return Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        });
    }

    let successNotifi = function (){
        Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
        )
    }
    let errorNotifi = function (){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        })
    }
    let renderError = function (errors){
        // $('.is-invalid').removeClass('is-invalid');
        for (let key in errors){
            let inputError = $('#' + key);
            let elementError = $('#' + key + '-error');
            inputError.addClass('is-invalid');
            elementError.text(errors[key]);
        }
        const firstError = $('.is-invalid').first();
        if (firstError) {
            firstError.focus();
        }
    }

    let removeErrors = function (data){
        for (let key of data.keys()) {
            let inputError = $('#' + key);
            let elementError = $('#' + key + '-error');
            inputError.removeClass('is-invalid');
            elementError.text('');
        }
    }

    module.openModal = function (element){
        let url = $(element).attr('href');
        $.get(url, function (response) {
            $('#modal').html(response.html);
            $('#modal-form').modal('show');
        }, 'json');
    };

    //co loi nho fix day
    module.submit = function (element){
        let url = element.getAttribute('action');
        let data = new FormData(element);
        resultAjax(url, 'POST', data).done(function (response){
            $('#modal').html(response.html);
            $('#table').html(response.table);
            $('body').find('.modal-backdrop').remove()
            $('#modal-form').modal('show');
            toastr.success(response.message);
        }).fail(function (errors){
            let errorsObj = JSON.parse(errors.responseText).errors;
            removeErrors(data);
            renderError(errorsObj);
        });
    }

    module.delete = function (element){
        let url = $(element).attr('href');
        confirm().then((result) => {
            if (result.isConfirmed){
                resultAjax(url, 'DELETE').done(function (response){
                    $('#table').html(response.table);
                    successNotifi();
                }).fail(function (error){
                    errorNotifi();
                });
            }
        })
    }

    module.search = function (element){
        let url = element.attr('action');
        let data = element.serializeArray();
        $.post(url, data, function (response){
            let table = $('#table');
            table.html(response.table);
        }, 'json');
    }

    module.loadIMG = function (element){
        let file = $(element)[0].files[0];
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            const url = URL.createObjectURL(file);
            const img = $('#image-preview');
            img.attr('src', url)
        };
    }

    return module;

})(window.jQuery, window, document);

$(document).ready(function (){
    $('#name-txt').on('keyup', debounce(function() {
        user.search($('#form-search'));
    }, 500));

    $('#price-to').on('keyup', debounce(function() {
        user.search($('#form-search'));
    }, 500));

    $('#price-from').on('keyup', debounce(function() {
        user.search($('#form-search'));
    }, 500));

    $('#category').on('change', debounce(function() {
        user.search($('#form-search'));
    }, 500));
})

$(document).on('click', '#submit-form', function (){
    user.submit($('#form-data')[0]);
});

$(document).on('click', '.btn-delete-item', function (event){
    user.delete($(this));
    event.preventDefault();
});

$(document).on('click', '.btn-open-modal', function (event){
    user.openModal($(this));
    event.preventDefault();
});

$(document).on('change', '.input-image', function (event){
    user.loadIMG($(this));
});
