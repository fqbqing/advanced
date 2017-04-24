/**
Template Name: Upbond
Chartjs
*/


!function(r){"use strict";var o=function(){};o.prototype.respChart=function(o,e,a,t){function n(){o.attr("width",r(d).width());switch(e){case"Line":new Chart(i,{type:"line",data:a,options:t});break;case"Doughnut":new Chart(i,{type:"doughnut",data:a,options:t});break;case"Pie":new Chart(i,{type:"pie",data:a,options:t});break;case"Bar":new Chart(i,{type:"bar",data:a,options:t});break;case"Radar":new Chart(i,{type:"radar",data:a,options:t});break;case"PolarArea":new Chart(i,{data:a,type:"polarArea",options:t})}}var i=o.get(0).getContext("2d"),d=r(o).parent();r(window).resize(n),n()},o.prototype.init=function(){var o={labels:["January","February","March","April","May","June","July","August","September","October"],datasets:[{label:"Sales Analytics",fill:!0,lineTension:.2,backgroundColor:"rgba(230, 230, 230, 0.2)",borderColor:"#dcdcdc",borderCapStyle:"butt",borderDash:[],borderDashOffset:0,borderJoinStyle:"miter",pointBorderColor:"#dcdcdc",pointBackgroundColor:"#fff",pointBorderWidth:1,pointHoverRadius:5,pointHoverBackgroundColor:"#dcdcdc",pointHoverBorderColor:"#dcdcdc",pointHoverBorderWidth:2,pointRadius:1,pointHitRadius:10,data:[65,59,80,81,56,55,40,55,30,80]},{label:"Monthly Earnings",fill:!0,lineTension:.2,backgroundColor:"rgba(34, 134, 245, 0.2)",borderColor:"#2286f5",borderCapStyle:"butt",borderDash:[],borderDashOffset:0,borderJoinStyle:"miter",pointBorderColor:"#2286f5",pointBackgroundColor:"#fff",pointBorderWidth:1,pointHoverRadius:5,pointHoverBackgroundColor:"#2286f5",pointHoverBorderColor:"#2286f5",pointHoverBorderWidth:2,pointRadius:1,pointHitRadius:10,data:[80,23,56,65,23,35,85,25,92,36]}]},e={scales:{yAxes:[{ticks:{max:100,min:20,stepSize:10}}]}};this.respChart(r("#lineChart"),"Line",o,e);var a={labels:["Desktops","Tablets"],datasets:[{data:[300,210],backgroundColor:["#2286f5","#ebeff2"],hoverBackgroundColor:["#2286f5","#ebeff2"],hoverBorderColor:"#fff"}]};this.respChart(r("#doughnut"),"Doughnut",a);var t={labels:["Desktops","Tablets"],datasets:[{data:[300,180],backgroundColor:["#2286f5","#ebeff2"],hoverBackgroundColor:["#2286f5","#ebeff2"],hoverBorderColor:"#fff"}]};this.respChart(r("#pie"),"Pie",t);var n={labels:["January","February","March","April","May","June","July","August","September","October","November","December"],datasets:[{label:"Sales Analytics",backgroundColor:"#2286f5",borderColor:"#2286f5",borderWidth:1,hoverBackgroundColor:"#2286f5",hoverBorderColor:"#2286f5",data:[65,59,81,62,56,80,50,77,59,81,88,48]}]};this.respChart(r("#bar"),"Bar",n);var i={labels:["Eating","Drinking","Sleeping","Designing","Coding","Cycling","Running"],datasets:[{label:"Desktops",backgroundColor:"rgba(230,230,230,0.2)",borderColor:"rgba(230,230,230,1)",pointBackgroundColor:"rgba(230,230,230,1)",pointBorderColor:"#fff",pointHoverBackgroundColor:"#fff",pointHoverBorderColor:"rgba(230,230,230,1)",data:[65,59,90,81,56,55,40]},{label:"Tablets",backgroundColor:"rgba(34, 134, 245, 0.2)",borderColor:"#2286f5",pointBackgroundColor:"#2286f5",pointBorderColor:"#fff",pointHoverBackgroundColor:"#fff",pointHoverBorderColor:"#2286f5",data:[28,48,40,19,96,27,100]}]};this.respChart(r("#radar"),"Radar",i);var d={datasets:[{data:[11,16,7,18],backgroundColor:["#2286f5","#fa9a2a","#e73c38","#ebeff2"],label:"My dataset",hoverBorderColor:"#fff"}],labels:["Series 1","Series 2","Series 3","Series 4"]};this.respChart(r("#polarArea"),"PolarArea",d)},r.ChartJs=new o,r.ChartJs.Constructor=o}(window.jQuery),function(r){"use strict";r.ChartJs.init()}(window.jQuery);
