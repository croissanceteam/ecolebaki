$(function() {

    // var data = [{
    //     promotion: '1MAT',
    //     current: 15,
    //     last: 13,
    // }, {
    //     promotion: '2MAT',
    //     current: 18,
    //     last: 17,
    // }, {
    //     promotion: '3MAT',
    //     current: 25,
    //     last: 22,
    // }, {
    //     promotion: '1PRIM',
    //     current: 18,
    //     last: 30,
    // }];
    var dataa = [
        {"promotion":"1ere  Primaire","current":0,"last":0},
        {"promotion":"2eme Primaire","current":0,"last":0},
        {"promotion":"3eme Primaire","current":0,"last":0},
        {"promotion":"4eme Primaire","current":0,"last":0},
        {"promotion":"5eme Primaire","current":0,"last":1},
        {"promotion":"6eme Primaire","current":1,"last":1},
        {"promotion":"1ere  Maternelle","current":0,"last":1},
        {"promotion":"2eme Maternelle","current":1,"last":0},
        {"promotion":"3eme Maternelle","current":0,"last":0}
    ];
   
    $.get('getdashboarddata', function(data){
        console.log("Success :",data);

        config = {
            data: JSON.parse(data),
            xkey: 'promotion',
            ykeys: ['current','last'],
            labels: ['Cette année','Année passée'],
            parseTime: false,
            pointSize: 2,
            hideHover: 'auto',
            behaveLikeLine: true,
            resize: true,
            pointFillColors:['#ffffff'],
            pointStrokeColors: ['black'],
            lineColors:['#00B0FF','#546E7A']
        };

        config.element = 'morris-area-chart';
        Morris.Area(config);
        config.element = 'morris-line-chart';
        Morris.Line(config);
        config.element = 'morris-bar-chart';
        Morris.Bar(config);

        // Morris.Donut({
        //     element: 'morris-donut-chart',
        //     data: JSON.parse(data),
        //     resize: true
        // });

        // chart.setData(data);

    }).fail(function(){
        console.log("Error");
    });

    
    
    

    // Morris.Bar({
    //     element: 'morris-bar-chart',
    //     data: [{
    //         y: '2006',
    //         a: 100,
    //         b: 90
    //     }, {
    //         y: '2007',
    //         a: 75,
    //         b: 65
    //     }, {
    //         y: '2008',
    //         a: 50,
    //         b: 40
    //     }, {
    //         y: '2009',
    //         a: 75,
    //         b: 65
    //     }, {
    //         y: '2010',
    //         a: 50,
    //         b: 40
    //     }, {
    //         y: '2011',
    //         a: 75,
    //         b: 65
    //     }, {
    //         y: '2012',
    //         a: 100,
    //         b: 90
    //     }],
    //     xkey: 'y',
    //     ykeys: ['a', 'b'],
    //     labels: ['Series A', 'Series B'],
    //     hideHover: 'auto',
    //     resize: true
    // });
    
});
