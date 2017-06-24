/**
 * Toggles the submit button availability based on required form inputs
 */
function toggleSubmitButton() {
    var name    = $('#contact-form-name').val();
    var email   = $('#contact-form-email').val();
    var message = $('#contact-form-message').val();
    if (name != '' && email != '' && message != '') {
        $('#contact-form-submit').prop('disabled', false);
    } else {
        $('#contact-form-submit').prop('disabled', true);
    }
}

/**
 * Handles submission of the contact form through ajax. On successful response, inspects the returned data and displays
 * appropriate alert to the user. If user input validation fails, the resulting error messages are displayed in a similar alert
 * box to the user. Upon successful form submission, the form is cleared.
 * @param e
 */
function submitContactForm(e) {
    e.preventDefault();
    var name = $('#contact-form-name').val();
    var email = $('#contact-form-email').val();
    var message = $('#contact-form-message').val();
    var phone = $('#contact-form-phone').val();
    var data = {};
    data.name = name;
    data.email = email;
    data.message = message;
    data.phone = phone;
    var jsonData = JSON.stringify(data);
    $.ajax({
        url: '/ajax-contact-form',
        method: 'POST',
        contentType: 'application/json',
        dataType: 'json',
        data: jsonData
    }).success( function(result) {
        console.log(result);
        if (result.status == 200) {
            swal(
                'Hooray!',
                'Thanks for contacting Guy Smiley!',
                'success'
            );
            clearContactForm(false);
        } else {
            swal(
                'Oops...',
                'Something went wrong, let\'s have you try that again',
                'error'
            );
        }
    }).error( function(result) {
        var errors = [];
        $.each(result.responseJSON, function( index, value) {
            errors.push(value[0]);
        });
        var errorHtmlList = '<ul>';
        $.each(errors, function( index, value ) {
            errorHtmlList += '<li>' + value + '</li>';
        });
        errorHtmlList += '</ul>';
        swal({
            title: 'Fix all the things!',
            type: 'info',
            html: errorHtmlList
        });
    });



}

/**
 * Clears the contact form and displays an alert to notify the user. Method can be called with a boolean with a false
 * value supressing the alert message.
 * @param alert
 */
function clearContactForm(alert) {
    $('#contact-form-name').val('');
    $('#contact-form-email').val('');
    $('#contact-form-phone').val('');
    $('#contact-form-message').val('');
    if (alert == true) {
        swal(
            'Boom!',
            'You cleared the form!',
            'error'
        );
    }
}

/**
 * Standard form event binding as well as setup for AJAX calls to utilize the CSRF token held in a meta tag.
 * Issues an initial toggleSubmitButton call to disable it immediately.
 */
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
    });
    $('#contact-form-submit').on('click', function(e) { submitContactForm(e)});
    $('#contact-form-clear').on('click', function(e) { clearContactForm(true) });
    $('form :input').on('keyup', function() { toggleSubmitButton() });
    toggleSubmitButton();
});

