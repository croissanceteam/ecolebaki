app.controller('ViewPupilsCtrl',function($scope,$http){
   // alert(document.querySelector('#lbl_year').innerHTML);
    $http.get('listyears').then(function(response){
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
                    
                    { "data": "matricule" },
                    { "data": "name_pupil" },
                    { "data": "gender" },
                    { "data": "level" },
                    {"data":"section"}
                ]
            });
                
            $('#dataTables-example tbody').on('click', 'tr', function (e) {
                var data = table.data();
                var index=e.target._DT_CellIndex.row;
                console.log(data);
                alert( 'You clicked on '+data[index].id+'\'s row' );
                
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
        //alert(title_navbar);
        var url_get_list='listpupils/'+title_navbar+'/SUB/'+year;
        console.log('URL:',url_get_list);
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
        
    
    $scope.toFillTable=function(index,url){
         table=$('#dataTables'+index).DataTable({
                ajax: {
                    url: url,
                    dataSrc:'',
                    
                },
                
                responsive:'true',
                columns:[
                    
                    { "data": "matricule" },
                    { "data": "name_pupil" },
                    { "data": "gender" },
                    { "data": "level" },
                    {"data":"section"}
                ]
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
               document.querySelector('#namePupil').value=data[index].name_pupil;
               document.querySelector('#sex').value=(data[index].gender.trim()=="Masculin"?"M":"F");
          
               document.querySelector('#LabelName').innerHTML=data[index].name_pupil;
               document.querySelector('#phone').value=data[index].phone;
               var town=data[index].townFrom;
               town=town.toString().trim().substring(0,1)+town.toString().trim().substring(1).toLowerCase();
               document.querySelector('#town').value=town;
              // alert(data[index].phone);
                document.querySelector('#btn_date_after').click();
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