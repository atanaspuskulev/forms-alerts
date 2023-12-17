jQuery(document).ready(function() {
    handleLoginForm();
    handleRegisterForm();
});

function handleLoginForm() {
    _handleForm(jQuery('#loginform'), 'Login attempts: ');
}

function handleRegisterForm() {
    _handleForm(jQuery('#registerform'), 'Register attempts: ');
}

function _handleForm(formObject, messagePrefix) {
    formObject.on('submit', function(event) {
        event.preventDefault();

        const formId = formObject.attr('id')
        const methodAction = `handle_${formId}`;

        console.log(methodAction);
        console.log(`#${formId} form reached.`);

        jQuery.ajax({
            url: FormsAlert.ajaxUrl,
            data: {
                'action': methodAction,
                'nonce' : FormsAlert.forms_alerts_ajax_nonce
            },
            success:function(data) {
                alert(`${messagePrefix} ${data}`);
                window.location.reload();
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
    });
}