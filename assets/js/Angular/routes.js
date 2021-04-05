Frelancers Group.config(function($routeProvider,$locationProvider) {
    
    $routeProvider.when('/', {
      templateUrl : 'templates/home.html',
      controller  : 'dashboardController'
    })

    .when('/dormitories', {
      templateUrl : 'templates/dormitories.html',
      controller  : 'dormitoriesController'
    })

    .when('/admins', {
      templateUrl : 'templates/admins.html',
      controller  : 'adminsController'
    })
    
    .when('/teachers', {
      templateUrl : 'templates/teachers.html',
      controller  : 'teachersController'
    })

    .when('/students', {
      templateUrl : 'templates/students.html',
      controller  : 'studentsController'
    })

    .when('/parents', {
      templateUrl : 'templates/stparents.html',
      controller  : 'parentsController'
    })

    .when('/classes', {
      templateUrl : 'templates/classes.html',
      controller  : 'classesController'
    })

    .when('/subjects', {
      templateUrl : 'templates/subjects.html',
      controller  : 'subjectsController'
    })

    .when('/newsboard', {
      templateUrl : 'templates/newsboard.html',
      controller  : 'newsboardController'
    })

    .when('/newsboard/:newsId', {
      templateUrl : 'templates/newsboard.html',
      controller  : 'newsboardController'
    })

    .when('/library', {
      templateUrl : 'templates/library.html',
      controller  : 'libraryController'
    })

    .when('/accountSettings/profile', {
      templateUrl : 'templates/accountSettings.html',
      controller  : 'accountSettingsController',
      methodName: 'profile'
    })

    .when('/accountSettings/email', {
      templateUrl : 'templates/accountSettings.html',
      controller  : 'accountSettingsController',
      methodName: 'email'
    })

    .when('/accountSettings/password', {
      templateUrl : 'templates/accountSettings.html',
      controller  : 'accountSettingsController',
      methodName: 'password'
    })

    .when('/classschedule', {
      templateUrl : 'templates/classschedule.html',
      controller  : 'classScheduleController'
    })

    .when('/attendance', {
      templateUrl : 'templates/attendance.html',
      controller  : 'attendanceController'
    })

    .when('/gradeLevels', {
      templateUrl : 'templates/gradeLevels.html',
      controller  : 'gradeLevelsController'
    })

    .when('/examsList', {
      templateUrl : 'templates/examsList.html',
      controller  : 'examsListController'
    })

    .when('/events', {
      templateUrl : 'templates/events.html',
      controller  : 'eventsController'
    })

    .when('/events/:eventId', {
      templateUrl : 'templates/events.html',
      controller  : 'eventsController'
    })

    .when('/assignments', {
      templateUrl : 'templates/assignments.html',
      controller  : 'assignmentsController'
    })

    .when('/mailsms', {
      templateUrl : 'templates/mailsms.html',
      controller  : 'mailsmsController'
    })

    .when('/messages', {
      templateUrl : 'templates/messages.html',
      controller  : 'messagesController'
    })

    .when('/onlineExams', {
      templateUrl : 'templates/onlineExams.html',
      controller  : 'onlineExamsController'
    })

    .when('/calender', {
      templateUrl : 'templates/calender.html',
      controller  : 'calenderController'
    })

    .when('/transports', {
      templateUrl : 'templates/transportation.html',
      controller  : 'TransportsController'
    })

    .when('/settings', {
      templateUrl : 'templates/settings.html',
      controller  : 'settingsController',
      methodName: 'settings'
    })
    
    .when('/terms', {
      templateUrl : 'templates/settings.html',
      controller  : 'settingsController',
      methodName: 'terms'
    })
    
    .when('/media', {
      templateUrl : 'templates/media.html',
      controller  : 'mediaController'
    })

    .when('/static', {
      templateUrl : 'templates/static.html',
      controller  : 'staticController'
    })

    .when('/static/:pageId', {
      templateUrl: 'templates/static.html',
      controller: 'staticController'
    })

    .when('/attendanceStats', {
      templateUrl : 'templates/attendanceStats.html',
      controller  : 'attendanceStatsController'
    })

    .when('/polls', {
      templateUrl : 'templates/polls.html',
      controller  : 'pollsController'
    })

    .when('/mailsmsTemplates', {
      templateUrl : 'templates/mailsmsTemplates.html',
      controller  : 'mailsmsTemplatesController'
    })

    .when('/payments', {
      templateUrl : 'templates/payments.html',
      controller  : 'paymentsController'
    })

    .when('/languages', {
      templateUrl : 'templates/languages.html',
      controller  : 'languagesController'
    })

    .when('/upgrade', {
      templateUrl : 'templates/upgrade.html',
      controller  : 'upgradeController'
    })

    .when('/promotion', {
      templateUrl : 'templates/promotion.html',
      controller  : 'promotionController'
    })
    
    .otherwise({
      redirectTo:'/'
    });
});
Frelancers Group.factory('dataFactory', function($http) {
  var myService = {
    httpRequest: function(url,method,params,dataPost,upload) {
      var passParameters = {};
      passParameters.url = url;
      
      if (typeof method == 'undefined'){
        passParameters.method = 'GET';
      }else{
        passParameters.method = method;
      }

      if (typeof params != 'undefined'){
        passParameters.params = params;
      }

      if (typeof dataPost != 'undefined'){
        passParameters.data = dataPost;
      }

      if (typeof upload != 'undefined'){
         passParameters.upload = upload;
      }

      var promise = $http(passParameters).then(function (response) {
        if(typeof response.data == 'string' && response.data != 1){
          $.gritter.add({
            title: 'School Application',
            text: response.data
          });
          return false;
        }
        if(response.data.jsMessage){
          $.gritter.add({
            title: response.data.jsTitle,
            text: response.data.jsMessage
          });
        }
        return response.data;
      },function(){
        $.gritter.add({
          title: 'School Application',
          text: 'An error occured while processing your request.'
        });
      });
      return promise;
    }
  };
  return myService;
});
Frelancers Group.directive('datePicker', function($parse, $timeout){
    return {
        restrict: 'A',
        replace: true,
        transclude: false,
        compile: function(element, attrs) {
          return function (scope, slider, attrs, controller) {
            $(attrs.selector).datepicker();
          };
        }
    };
});
Frelancers Group.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });
 
                event.preventDefault();
            }
        });
    };
});
Frelancers Group.directive('chatBox', function($parse, $timeout){
    return {
        restrict: 'A',
        replace: true,
        transclude: false,
        compile: function(element, attrs) {
          return function (scope, slider, attrs, controller) {
            $('#chat-box').slimScroll({
              height: '500px',alwaysVisible: true,start : "bottom"
            });
          };
        }
    };
});
Frelancers Group.directive('ckEditor', [function () {
    return {
        require: '?ngModel',
        link: function ($scope, elm, attr, ngModel) {
            var ck = CKEDITOR.replace(elm[0]);

            ck.on('pasteState', function () {
                $scope.$apply(function () {
                    ngModel.$setViewValue(ck.getData());
                });
            });

            ngModel.$render = function (value) {
                ck.setData(ngModel.$modelValue);
            };
        }
    };
}]);
Frelancers Group.directive('calendarBox', function($parse, $timeout){
    return {
        restrict: 'A',
        replace: true,
        transclude: false,
        compile: function(element, attrs) {
          return function (scope, slider, attrs, controller) {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                buttonText: {//This is to add icons to the visible buttons
                    prev: "Previous",
                    next: "Next",
                    today: 'today',
                    month: 'month',
                    week: 'week',
                    day: 'day'
                },
                //Random default events
                events: "calender"
            });
          };
        }
    };
});
Frelancers Group.directive('modal', function () {
return {
    template: '<div class="modal fade">' + 
        '<div class="modal-dialog">' + 
          '<div class="modal-content">' + 
            '<div class="modal-header">' + 
              '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' + 
              '<h4 class="modal-title">{{ modalTitle }}</h4>' + 
            '</div>' + 
            '<div class="modal-body" ng-transclude></div>' + 
          '</div>' + 
        '</div>' + 
      '</div>',
    restrict: 'E',
    transclude: true,
    replace:true,
    scope:true,
    link: function postLink(scope, element, attrs) {
      scope.$watch(attrs.visible, function(value){
        if(value == true)
          $(element).modal('show');
        else
          $(element).modal('hide');
      });

      $(element).on('shown.bs.modal', function(){
        scope.$apply(function(){
          scope.$parent[attrs.visible] = true;
        });
      });

      $(element).on('hidden.bs.modal', function(){
        scope.$apply(function(){
          scope.$parent[attrs.visible] = false;
        });
      });
    }
  };
});
Frelancers Group.directive('attendancePerDay', function($parse, $timeout){
    return {
        restrict: 'A',
        replace: true,
        transclude: false,
        compile: function(element, attrs) {
          return function (scope, slider, attrs, controller) {
            $(function() {
              scope.$watch('attendanceStats', function (newval, oldval) {
                if (newval != oldval) {
                  var data0 = [];
                  var data1 = [];
                  var data2 = [];
                  var data3 = [];
                  var data4 = [];

                  angular.forEach(newval.attendance, function(value, key) {
                    angular.forEach(value, function(valuein, keyin) {
                      if(keyin == 0){
                        data0.push([key, valuein]);
                      }
                      if(keyin == 1){
                        data1.push([key, valuein]);
                      }
                      if(keyin == 2){
                        data2.push([key, valuein]);
                      }
                      if(keyin == 3){
                        data3.push([key, valuein]);
                      }
                      if(keyin == 4){
                        data4.push([key, valuein]);
                      }
                    });
                  });
                
                  var line_data0 = {
                      data: data0,
                      color: "#000000"
                  };
                  var line_data1 = {
                      data: data1,
                      color: "#008000"
                  };
                  var line_data2 = {
                      data: data2,
                      color: "#4D4D4D"
                  };
                  var line_data3 = {
                      data: data3,
                      color: "#7F7F7F"
                  };
                  var line_data4 = {
                      data: data4,
                      color: "#FFFF00"
                  };

                  $.plot("#line-chart", [line_data0,line_data1], {
                      grid: {
                          hoverable: true,
                          borderWidth: 1,
                          borderColor: "#f3f3f3",
                          tickColor: "#f3f3f3"
                      },
                      series: {
                        shadowSize: 0,
                        lines: {
                            show: true
                        },
                        points: {
                            show: true
                        },
                      },
                      xaxis: {
                          mode: "categories",
                          tickLength: 1
                      },
                      legend: {
                        sorted: "ascending"
                      }
                  });
                }
              });
            });
          };
        }
    };
});

