app.controller('CtrlStudent', function (factoryStudent,$scope,$http) {
    // alert(document.querySelector('#lbl_year').innerHTML);


    $(document).ready(function(){
        document.querySelector('#loader').style = "display:none";
        document.querySelector('#header').style = "display:normal";
        document.querySelector('#ctrl1').style = "display:normal";
        document.querySelector('#blockPaie').style = "display:normal";
        document.querySelector('#blockPrinter').style = "display:normal";
        document.querySelector('#buttonsPrint').style = "display:normal";

    });

    $http.get('listyears').then(function (response) {
        console.log('listyears : ',response.data);
        $scope.years = response.data;
        $scope.cbo_year = $scope.years;
        //for initialising the list by the first value : $scope.cbo_year = $scope.years[0];
    }, function (error) {
        console.log(error)
    })

    $scope.criteriaChanged = function(){
      console.log('Criteria changed');
      //alert('Criteria changed');
      document.querySelector('#preview').style.display = "none";

      switch (document.querySelector('#frais').value) {
          case "1TRIM":
              $('.txt_feesType').html("1er Trimestre");
              break;
          case "2TRIM":
              $('.txt_feesType').html("2eme Trimestre");
              break;
          case "3TRIM":
              $('.txt_feesType').html("3eme Trimestre");
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

        console.log('cbo_year :',$scope.cbo_year.year);
        if ($scope.cbo_year != undefined && $scope.cbo_frais != undefined && $scope.cbo_promotion != undefined) {
            $scope.isLoading = true;
            $scope.isVisibeCtrl = true;
            document.querySelector('#blockPrinter').style = "display:none";
            document.querySelector('#loader').style = "display:normal";


            $scope.tabGroupPupils = [];
            var promotion = $scope.cbo_promotion.toString().trim().split(" ");
            console.log('Promotion length : ',promotion.length);
            var level = promotion[0].substring(0, 1);
            var option = promotion[1];
            console.log("Level is :" + level + " option is:" + option);
            //console.log("FRAIS :"+$scope.cbo_frais+" PROMOTION :"+$scope.cbo_promotion+" ANNEE SCOLAIRE:"+$scope.cbo_year);
            $scope.arrayGroup = "";
            $scope.pupilGroup = [];
            var departement = document.querySelector('#lbldepartement').innerHTML;
            //var url = "../controllers/TaskPayment.php?departement=" + departement + "&year=" + $scope.cbo_year + "&frais=" + $scope.cbo_frais + "&level=" + level + "&option=" + option;
            factoryStudent.getListPayment($scope.cbo_year.year,level,option,$scope.cbo_frais,departement).then(
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
                            alertify.alert("Cette promotion n'a pas d'élèves!");
                       }
                   }

                    $scope.tablePay=response.pupils;
                    $scope.totalTrim=0;
                    //console.log("Total slice: ",$scope.totalTrim);
                    switch ($scope.cbo_frais.trim()) {
                        case "1TRIM":
                            $scope.totalTrim=parseFloat(document.querySelector('#lbl1TRIM').innerHTML);
                            break;
                        case "2TRIM":
                            $scope.totalTrim=parseFloat(document.querySelector('#lbl2TRIM').innerHTML);
                            break;
                        case "3TRIM":
                            $scope.totalTrim=parseFloat(document.querySelector('#lbl3TRIM').innerHTML);
                            break;
                        case "all":
                            $scope.totalTrim=parseFloat(document.querySelector('#lblFRSCO').innerHTML);
                            break;
                        default:
                            break;
                    }

                    $scope.totalGlobal=parseInt($scope.totalPupils) * parseFloat($scope.totalTrim);
                    console.log("Total pupils: ",$scope.totalPupils);
                    console.log("Total slice: ",$scope.totalTrim);
                    console.log("Total global: ",$scope.totalGlobal);
                 //   alert($scope.totalTrim);
                   // alert($scope.totalPupils)
                    $scope.totalTabpay=0;
                    angular.forEach($scope.tablePay,function(value,key){
                        $scope.totalTabpay+=parseFloat(value._AMOUNT);

                    });
                    $scope.totalTabpay = $scope.totalTabpay.toFixed(2);
                    resteTabpay = parseFloat($scope.totalGlobal) - parseFloat($scope.totalTabpay);
                    $scope.resteTabpay = resteTabpay.toFixed(2);
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
                            alertify.alert("Aucun élève n'a payé dans cette promotion !");
                        }

                    }
                    $scope.totalGlobal = $scope.formatMoney($scope.totalGlobal);
                    $scope.totalTabpay = $scope.formatMoney($scope.totalTabpay);
                    $scope.resteTabpay = $scope.formatMoney($scope.resteTabpay);

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

        $scope.totalGlobal=parseInt($scope.totalPupils) * parseFloat($scope.totalTrim);

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
                        $scope.amount+=parseFloat(data._AMOUNT);
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
                amount:parseFloat($scope.amount.toFixed(2))
            };
            $scope.tablePayFormat.push(pupilFormat);
            $scope.amount=0;
            $scope.nameCurrent="";
        })
        console.log("Datas Format:",JSON.stringify($scope.tablePayFormat));
        $scope.totalPayPrint=0;
        $scope.totalrestePay=0;
        angular.forEach($scope.tablePayFormat,function(value,key){
            $scope.totalPayPrint+=parseFloat(value.amount);
        });
        $scope.totalPayPrint = $scope.totalPayPrint.toFixed(2);
        $scope.totalrestePay=parseFloat($scope.totalGlobal)-parseFloat($scope.totalPayPrint);
        $scope.totalrestePay = $scope.totalrestePay.toFixed(2);

        $scope.isVisibeCtrl=true;
        document.querySelector('#headerReport').style = "display:block";
        $scope.headerReport=true;
        document.querySelector('#blockPrinter').style = "display:block";
        document.querySelector('#menuBar').style.display="none";
        document.querySelector('#header').style.display="none";

        $scope.totalGlobal = $scope.formatMoney($scope.totalGlobal);
        $scope.totalPayPrint = $scope.formatMoney($scope.totalPayPrint);
        $scope.totalrestePay = $scope.formatMoney($scope.totalrestePay);
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
    $scope.formatMoney = function(amount, currency = '', decimalCount = 2, decimal = ".", thousands = " ") {
        try {
            decimalCount = Math.abs(decimalCount);
            decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

            //const negativeSign = amount < 0 ? "-" : "";

            let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
            let j = (i.length > 3) ? i.length % 3 : 0;

            return currency + ' ' + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
        } catch (e) {
            console.log('format money error :',e);
        }
    }


});
