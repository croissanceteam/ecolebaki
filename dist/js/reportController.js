app.controller('CtrlStudent', function (factoryStudent,$scope,$filter) {
    // alert(document.querySelector('#lbl_year').innerHTML);


    $(document).ready(function(){
        document.querySelector('#loader').style = "display:none";
        document.querySelector('#header').style = "display:normal";
        document.querySelector('#ctrl1').style = "display:normal";
        document.querySelector('#blockPaie').style = "display:normal";
        document.querySelector('#blockPrinter').style = "display:normal";
        document.querySelector('#buttonsPrint').style = "display:normal";

    });

    $scope.criteriaChanged = function(){
      console.log('Criteria changed');
      //alert('Criteria changed');
      document.querySelector('#preview').style.display = "none";

      switch (document.querySelector('#frais').value) {
          case "1TRF":
              $('.txt_feesType').html("1ère Tranche");
              break;
          case "2TRF":
              $('.txt_feesType').html("2ème Tranche");
              break;
          case "3TRF":
              $('.txt_feesType').html("3ème Tranche");
              break;
          case "all":
              $('.txt_feesType').html("Tout");
              break;
          default:
              break;
      }

      $('#txt_feesTypeR').html($('.txt_feesType').html());

      
    }

    $scope.sendRequestTab = function () {

        //document.querySelector('.print').style = "display:none";


        if ($scope.cbo_year != undefined && $scope.cbo_frais != undefined && $scope.cbo_promotion != undefined) {
            $scope.isLoading = true;
            $scope.isVisibeCtrl = true;
            document.querySelector('#blockPrinter').style = "display:none";
            document.querySelector('#loader').style = "display:normal";


            $scope.tabGroupPupils = [];
            var promotion = $scope.cbo_promotion.toString().trim().split(" ");
            console.log(promotion.length);
            var level = promotion[0].substring(0, 1);
            var option = promotion[1];
            console.log("Level is :" + level + " option is:" + option);
            //console.log("FRAIS :"+$scope.cbo_frais+" PROMOTION :"+$scope.cbo_promotion+" ANNEE SCOLAIRE:"+$scope.cbo_year);
            $scope.arrayGroup = "";
            $scope.pupilGroup = [];
            var departement = document.querySelector('#lbldepartement').innerHTML;
            //var url = "../controllers/TaskPayment.php?departement=" + departement + "&year=" + $scope.cbo_year + "&frais=" + $scope.cbo_frais + "&level=" + level + "&option=" + option;
            factoryStudent.getListPayment($scope.cbo_year,level,option,$scope.cbo_frais,departement).then(
                function(response){
                    console.log('Response:',response);
                    $scope.totalPupils=parseInt(response.counter[0].COUNTER);
                   if (response.pupils!=undefined) {
                       if($scope.totalPupils == 0)
                       {
                            $scope.isVisibilityPay=false;
                            $scope.isLoading = false;
                            $scope.isVisibeCtrl = false;
                            document.querySelector('#blockPrinter').style = "display:none";
                            document.querySelector('#loader').style = "display:none";

                            document.querySelector('#info_alert').textContent = "Cette promotion n'a pas d'élèves!";
                            $( "#info_alert" ).fadeIn( 500 );
                            setTimeout(function () { $( "#info_alert" ).fadeOut( 1000 ); }, 2500);
                       }
                   }

                    $scope.tablePay=response.pupils;
                    $scope.totalSlice=0;
                    //console.log("Total slice: ",$scope.totalSlice);
                    switch ($scope.cbo_frais.trim()) {
                        case "1TRF":
                            $scope.totalSlice=parseInt(document.querySelector('#lbl1TRF').innerHTML);
                            break;
                        case "2TRF":
                            $scope.totalSlice=parseInt(document.querySelector('#lbl2TRF').innerHTML);
                            break;
                        case "3TRF":
                            $scope.totalSlice=parseInt(document.querySelector('#lbl3TRF').innerHTML);
                            break;
                        case "all":
                            $scope.totalSlice=parseInt(document.querySelector('#lblFRSCO').innerHTML);
                            break;
                        default:
                            break;
                    }

                    $scope.totalGlobal=parseInt($scope.totalPupils) * parseInt($scope.totalSlice);
                    console.log("Total pupils: ",$scope.totalPupils);
                    console.log("Total slice: ",$scope.totalSlice);
                    console.log("Total global: ",$scope.totalGlobal);
                 //   alert($scope.totalSlice);
                   // alert($scope.totalPupils)
                    $scope.totalTabpay=0;
                    angular.forEach($scope.tablePay,function(value,key){
                        $scope.totalTabpay+=parseInt(value._AMOUNT);

                    });
                    $scope.resteTabpay = parseInt($scope.totalGlobal) - parseInt($scope.totalTabpay);
                    console.log("Total pay:",$scope.totalTabpay);
                    console.log("Rows Students :"+$scope.pupilGroup.length);
                    if($scope.totalPupils != 0)
                    {
                        document.querySelector('#blockPrinter').style = "display:none";
                        $scope.isLoading = false;
                        $scope.isVisibeCtrl = false;
                        document.querySelector('#loader').style = "display:none";

                        if($scope.totalTabpay != 0)
                        {
                            $scope.isVisibilityPay=true;
                            document.querySelector('#preview').style.display = "block";
                        }else{
                            $scope.isVisibilityPay=false;
                            document.querySelector('#info_alert').textContent = "Aucun élève n'a payé dans cette promotion !";
                            $( "#info_alert" ).fadeIn( 500 );
                            setTimeout(function () { $( "#info_alert" ).fadeOut( 1000 ); }, 2800);
                        }

                    }

                },
                function(error){
                    console.log(error);
                }
            );

        }
    }

    $scope.tablePayFormat=[];
    $scope.isVisibeCtrl=false;
    $scope.PrinteTabPay=function(){

        $scope.totalGlobal=parseInt($scope.totalPupils) * parseInt($scope.totalSlice);

        $scope.nameCurrent="";
        $scope.amount=0;
        $scope.tbPrint=[];
        angular.forEach($scope.tablePay,function(value,key){
            $scope.tbPrint[key]=value;
        })
        angular.forEach($scope.tbPrint,function(value,key){
            if ($scope.nameCurrent!=value._NAME) {
                angular.forEach($scope.tablePay,function(data,index){
                    if(data._NAME==value._NAME){
                        $scope.amount+=parseInt(data._AMOUNT);
                        delete $scope.tbPrint[index];
                    }
                });
            }
            var pupilFormat={
                mat:value._MAT,
                namePupil:value._NAME,
                sexPupil:value._SEX,
                datePay:value._DATEPAY,
                timePay:value._TIMEPAY,
                amount:$scope.amount
            };
            $scope.tablePayFormat.push(pupilFormat);
            $scope.amount=0;
            $scope.nameCurrent="";
        })
        console.log("Datas Format:",JSON.stringify($scope.tablePayFormat));
        $scope.totalPayPrint=0;
        $scope.totalrestePay=0;
        angular.forEach($scope.tablePayFormat,function(value,key){
            $scope.totalPayPrint+=value.amount;
        });
        $scope.totalrestePay=$scope.totalGlobal-$scope.totalPayPrint;

        $scope.isVisibeCtrl=true;
        document.querySelector('#headerReport').style = "display:block";
        $scope.headerReport=true;
        document.querySelector('#blockPrinter').style = "display:block";
        document.querySelector('#menuBar').style.display="none";
        document.querySelector('#header').style.display="none";
        
        
    }
    $scope.print=function(){
        document.querySelector('#btnprint').style.display="none";
        document.querySelector('#btnqprint').style.display="none";
        window.print();
        window.location.reload();
        //$scope.isVisibeCtrl=false;
        //document.querySelector('#menuBar').style.display="block";

    }
    $scope.quitprint = function(){
        window.location.reload();
    }

});