Frelancers Group.directive('attendanceBarChart', function($parse, $timeout){
    return {
        restrict: 'A',
        replace: true,
        transclude: false,
        compile: function(element, attrs) {
          return function (scope, slider, attrs, controller) {
            $(function() {
              scope.$watch('attendanceStats', function (newval, oldval) {
                if (newval != oldval) {
                  var data0 = [];
                  angular.forEach(newval.attendanceDay, function(valuein, keyin) {
                    data0.push([keyin, valuein]);
                  });
                  var bar_data = {
                      data: data0,
                      color: "#3c8dbc"
                  };
                  $.plot("#bar-chart", [bar_data], {
                      grid: {
                          borderWidth: 1,
                          borderColor: "#f3f3f3",
                          tickColor: "#f3f3f3"
                      },
                      series: {
                          bars: {
                              show: true,
                              barWidth: 0.5,
                              align: "center"
                          }
                      },
                      xaxis: {
                          mode: "categories",
                          tickLength: 0
                      }
                  });

                }
              });
            });
          };
        }
    };
});

Frelancers Group.directive('scalendarBox', function($parse, $timeout){
    return {
        restrict: 'A',
        replace: true,
        transclude: false,
        compile: function(element, attrs) {
          return function (scope, slider, attrs, controller) {
            $('#scalendar').fullCalendar({
                events: "calender"
            });
          };
        }
    };
});
Frelancers Group.directive('tooltip', function(){
    return {
        restrict: 'A',
        link: function(scope, element, attrs){
          $(element).hover(function(){
              $(element).tooltip('show');
          }, function(){
              $(element).tooltip('hide');
          });
        }
    };
});


Frelancers Group.filter('object2Array', function() {
  return function(input) {
    var out = []; 
    for(i in input){
      out.push(input[i]);
    }
    return out;
  }
});

function uploadSuccessOrError(response){
  if(typeof response == 'string' && response != 1){
    $.gritter.add({
      title: 'School Application',
      text: response
    });
    return false;
  }
  if(response.jsMessage){
    $.gritter.add({
      title: response.jsTitle,
      text: response.jsMessage
    });
  }
  if(response.jsStatus){
    if(response.jsStatus == "0"){
      return false;
    }
  }
  return response;
}

function successOrError(data){
  if(data.jsStatus){
    if(data.jsStatus == "0"){
      return false;
    }
  }
  return data;
}