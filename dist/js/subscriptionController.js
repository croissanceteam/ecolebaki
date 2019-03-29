app.controller('SubcriptionCtrl',function($scope,$http){

  $scope.addPupil = function () {
    var mydata = $('#add-pupil-form').serialize();
    // console.log('New pupil data :',mydata);
    var first_term = $('#first_term').text();
    if($('#name').val() == "" || $('#sex').val() == "" || $('#town').val() == "" || $('#address').val() == "" || $('#born_town').val() == "" || $('#birthday').val() == "" || $('#section').val() == "" || $('#level').val() == "" || $('#amount').val() == "" || $('#amount').val() > first_term)
    {
      //might be left empty that way
    }else{
      console.log('Form data :',mydata);
      $.ajax({
        type: 'POST',
        url: 'addpupil',
        data: mydata,
        success: function (result){
          console.log("result ",result);

          if (result == 1) {
              alertify.set({ delay: 1500 });
              alertify.success("L'inscription a réussi!");
              $('#add-pupil-form')[0].reset();

              window.location.href = "invoice";
              //window.open("http://localhost/~jonathan/ecolebaki2/invoice");
              setTimeout(function () {
                  window.location.reload();
              }, 2000);
          } else {
              // $('#danger_alert').html("L'inscription a échoué!");
              alertify.error("L'inscription a echoué!");
          }
        },
        error: function (){
          alertify.error("L'opération n'a pas abouti!");
        }
      });
    }

  }


  })
