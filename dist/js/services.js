var app=angular.module('app');

app.factory("factoryStudent",function($http,$q){
    var MyFactory={
         
        getListPayment:function(year,level,option,frais,departement){
                
                let url="controllers/TaskPayment.php?departement="+departement+"&year="+year+"&frais="+frais+"&level="+level+"&option="+option;
                let promise_5=$q.defer();
                $http.get(url)
                     .success(function(data,status){
                         promise_5.resolve(data);
                     })
                     .error(function(data,status){
                         promise_5.reject(data);
                     });
                     return promise_5.promise;
        }
    }
    return MyFactory;
});

