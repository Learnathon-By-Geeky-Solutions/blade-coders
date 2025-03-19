'use strict';

// Toast function using SweetAlert2
const toast = (
    title,
    text,
    icon,
    showCancelButton = false,
    callback = () => {},
    confirmButtonText = 'OK',
    cancelButtonText = 'Cancel'
) => {
    Swal.fire({
        title,
        text,
        icon,
        showCancelButton,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText,
        cancelButtonText,
    }).then(callback);
};

// Reset form fields and remove errors
const resetForm = (formSelector) => {
    const form = $(formSelector);
    form.find('img').remove();
    form.trigger('reset').find('.error').remove();
};

// Show modal and set title
const showModal = (modalSelector, modal, title = '') => {
    if (title) $(modalSelector).find('.modal-title').text(title);
    modal.show();
};

// Hide modal
const hideModal = (modal) => {
    modal.hide();
};

// Populate form fields dynamically
const populateForm = (formSelector, data) => {
    $.each(data, (key, value) => {
        const field = $(formSelector).find(`[name="${key}"], #${key}`);

        if (field.is(':checkbox, :radio')) {
            field.prop('checked', value);
        } else if (field.is(':file')) {
            field.attr('required', false);
            field.parent().find('img').remove();
            if (value) {
                field
                    .parent()
                    .append(`<img style="margin: 5px 0" src="${value.path}" alt="${key}" width="34" height="34">`);
            }
        } else if (field.is('select')) {
            // field.val(Array.isArray(value) ? value : [value]).trigger('change');

            field.find('option').each(function () {
                if (typeof value === 'object') {
                    if (value[$(this).val()]) {
                        $(this).attr('selected', true);
                    }
                }
            });
        } else {
            field.val(value);
        }
    });
};

// Check if any file is uploaded in FormData
const hasFileUploaded = (formData) => {
    for (const value of formData.values()) {
        if (value instanceof File && value.size > 0) return true;
    }
    return false;
};

// Handle form submission (Create or Update)
const submitForm = (formSelector, getRoute, getMethod, successCallback = () => {}, errorCallback = () => {}) => {
    $(formSelector)
        .off('submit')
        .on('submit', function (e) {
            e.preventDefault();

            let url = getRoute();
            let method = getMethod().toLowerCase();
            let formData = new FormData(this);
            let isFileUpload = hasFileUploaded(formData);
            let data = isFileUpload ? formData : $(this).serialize();

            if (method === 'put' && isFileUpload) {
                method = 'post';
                data.append('_method', 'put');
            }

            sendRequest(method, url, data, successCallback, errorCallback, isFileUpload);
        });
};

// Handle API requests via AJAX
const sendRequest = (method, url, data, successCallback, errorCallback, isFileUpload = false) => {
    let ajaxConfig = {
        url: url,
        type: method,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json',
        },
        data: data,
        success: successCallback,
        error: errorCallback,
    };

    if (isFileUpload) {
        ajaxConfig.processData = false;
        ajaxConfig.contentType = false;
    }

    $.ajax(ajaxConfig);
};

function transformStringForValidation(str) {
    return str
        .split('.')
        .map((item, index) => (index === 0 ? item : `[${item}]`))
        .join('');
}

// Display validation errors
const handleValidationError = (errors) => {
    $('.error').remove();
    $.each(errors, (field, messages) => {
        field = transformStringForValidation(field);

        $(`[name="${field}"]`).after(`<span class="error">${messages[0]}</span>`);
    });
};

// Initialize Quill editor
const quillEditor = (editorSelector, hiddenInputSelector) => {
    const quill = new Quill(editorSelector, {
        placeholder: 'Type something here',
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote'],
                ['link', 'image', 'video'],
                [{ header: 1 }, { header: 2 }],
                [{ list: 'ordered' }, { list: 'bullet' }, { list: 'check' }],
                [{ indent: '-1' }, { indent: '+1' }],
                [{ size: ['small', false, 'large', 'huge'] }],
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                [{ color: [] }, { background: [] }],
                [{ font: [] }],
                [{ align: [] }],
                ['clean'],
            ],
        },
    });

    quill.on('text-change', () => {
        $(hiddenInputSelector).val(quill.root.innerHTML);
    });
};

// Initialize select2 with optional configuration
const select = (selector, config = {}) => {
    $(selector).select2({
        placeholder: 'Select an option',
        ...config,
    });
};
