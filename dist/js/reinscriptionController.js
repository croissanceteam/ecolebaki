app.controller('ViewPupilsCtrl', function ($scope, $http) {
    // alert(document.querySelector('#lbl_year').innerHTML);
    $http.get('listyears').then(function (response) {

        $scope.college_year = response.data.splice(1)[0].year;
        console.log($scope.college_year);

        $(document).ready(function () {
            console.log('222');

            

            var table = $('#dataTables-example').DataTable({
                ajax: {
                    url: 'pupilstoreenrol',
                    dataSrc: '',
                },

                responsive: 'true',
                columns: [

                    {"data": "matricule"},
                    {"data": "name_pupil"},
                    {"data": "gender"},
                    {"data": "level"},
                    {"data": "section"}
                ],
                "language": {
                    "sProcessing": "Traitement en cours...",
                    "sSearch": "Rechercher&nbsp;:",
                    "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                    "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                    "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    "sInfoPostFix": "",
                    "sLoadingRecords": "Chargement en cours...",
                    "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                    "oPaginate": {
                        "sFirst": "Premier",
                        "sPrevious": "Pr&eacute;c&eacute;dent",
                        "sNext": "Suivant",
                        "sLast": "Dernier"
                    },
                    "oAria": {
                        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                    }
                }
            });




            $('#dataTables-example tbody').on('click', 'tr', function (e) {
                var data = table.data();
                var index = e.target._DT_CellIndex.row;
                //console.log('Data: ',data[index]);

                document.querySelector('#btn_date_after').click();
                document.querySelector('#reinscription_form').reset();
                document.querySelector('#LabelName').innerHTML = data[index].name_pupil;
                document.querySelector('#mat_pupil').value = data[index].matricule;
                document.querySelector('#name_pupil').value = data[index].name_pupil;
                document.querySelector('#section').value = data[index].section;
                document.querySelector('#level').value = data[index].level == 1 ? data[index].level + 'ère' : data[index].level + 'ème';
                var btnSubmit = document.querySelector("#submitPayment");
                var fieldAmount = document.querySelector("#amount");
                var checkbox  = document.querySelector("#pass_switcher");
                var checkbox2  = $("#pass_switcher");
                
                if(data[index].level == 6 && data[index].section == 'PRIMAIRE'){
                    document.querySelector('#new_section').value = 'PRIMAIRE';
                    document.querySelector('#new_level').value = '6ème';
                    
                    checkbox.checked = false;
                    checkbox.setAttribute("disabled","disabled");
                    $("#response").html("L'élève double");
                }else{
                    
                    checkbox.checked = true;
                    checkbox.removeAttribute("disabled");
                    $("#response").html("L'élève passe");

                  if(data[index].level == 3 && data[index].section == 'MATERNELLE'){
                      document.querySelector('#new_section').value = 'PRIMAIRE';
                      document.querySelector('#new_level').value = '1ère';
                  }else{
                    document.querySelector('#new_section').value = data[index].section;
                    document.querySelector('#new_level').value = (parseInt(data[index].level) + 1) + 'ème';
                  }

                }


            });


            


        });//end of document ready

        document.querySelector('#loader').style = "display:none";
        document.querySelector('#tableView').style = "display:normal";
    }, function (error) {
        console.error(error)
    });

    $scope.requestHttp = function (url, method, callback) {
        if (method == 'GET') {
            $http.get(url).then(function (response) {
                callback(response);
            }, function (error) {
                callback(response);
            });
        } else {

        }
    }

    $('#reinscription_form').on('submit', function (e) {
        e.preventDefault();
        var section = $('#section').val();
        var level = $('#level').val();
        var amount = $('#amount').val();
        var mydata = $('#reinscription_form').serialize();
        // var diff = amount/amount;
        console.log('Un nombre ? ',/[1-9]+/.test(amount));
        if (section == "-----" || level == "-----" ) {
            $('#error_msg').html("Veuillez renseigner tous les champs correspondant.");

        }else{
            $('#error_msg').html("");
            $('#reinscription_form')[0].reset();
            $.ajax({
                type: 'POST',
                url: 'reenrol',
                data: mydata,
                success: function (result) {
                    console.log("Success result :",result);
                    document.querySelector('#btn_date_after').click();

                    if (result == 1) {
                        $('#success_alert').html("La réinscription a reussi!");
                        document.querySelector('#success_alert').style = "display:normal";
                        document.querySelector("#invoice").click();
                        //window.location.href = "invoice";
                        //window.open("http://localhost/~jonathan/ecolebaki2/invoice");
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        $('#danger_alert').html("La réinscription a échoué!");
                        document.querySelector('#danger_alert').style = "display:normal";
                        setTimeout(function () {
                            document.getElementById('danger_alert').style = "display:none";
                        }, 2000);
                    }

                },
                error: function (error) {
                    console.log('Error result : ',error);
                    $('#danger_alert').html("L'opération n'a pas abouti!");
                    document.querySelector('#danger_alert').style = "display:normal";
                    setTimeout(function () {
                        document.getElementById('danger_alert').style = "display:none";
                    }, 2000);
                }

            });
        }
        return false;
    });

});
