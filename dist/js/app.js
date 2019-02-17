$('#newPassModal').on('shown.bs.modal', function () {
  $('#actual-password').trigger('focus');
})
$('#change-password-form').on('submit',function(e){
    e.preventDefault();

    var newPass = $('#new-password').val();
    var againPass = $('#new-password-again').val();
    var mydata = $('#change-password-form').serialize();

    if(newPass !== againPass){
      alert('Vous avez mal retapé le nouveau mot de passe. Veuillez réessayer.');
      $('#new-password-again').trigger('focus');
    }else{
      // alert('Ok');
      $.ajax({
       url : 'chactpwd',
       type : 'POST',
       data : mydata,
       success : function(resultat, statut){
          console.log('Resultat success :',resultat);
          console.log('Statut success : ',statut);
          if (resultat == 1){
            alert("Votre mot de passe a été changé avec succès. Nous vous demandons de vous reconnecter avec le nouveau mot  de passe.");
            document.querySelector('#lungwa').click();
          }else if (resultat == 4){
            alert("Vous avez épuisé vos tentatives.");
            document.querySelector('#lungwa').click();
          }else if(resultat == 0){
            alert("L'opération a échoué.");
            $('#newPassModal').modal('hide'); 
          }

       },
       error : function(resultat, statut, erreur){
         console.log('Resultat error :',resultat);
         console.log('Erreur :',erreur);
         console.log('Statut error : ',statut);
       }

    });

  }
});
