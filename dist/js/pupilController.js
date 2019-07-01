app.controller('PupilsCtrl',function($scope,$http){
   // alert(document.querySelector('#lbl_year').innerHTML);
    $http.get('listyears').then(function(response){
        console.log(response.data);
        $scope.list_years=response.data.splice(1);
        $scope.activeTab=response.data[0];
        console.log($scope.list_years);
        $(document).ready(function() {

            var table=$('#dataTables-example').DataTable({
                ajax: {
                    url: "listpupils",
                    dataSrc:'',

                },

                responsive:'true',
                columns:[
                    { "data": "id" },
                    { "data": "matricule" },
                    { "data": "fullname" },
                    { "data": "gender" },
                    { "data": "level" },
                    { "data":"section"}
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

            if($('#userpriority').html() != 'admin'){
              $('#pupilname').attr('disabled','disabled');
              $('#gender').attr('disabled','disabled');
              $('#address').attr('disabled','disabled');
              $('#town').attr('disabled','disabled');
              $('#born_town').attr('disabled','disabled');
              $('#birthday').attr('disabled','disabled');
              $('#phone').attr('disabled','disabled');
              $('#section').attr('disabled','disabled');
              $('#level').attr('disabled','disabled');
              document.querySelector('#blockImg').style.display = 'none';
              $('#pupil-panel').html("Informations de l'élève");
            }

            $('#dataTables-example tbody').on('click', 'tr', function (e) {
                var data = table.data();
                var index=e.target._DT_CellIndex.row;
                console.log('Infos du tableau :',data);
                console.log('Infos de l\'eleve :',data[index]);
                // alert( 'You clicked on '+data[index].id+'\'s row' );

                var pupil = data[index];
                $('#pupilmatr').val(pupil.matricule);
                $('#pupilname').val(pupil.fullname);
                $('#gender').val(pupil.gender);
                $('#address').val(pupil.address);
                $('#town').val(pupil.town);
                $('#birthday').val(pupil.birthday);
                $('#born_town').val(pupil.born_town);
                $('#phone').val(pupil.phone);
                $('#section').val(pupil.section);
                document.querySelector('#img').src="images/" + pupil.picture + "?jpinshi="+Math.random();
                // $('#level').val(pupil._CODE_CLASS);
                var level = document.querySelector('#level');
                $('#level').empty();
                if (pupil.section == "MATERNELLE") {
                    for (var index = 1; index <= 3; index++) {
                        var option = document.createElement('option');
                        option.text = index;
                        level.add(option, index);
                    }
                } else {
                    for (var index = 1; index <= 6; index++) {
                        var option = document.createElement('option');
                        option.text = index;
                        level.add(option, index);
                    }
                }
                $('#level').val(pupil.level);

                document.querySelector('#viewPupil').click();

               // var town=data[index].townFrom;
               // town=town.toString().trim().substring(0,1)+town.toString().trim().substring(1).toLowerCase();
               // document.querySelector('#town').value=town;
              // alert(data[index].phone);
                // document.querySelector('#viewPupil').click();


        } );

        });

     document.querySelector('#loader').style="display:none";
     document.querySelector('#tableView').style="display:normal";
    },function(error){
console.error(error)
    });

    var table=undefined;
    var iTable;
    $scope.get_list_pupils=function(year,index){


        var title_navbar=document.querySelector('#title_navbar');
        title_navbar=title_navbar.innerHTML.split('|')[1].trim();
        // alert(title_navbar);
        // var url_get_list='listpupils/'+title_navbar+'/SUB/'+year;
        var url_get_list='listpupils/'+title_navbar+'/'+year;
        console.log('URL 5:',url_get_list);
        $(document).ready(function() {

            if (table==undefined)
                {
                    iTable=index;
                    $scope.toFillTable(index,url_get_list);

        }else{
            if (index==iTable) {
                table.destroy();
                $scope.toFillTable(index,url_get_list);

            } else {

            }
        }

        });
    }

    $scope.updatePupil = function () {
        var mydata = $('#update-form').serialize();
        // console.log($('#picture').val());
        console.log('Pupil update data :',mydata);
        // document.querySelector('#viewPupil').click();
        var message = "Vous êtes sur le point d'enregistrer les modifications. Confirmez-vous cette opération ?";
        alertify.set({ labels: {
            ok     : "Oui",
            cancel : "Non"
        } });
        alertify.confirm(message, function (e) {
            if (e) {
                // user clicked "ok"
                $.ajax({
                  type: 'POST',
                  url: 'updatepupil',
                  data: mydata,
                  success: function (result){
                    console.log("result ",result);

                    if (result == 1) {
                        alertify.set({ delay: 1000 });
                        alertify.success("Les modifications ont été appliquées!");
                        $('#update-form')[0].reset();
                        // document.querySelector('#viewPupil').click();
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    }else if(result == 4){
                      alertify.log("Aucune modification n'a été apporté");
                    }else if(result == 6){
                      alertify.log("Vous n'êtes pas habilité à effectuer cette action.");
                    }else {
                      alertify.error("Les modifications n'ont pas pu être appliqué.");
                    }
                  },
                  error: function (){
                    alertify.error("L'opération n'a pas abouti!");
                  }
                });
            } else {
                // user clicked "cancel"
            }
            document.querySelector('#viewPupil').click();
        });
    }

    $scope.toFillTable=function(index,url){
        $http.get(url).then(function(response){
            console.log(response.data);
        },function(error){
            console.log(error)
        })
         table=$('#dataTables'+index).DataTable({
                ajax: {
                    url: url,
                    dataSrc:'',

                },

                responsive:'true',
                columns:[
                    { "data": "id" },
                    { "data": "matricule" },
                    { "data": "fullname" },
                    { "data": "gender" },
                    { "data": "level" },
                    {"data":"section"}
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


            $('#dataTables'+index+' tbody').on('click', 'tr', function (e) {
                var data = table.data();
                var index=e.target._DT_CellIndex.row;
                console.log('Data: ',data[index]);
               // alert( 'Year:'+year+"ID:"+data[index].id+'\'s row' );
                var cboLevel=document.querySelector('#cboLevel');
               for (var i =1 ;i <=6; i++) {
                    var option=document.createElement('option');
                    option.text=i;
                    cboLevel.add(option,i);


            }
               document.querySelector('#pupilname').value=data[index].name_pupil;
               document.querySelector('#sex').value=(data[index].gender.trim()=="Masculin"?"M":"F");

               document.querySelector('#LabelName').innerHTML=data[index].name_pupil;
               document.querySelector('#phone').value=data[index].phone;
               var town=data[index].townFrom;
               town=town.toString().trim().substring(0,1)+town.toString().trim().substring(1).toLowerCase();
               document.querySelector('#town').value=town;
              // alert(data[index].phone);
                document.querySelector('#viewPupil').click();
                document.querySelector('#address').value=data[index].adress;
                document.querySelector('#born_town').value=data[index].townBorn;
                document.querySelector('#birthday').value=data[index].datenaiss;
                document.querySelector('#section').value=data[index].section;


                cboLevel.value=data[index].level;


        });
    }

    $scope.requestHttp=function(url,method,callback){
        if (method=='GET') {
            $http.get(url).then(function(response){
                callback(response);
            },function(error){
                callback(response);
            });
        }else{

        }
    }


})
