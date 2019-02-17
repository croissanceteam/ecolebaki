app.controller('ViewPupilsCtrl', function ($scope, $http) {
    // alert(document.querySelector('#lbl_year').innerHTML);
    $http.get('listyears').then(function (response) {
        $scope.list_years = response.data.splice(1);
        $scope.activeTab = response.data[0];
        console.log($scope.list_years);
        $(document).ready(function () {

            var table = $('#dataTables-example').DataTable({
                ajax: {
                    url: "listpayments",
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

                $('#error_msg').html("");
                document.querySelector('#toggle-pupil-payments').click();
                document.querySelector('#LabelName').innerHTML = data[index].name_pupil;
                document.querySelector('#mat_pupil').value = data[index].matricule;
                document.querySelector('#name_pupil').value = data[index].name_pupil;
                document.querySelector('#level').value = data[index].level;
                document.querySelector('#section').value = data[index].section;
                document.querySelector('#anasco').value = (document.querySelector('#lbl_year').innerHTML).trim();
                document.querySelector('#add_payment_form').reset();



                //------------------ I gotta get all payments of the current pupil ----------------
                // console.log("List pay: ",JSON.stringify(data[index].payinfo));
                console.log("List pay: ",data[index].payinfo);

                var tablePay = $('#dataTables-paiement').DataTable({
                    destroy: true,
                    aaData: data[index].payinfo,
                    responsive: true,
                    aoColumns: [
                        {"mDataProp": "id_pay"},
                        {"mDataProp": "slice_pay"},
                        {"mDataProp": "fee_object"},
                        {"mDataProp": "amount_payed"},
                        {"mDataProp": "date_pay"}
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
                // alert( 'You clicked on '+data[index].id+'\'s row' );
            });
        });//end of document ready

        document.querySelector('#loader').style = "display:none";
        document.querySelector('#tableView').style = "display:normal";
    }, function (error) {
        console.error(error)
    });

    var table = undefined;
    var iTable;
    $scope.get_list_pupils = function (year, index) {

        document.querySelector('#anasco').value = year;
        // alert(year);
        // var title_navbar = document.querySelector('#title_navbar');
        // title_navbar = title_navbar.innerHTML.split('|')[1].trim();
        // alert(title_navbar);
        // var url_get_list = 'listpupils/' + title_navbar + '/SUB/' + year;
        // var url_get_list = 'listpayments/' + title_navbar + '/' + year;
        var url_get_list = 'listpayments/' + year;
        console.log('URL 1:', url_get_list);
        $(document).ready(function () {

            if (table == undefined)
            {
                iTable = index;
                $scope.toFillTable(index, url_get_list);

            } else {
                if (index == iTable) {
                    table.destroy();
                    $scope.toFillTable(index, url_get_list);

                } else {

                }
            }


        });
    }


    $scope.toFillTable = function (index, url) {
        $http.get(url).then(function (response) {
            console.log(url,response.data);
        }, function (error) {
            console.log(error)
        })

        table = $('#dataTables' + index).DataTable({
            ajax: {
                url: url,
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


        $('#dataTables' + index + ' tbody').on('click', 'tr', function (e) {
            var data = table.data();
            var index = e.target._DT_CellIndex.row;
            console.log('Data: ',data[index]);
            console.log("Last list pay: ",data[index].payinfo);

            document.querySelector('#toggle-pupil-payments').click();
            document.querySelector('#LabelName').innerHTML = data[index].name_pupil;
            document.querySelector('#mat_pupil').value = data[index].matricule;
            document.querySelector('#name_pupil').value = data[index].name_pupil;
            document.querySelector('#level').value = data[index].level;
            document.querySelector('#section').value = data[index].section;


            var tablePay = $('#dataTables-paiement').DataTable({
                destroy: true,
                aaData: data[index].payinfo,
                responsive: true,
                aoColumns: [
                    {"mDataProp": "id_pay"},
                    {"mDataProp": "slice_pay"},
                    {"mDataProp": "fee_object"},
                    {"mDataProp": "amount_payed"},
                    {"mDataProp": "date_pay"}
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

        });
    }

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

    $scope.newPayPrerequis = function()
    {
      var matr = $('#mat_pupil').val();
      var year = $('#anasco').val();
      $('#error_msg').html("");
      console.log($scope.sliceCode);
      var url = 'paymentprerequis/'+ matr + '/'+ $scope.sliceCode + '/' + year;
      $http.get(url).then(function (response) {
          // console.log('Balance : ',response.data);
          $scope.balance = response.data;
          console.log('Balance : ',$scope.balance);
          $('#amount').val(response.data);
      }, function (error) {
          console.log(error)
      })
    }



    $scope.submitPayment = function ()
    {

        // var matricule = $('#mat_pupil').val();
        var slice = $('#slice').val();
        var amount = $('#amount').val();
        var mydata = $('#add_payment_form').serialize();
        if (slice == "" && amount == "") {
            $('#error_msg').html("Veuillez renseigner le type de frais et le montant");
        } else if (slice == "") {
            $('#error_msg').html("Veuillez renseigner le type de frais");
        } else if (amount == "") {
            $('#error_msg').html("Veuillez renseigner le montant");
        } else if (amount == 0) {
            $('#error_msg').html("Le montant saisi est incorrect");
        } else if ($('#mat_pupil').val() == '') {
            $('#error_msg').html("Le paiement ne peut pas s'effectuer");
        } else {
            var balance = parseInt($scope.balance,10);
            // console.log(balance);
            // var diff = amount > balance;
            // console.log('Vrai ou faux ?',diff);
            if(amount > balance){
              if(balance == 0){
                $('#error_msg').html("L'élève a déjà soldé ce trimestre");
              }else{
                $('#error_msg').html("Le montant payé ne peut être supérieur au montant à payer pour cette tranche, qui est de " + $('#currency').text() + ' ' + $scope.balance);
              }
            }else{
              $('#error_msg').html("");
              $('#add_payment_form')[0].reset();
              // $('#pupilPaymentsModal').modal('hide');
              document.querySelector('#toggle-pupil-payments').click();
              document.getElementById("confirm-text").textContent = "Validez-vous ce paiement ?";
              document.getElementById("confirm-body").innerHTML =
              "<br><h4>Elève : " + $('#name_pupil').val() + "</h4><h4>Matricule : " + $('#mat_pupil').val() +
              "</h4><h4>Tranche : " + slice + "</h4><h4>Montant : " +
              amount + " " + $('#currency').text() + "</h4>";
              $( "#dialog-confirm" ).dialog({
                  resizable: false,
                  height: "auto",
                  width: 400,
                  modal: true,
                  buttons: {
                      "Oui": function() {
                          $(this).dialog( "close" );

                          $.ajax({
                              type: 'POST',
                              url: 'addpayment',
                              data: mydata,
                              success: function (result) {
                                  console.log("result");
                                  console.log(result);

                                  if (result == 1) {
                                      $('#success_alert').html("Paiement effectué!");
                                      document.querySelector('#success_alert').style = "display:normal";
                                      document.querySelector("#invoice").click();
                                      //window.location.href = "invoice";
                                      //window.open("http://localhost/~jonathan/ecolebaki2/invoice");
                                      setTimeout(function () {
                                          window.location.reload();
                                      }, 2000);
                                  } else {
                                      $('#danger_alert').html("L'opération a échoué!");
                                      document.querySelector('#danger_alert').style = "display:normal";
                                      setTimeout(function () {
                                          document.getElementById('danger_alert').style = "display:none";
                                      }, 2000);
                                  }

                              },
                              error: function () {
                                  $('#danger_alert').html("L'opération n'a pas abouti!");
                                  document.querySelector('#danger_alert').style = "display:normal";
                                  setTimeout(function () {
                                      document.getElementById('danger_alert').style = "display:none";
                                  }, 2000);
                              }

                          });
                      },
                      "Non": function() {
                          $(this).dialog( "close" );
                          console.log('Non');
                      }
                  }
              });

              // $.ajax({
              //     type: 'POST',
              //     url: 'addpayment',
              //     data: mydata,
              //     success: function (result) {
              //         console.log("result");
              //         console.log(result);
              //         document.querySelector('#toggle-pupil-payments').click();
              //
              //         if (result == 1) {
              //             $('#success_alert').html("Paiement effectué!");
              //             document.querySelector('#success_alert').style = "display:normal";
              //             document.querySelector("#invoice").click();
              //             //window.location.href = "invoice";
              //             //window.open("http://localhost/~jonathan/ecolebaki2/invoice");
              //             setTimeout(function () {
              //                 window.location.reload();
              //             }, 2000);
              //         } else {
              //             $('#danger_alert').html("L'opération a échoué!");
              //             document.querySelector('#danger_alert').style = "display:normal";
              //             setTimeout(function () {
              //                 document.getElementById('danger_alert').style = "display:none";
              //             }, 2000);
              //         }
              //
              //     },
              //     error: function () {
              //         $('#danger_alert').html("L'opération n'a pas abouti!");
              //         document.querySelector('#danger_alert').style = "display:normal";
              //         setTimeout(function () {
              //             document.getElementById('danger_alert').style = "display:none";
              //         }, 2000);
              //     }
              //
              // });
            }
        }
        return false;
    }



    // function fillSlicesList() {
    //     $('#slice').empty();
    //     $.ajax({
    //         url: 'loadslices',
    //         data: 'getslices',
    //         dataType: 'json',
    //         success: function (json) {
    //             $('#slice').append('<option value="">-------</option>');
    //             $.each(json, function (index, value) {
    //                 $('#slice').append('<option value="' + index + '" label="' + value + '">' + value + '</option>');
    //             });
    //         }
    //     });
    // }
    // fillSlicesList();
    function showInvoice() {

    }
});
