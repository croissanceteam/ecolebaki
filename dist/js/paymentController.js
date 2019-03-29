app.controller('PaymentsCtrl', function ($scope, $http) {
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
                    {"data": "id"},
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
                document.querySelector('#toggle-payments-modal').click();
                $('.pupil-name').text(data[index].name_pupil);
                document.querySelector('#mat_pupil').value = data[index].matricule;
                document.querySelector('#name_pupil').value = data[index].name_pupil;
                document.querySelector('#level').value = data[index].level;
                document.querySelector('#section').value = data[index].section;
                document.querySelector('#anasco').value = (document.querySelector('#lbl_year').innerHTML).trim();
                document.querySelector('#add_payment_form').reset();
                //-----update form data----
                $('#pupil_matr').val(data[index].matricule);
                $('#pupil_name').val(data[index].name_pupil);
                $('#level2').val(data[index].level);
                $('#section2').val(data[index].section);
                $('#anasco2').val(($('#lbl_year').html()).trim());



                //------------------ I gotta get all payments of the current pupil ----------------
                // console.log("List pay: ",JSON.stringify(data[index].payinfo));
                console.log("List pay: ",data[index].payinfo);

                var tablePay = $('#dataTables-paiement').DataTable({
                    destroy: true,
                    aaData: data[index].payinfo,
                    responsive: true,
                    aoColumns: [
                        {"mDataProp": "id_pay"},
                        {"mDataProp": "term"},
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
                $('#dataTables-paiement').on('click','tr',function(e){
                  var dataPay = tablePay.data();
                  var i = e.target._DT_CellIndex.row;
                  console.log('You clicked on ' ,dataPay[i]);
                  $('.code-pay').text(dataPay[i].id_pay);
                  // $('#codeterm').val(dataPay[i].slice_pay);
                  var term = dataPay[i].term;
                  switch (term) {
                    case '1er Trimestre':
                      $('#codeterm').val('1TRIM');
                      break;
                    case '2eme Trimestre':
                      $('#codeterm').val('2TRIM');
                      break;
                    case '3eme Trimestre':
                      $('#codeterm').val('3TRIM');
                      break;
                    default:
                      break;
                  }
                  $scope.payPrerequis($('#codeterm').val());
                  $('#former_amount').val(dataPay[i].amount_payed);
                  $('#new_amount').val(dataPay[i].amount_payed);
                  $('#code_pay').val(dataPay[i].id_pay);
                  $('#updatePaymentsModal').modal('show');
                });
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
                {"data": "id"},
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

            document.querySelector('#toggle-payments-modal').click();
            // document.querySelector('#LabelName').innerHTML = data[index].name_pupil;
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
                    {"mDataProp": "term"},
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
      console.log($scope.termCode);
      $scope.payPrerequis($scope.termCode);
    }

    $scope.payPrerequis = function(term)
    {
      var matr = $('#mat_pupil').val();
      var year = $('#anasco').val();
      $('#error_msg').html("");

      var url = 'paymentprerequis/'+ matr + '/'+ term + '/' + year;
      $http.get(url).then(function (response) {
          // console.log('Balance : ',response.data);
          $scope.balance = response.data;
          console.log('Balance : ',$scope.balance);
          $('#amount').val(response.data);
      }, function (error) {
          console.log(error);
      });
    }



    $scope.submitPayment = function ()
    {

        // var matricule = $('#mat_pupil').val();
        var term = $('#term').val();
        var amount = $('#amount').val();
        var mydata = $('#add_payment_form').serialize();

        if(term == "" || amount == "" || amount == 0){
          //might left empty
        }else if ($('#mat_pupil').val() == '') {
            $('#error_msg').html("Le paiement ne peut pas s'effectuer");
        } else {
            var balance = parseInt($scope.balance,10);
            // console.log('Balance ',balance);
            // var diff = amount > balance;
            // console.log('Vrai ou faux ?',diff);
            if(amount > balance){
              if(balance == 0){
                $('#error_msg').html("L'élève a déjà soldé ce trimestre");
                // alertify.alert("L'élève a déjà soldé ce trimestre");
              }else{
                $('#error_msg').html("Le montant payé ne peut pas être supérieur au reste à payer pour ce trimestre, qui est de " + $('#currency').text() + ' ' + $scope.balance);
              }
            }else{
              $('#error_msg').html("");
              $('#add_payment_form')[0].reset();
              // $('#pupilPaymentsModal').modal('hide');
              document.querySelector('#toggle-payments-modal').click();
              var message = "<h3>Validez-vous ce paiement ?</h3><br><div style='text-align:left;font-size:16px'>Elève : "+ $('#name_pupil').val() +"<br>Matricule : "+ $('#mat_pupil').val() +
              "<br>Trimestre : "+ term +"<br>Montant : "+ amount +" "+ $('#currency').text() +"</div>";
              alertify.set({ labels: {
                  ok     : "Oui",
                  cancel : "Non"
              } });
              alertify.confirm(message, function (e) {
                  if (e) {
                      // user clicked "ok"
                      $.ajax({
                         type: 'POST',
                         url: 'addpayment',
                         data: mydata,
                         success: function (result) {
                             console.log("result ",result);

                             if (result == 1) {
                               alertify.set({ delay: 1000 });
                               alertify.success('Paiement effectué');
                               window.location.href = "invoice";
                                 //window.open("http://localhost/~jonathan/ecolebaki2/invoice");
                                 setTimeout(function () {
                                     window.location.reload();
                                 }, 2000);
                             } else {
                                 alertify.error("L'opération a échoué");
                             }

                         },
                         error: function () {
                             alertify.error("L'opération n'a pas abouti!");
                         }

                     });
                  } else {
                      // user clicked "cancel"
                  }
              });
            }
        }
        return false;
    }

    $scope.updatePayment = function()
    {
      console.log('Code term field ',$('#codeterm').val());
      // $scope.payPrerequis($('#codeterm').val());
      console.log('Balance at update',$scope.balance);
      var amount = $('#new_amount').val();
      var reason = $.trim($('#update_reason').val());
      var mydata = $('#update_payment_form').serialize();
      // var mydata = {'amount':amount,'reason':reason,'idpay':$('.code-pay').text()};
      console.log('Update form data : ',mydata);
      if(amount == "" || amount == 0 || reason == ""){
        //might left empty
      }else{
        var balance = parseInt($scope.balance,10);
        var formeramount = parseInt($('#former_amount').val(),10);
        var balance_recompute = balance + formeramount;
        console.log('Balance recompute ', balance_recompute);
        if(amount > balance_recompute){
          if(balance_recompute == 0){
            $('#error_msg2').html("L'élève a déjà soldé ce trimestre");
            // alertify.alert("L'élève a déjà soldé ce trimestre");
          }else{
            $('#error_msg2').html("Le montant payé ne peut pas être supérieur au reste à payer pour ce trimstre, qui est de " + $('#currency').text() + ' ' + balance_recompute);
            // alert("Le montant payé ne peut être supérieur au montant à payer pour cette tranche, qui est de " + $('#currency').text() + ' ' + balance_recompute);
          }
        }else if(amount == formeramount){
          $('#error_msg2').html("Aucune modification n'a été apporté!");
        }else{
          $('#error_msg2').html("");
          // $('#update_payment_form')[0].reset();
          $('#updatePaymentsModal').modal('hide');

          var message =
          "<h3>Validez-vous ce changement ?</h3><br><div style='text-align:left'><h4>Elève : " + $('#name_pupil').val() + "</h4><h4>Matricule : " + $('#mat_pupil').val() +
          "</h4><h4>Trimestre : "+ $('#codeterm').val() + "</h4>"+
          "<br><h4>Montant précedent : "+ $('#former_amount').val() +" "+ $('#currency').text() +"</h4>"+
          "<h4>Nouveau montant : "+ amount +" "+ $('#currency').text() +"</h4></div>";
          alertify.set({ labels: {
              ok     : "Oui",
              cancel : "Non"
          } });
          alertify.confirm(message, function (e) {
              if (e) {
                  // user clicked "ok"
                  $.ajax({
                      type: 'POST',
                      url: 'updatepayment',
                      data: mydata,
                      success: function (result) {
                          console.log("result update :",result);

                          if (result == 1) {
                              alertify.set({ delay: 1000 });
                              alertify.success('Le paiement a été modifié');
                              window.location.href = "invoice";
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                          } else {
                              alertify.error("L'opération a échoué!");
                          }
                      },
                      error: function () {
                          alertify.error("L'opération n'a pas abouti!");
                      }

                  });
              } else {
                  // user clicked "cancel"
              }
              document.querySelector('#toggle-payments-modal').click();
          });

        }
      }
      return false;
    }

    $scope.alert = function(type,message)
    {
      /*
          primary, secondary, success, danger, warning, info, light, dark
      */
      $('.alert-'+ type +' span').html(message);
      $('.alert-'+ type ).fadeIn(500);
      setTimeout(function () { $('.alert-'+ type).fadeOut(1000); }, 2500);
    }

    // function fillSlicesList() {
    //     $('#slice').empty();
    //     $.ajax({
    //         url: 'loadslices',
    //         data: 'getterms',
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
