$('#change-password-form').on('submit',function(e){
    e.preventDefault();

    alert($('#actual-password').val());
});
