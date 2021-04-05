var Frelancers Group = angular.module('Frelancers Group',['ngRoute','ngCookies','ngUpload','ui.autocomplete','angularUtils.directives.dirPagination']).run(function($http,dataFactory,$rootScope) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "dashboard", false);
  xhr.onload = function (e) {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        $rootScope.dashboardData = JSON.parse(xhr.responseText);
        $rootScope.phrase = $rootScope.dashboardData.language;
      }
    }
  };
  xhr.send(null);
});

var appBaseUrl = $('base').attr('href');

var xhReq = new XMLHttpRequest();
xhReq.open("GET", "api/csrf", false);
xhReq.send(null);

Frelancers Group.constant("CSRF_TOKEN", xhReq.responseText);

Frelancers Group.run(['$http', 'CSRF_TOKEN', function($http, CSRF_TOKEN) {    
    $http.defaults.headers.common['X-Csrf-Token'] = CSRF_TOKEN;
}]);

Frelancers Group.controller('mainController', function(dataFactory,$rootScope,$scope) {
  var data = $rootScope.dashboardData;
  $scope.phrase = $rootScope.phrase;

  $scope.dashboardData = data;
  $rootScope.phrase = data.language;
  $scope.phrase = data.language;
  
  $scope.savePollVote = function(){
    $('.overlay, .loading-img').show();
    if($scope.dashboardData.polls.selected === undefined){
      alert('You must select item to vote.');
      $('.overlay, .loading-img').hide();
      return;
    }
    dataFactory.httpRequest('dashboard/polls','POST',{},$scope.dashboardData.polls).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.dashboardData.polls = data;
      }
      $('.overlay, .loading-img').hide();
    });
  }

  if($scope.dashboardData.teacherLeaderBoard != null){
    if($scope.dashboardData.teacherLeaderBoard.photo == ""){
      $scope.dashboardData.teacherLeaderBoard.photo = 'uploads/profile/user.png';
    }else{
      $scope.dashboardData.teacherLeaderBoard.photo = 'uploads/profile/' + $scope.dashboardData.teacherLeaderBoard.photo;
    }
  }

  if($scope.dashboardData.studentLeaderBoard != null){
    if($scope.dashboardData.studentLeaderBoard.photo == ""){
      $scope.dashboardData.studentLeaderBoard.photo = 'uploads/profile/user.png';
    }else{
      $scope.dashboardData.studentLeaderBoard.photo = 'uploads/profile/' + $scope.dashboardData.studentLeaderBoard.photo ;
    }
  }
  $('.overlay, .loading-img').hide();
});

Frelancers Group.controller('dashboardController', function(dataFactory,$rootScope,$scope) {
  $('.overlay, .loading-img').hide();
});

Frelancers Group.controller('upgradeController', function(dataFactory,$rootScope,$scope) {
  $('.overlay, .loading-img').hide();
});

Frelancers Group.controller('calenderController', function(dataFactory,$scope) {
  $('.overlay, .loading-img').hide();  
});

Frelancers Group.controller('registeration', function(dataFactory,$scope) {
  $scope.views = {};
  $scope.classes = {};
  $scope.views.register = true;
  $scope.form = {};
  $scope.form.studentInfo = [];
  $scope.form.role = "teacher" ;

  dataFactory.httpRequest('register/classes').then(function(data) {
    $scope.classes = data;
    $('.overlay, .loading-img').hide();
  });

  $scope.tryRegister = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('register','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.regId = data.id;
        $scope.changeView('thanks');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.linkStudent = function(){
    $scope.modalTitle = "Link student to parent";
    $scope.showModalLink = !$scope.showModalLink;
  }

  $scope.linkStudentButton = function(){
    var searchAbout = $('#searchLink').val();
    if(searchAbout.length < 3){
      alert("Min character length is 3");
      return;
    }
    dataFactory.httpRequest('register/searchStudents/'+searchAbout).then(function(data) {
      $scope.searchResults = data;
    });
  }

  $scope.linkStudentFinish = function(student){
    var relationShip = prompt("Please enter your relation to student", "");
    if (relationShip != null && relationShip != "") {
        $scope.form.studentInfo.push({"student":student.name,"relation":relationShip,"id":student.id});
        $scope.showModalLink = !$scope.showModalLink;
    }
  }

  $scope.changeView = function(view){
    if(view == "register" || view == "thanks" || view == "show"){
      $scope.form = {};
    }
    $scope.views.register = false;
    $scope.views.thanks = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('adminsController', function(dataFactory,$rootScope,$scope) {
  $scope.admins = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};

  dataFactory.httpRequest('admins/listAll').then(function(data) {
    $scope.admins = data;
    $('.overlay, .loading-img').hide();
  });

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('admins','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.admins = data.users;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this admin?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('admins/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove admin',
            text: 'Admin removed successfully'
          });
          $scope.admins.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('admins/'+id).then(function(data) {
      $scope.form = data;
      $scope.changeView('edit');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('admins/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.admins = data.users;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('classesController', function(dataFactory,$scope) {
  $scope.classes = {};
  $scope.teachers = {};
  $scope.dormitory = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};

  dataFactory.httpRequest('classes/listAll').then(function(data) {
    $scope.classes = data.classes;
    $scope.teachers = data.teachers;
    $scope.dormitory = data.dormitory;
    $('.overlay, .loading-img').hide();
  });

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('classes','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.classes = data.list.classes;
        $scope.teachers = data.list.teachers;
        $scope.dormitory = data.list.dormitory;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this class?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('classes/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove class',
            text: 'Class removed successfully'
          });
          $scope.classes.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('classes/'+id).then(function(data) {
      $scope.form = data;
      $scope.changeView('edit');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('classes/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.classes = data.list.classes;
        $scope.teachers = data.list.teachers;
        $scope.dormitory = data.list.dormitory;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }  

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('subjectsController', function(dataFactory,$scope) {
  $scope.subjects = {};
  $scope.teachers = {};
  $scope.classes = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};

  dataFactory.httpRequest('subjects/listAll').then(function(data) {
    $scope.subjects = data.subjects;
    $scope.teachers = data.teachers;
    $scope.classes = data.classes;
    $('.overlay, .loading-img').hide();
  });

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('subjects','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.subjects = data.list.subjects;
        $scope.teachers = data.list.teachers;
        $scope.classes = data.list.classes;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this subject?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('subjects/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove subject',
            text: 'Subject removed successfully'
          });
          $scope.subjects.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('subjects/'+id).then(function(data) {
      $scope.form = data;
      $scope.changeView('edit');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('subjects/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.subjects = data.list.subjects;
        $scope.teachers = data.list.teachers;
        $scope.classes = data.list.classes;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }  

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('teachersController', function(dataFactory,CSRF_TOKEN,$scope,$sce) {
  $scope.teachers = {};
  $scope.transports = {};
  $scope.teachersApproval = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.CSRF_TOKEN = CSRF_TOKEN;
  $scope.form = {};
  $scope.importType ;

  $scope.import = function(impType){
    $scope.importType = impType;
    $scope.changeView('import');
  };

  $scope.saveImported = function(content){
    content = uploadSuccessOrError(content);
    if(content){
      $('.overlay, .loading-img').show();
      $scope.changeView('list');
    }
    $('.overlay, .loading-img').hide();
  }

  $scope.showModal = false;
  $scope.teacherProfile = function(id){
    dataFactory.httpRequest('teachers/profile/'+id).then(function(data) {
      $scope.modalTitle = data.title;
      $scope.modalContent = $sce.trustAsHtml(data.content);      
      $scope.showModal = !$scope.showModal;
    });
  };

  $scope.totalItems = 0;
  $scope.pageChanged = function(newPage) {
    getResultsPage(newPage);
  };

  getResultsPage(1);
  function getResultsPage(pageNumber) {
    dataFactory.httpRequest('teachers/listAll/'+pageNumber).then(function(data) {
      $scope.teachers = data.teachers;
      $scope.transports = data.transports;
      $scope.totalItems = data.totalItems;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveAdd = function(content){
    content = uploadSuccessOrError(content);
    if(content != false){
      $('.overlay, .loading-img').show();
      
      $scope.teachers = content.list.teachers;
      $scope.transports = content.list.transports;
      $scope.totalItems = content.list.totalItems;
      $scope.changeView('list');
    }
    $('.overlay, .loading-img').hide();
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this teacher?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('teachers/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove teacher',
            text: 'Teacher removed successfully'
          });
          $scope.teachers.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('teachers/'+id).then(function(data) {
      $scope.form = data;
      $scope.changeView('edit');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(content){
    content = uploadSuccessOrError(content);
    console.log(content);
    if(content != false){
      $('.overlay, .loading-img').show();
      
      $scope.teachers = content.list.teachers;
      $scope.transports = content.list.transports;
      $scope.totalItems = content.list.totalItems;
      $scope.changeView('list');
    }
    $('.overlay, .loading-img').hide();
  }

  $scope.waitingApproval = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('teachers/waitingApproval').then(function(data) {
      $scope.teachersApproval = data;
      $scope.changeView('approval');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.approve = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('teachers/approveOne/'+id,'POST').then(function(data) {
      $.gritter.add({
        title: 'Approve teacher account',
        text: 'Account approved successfully'
      });
      $scope.teachersApproval = data;
      $scope.changeView('approval');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.leaderBoard = function(id){
    var isLeaderBoard = prompt("Please enter leaderboard message");
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('teachers/leaderBoard/'+id,'POST',{},{'isLeaderBoard':isLeaderBoard}).then(function(data) {
      $.gritter.add({
        title: 'leaderboard',
        text: 'Teacher marked as leaderboard successfully'
      });
      $('.overlay, .loading-img').hide();
    });
  }
  
  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.approval = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('studentsController', function(dataFactory,CSRF_TOKEN,$scope,$sce) {
  $scope.students = {};
  $scope.classes = {};
  $scope.transports = {};
  $scope.studentsApproval = {};
  $scope.studentMarksheet = {};
  $scope.studentAttendance = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};
  $scope.CSRF_TOKEN = CSRF_TOKEN;
  $scope.userRole ;
  $scope.importType ;

  $scope.import = function(impType){
    $scope.importType = impType;
    $scope.changeView('import');
  };

  $scope.saveImported = function(content){
    content = uploadSuccessOrError(content);
    if(content){
      getResultsPage('1');
      $('.overlay, .loading-img').show();
      $scope.changeView('list');
    }
    $('.overlay, .loading-img').hide();
  }

  $scope.showModal = false;
  $scope.studentProfile = function(id){
    dataFactory.httpRequest('students/profile/'+id).then(function(data) {
      $scope.modalTitle = data.title;
      $scope.modalContent = $sce.trustAsHtml(data.content);      
      $scope.showModal = !$scope.showModal;
    });
  };

  $scope.totalItems = 0;
  $scope.pageChanged = function(newPage) {
    getResultsPage(newPage);
  };

  getResultsPage(1);
  function getResultsPage(pageNumber) {
     dataFactory.httpRequest('students/listAll/'+pageNumber).then(function(data) {
      $scope.students = data.students ;
      $scope.classes = data.classes ;
      $scope.transports = data.transports ;
      $scope.totalItems = data.totalItems
      $scope.userRole = data.userRole;
      $('.overlay, .loading-img').hide();
    });
  }
  
  $scope.saveAdd = function(content){
    content = uploadSuccessOrError(content);
    if(content){
      $('.overlay, .loading-img').show();
      
      $scope.students = content.list.students ;
      $scope.classes = content.list.classes ;
      $scope.transports = content.list.transports ;
      $scope.totalItems = content.list.totalItems
      $scope.changeView('list');
    }
    $('.overlay, .loading-img').hide();
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this student?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('students/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove student',
            text: 'Student removed successfully'
          });
          $scope.students.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('students/'+id).then(function(data) {
      $scope.form = data;
      $scope.changeView('edit');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(content){
    content = uploadSuccessOrError(content);
    if(content){
      $('.overlay, .loading-img').show();
      $scope.students = content.list.students ;
      $scope.classes = content.list.classes ;
      $scope.transports = content.list.transports ;
      $scope.totalItems = content.list.totalItems
      $scope.changeView('list');
    }
    $('.overlay, .loading-img').hide();
  }

  $scope.waitingApproval = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('students/waitingApproval').then(function(data) {
      $scope.studentsApproval = data;
      $scope.changeView('approval');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.approve = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('students/approveOne/'+id,'POST').then(function(data) {
      $.gritter.add({
        title: 'Approve student',
        text: 'Student approved successfully'
      });
      $scope.studentsApproval = data;
      $scope.changeView('approval');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.marksheet = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('students/marksheet/'+id).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.studentMarksheet = data;
        $scope.changeView('marksheet');
      }
      $('.overlay, .loading-img').hide();
    });
  }
  
  $scope.leaderBoard = function(id){
    var isLeaderBoard = prompt("Please enter leaderboard message");
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('students/leaderBoard/'+id,'POST',{},{'isLeaderBoard':isLeaderBoard}).then(function(data) {
      $.gritter.add({
        title: 'Student leaderboard',
        text: 'Student is now leaderboard'
      });
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.attendance = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('students/attendance/'+id).then(function(data) {
      $scope.studentAttendance = data;
      $scope.changeView('attendance');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.approval = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views.attendance = false;
    $scope.views.marksheet = false;
    $scope.views.import = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('parentsController', function(dataFactory,CSRF_TOKEN,$scope,$compile,$sce,$rootScope) {
  $scope.stparents = {};
  $scope.stparentsApproval = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.CSRF_TOKEN = CSRF_TOKEN;
  $scope.form = {};
  $scope.form.studentInfo = {};
  $scope.importType ;
  $scope.searchResults = {};
  $scope.userRole = $rootScope.dashboardData.role;

  $scope.import = function(impType){
    $scope.importType = impType;
    $scope.changeView('import');
  };

  $scope.saveImported = function(content){
    content = uploadSuccessOrError(content);
    if(content){
      $('.overlay, .loading-img').show();
      $scope.changeView('list');
    }
    $('.overlay, .loading-img').hide();
  }

  $scope.showModal = false;
  $scope.parentProfile = function(id){
    dataFactory.httpRequest('parents/profile/'+id).then(function(data) {
      $scope.modalTitle = data.title;
      $scope.modalContent = $sce.trustAsHtml(data.content);      
      $scope.showModal = !$scope.showModal;
    });
  };

  $scope.totalItems = 0;
  $scope.pageChanged = function(newPage) {
    getResultsPage(newPage);
  };

  getResultsPage(1);
  function getResultsPage(pageNumber) {
    dataFactory.httpRequest('parents/listAll/'+pageNumber).then(function(data) {
      $scope.stparents = data.parents ;
      $scope.totalItems = data.totalItems;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('parents','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.stparents = data.list.parents ;
        $scope.totalItems = data.list.totalItems;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this parent?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('parents/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove parent',
            text: 'Parent removed successfully'
          });
          $scope.stparents.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.removeStudent = function(index){
    var confirmRemove = confirm("Sure remove this student?");
    if (confirmRemove == true) {
      for (x in $scope.form.studentInfo) {
        if($scope.form.studentInfo[x].id == index){
          $scope.form.studentInfo.splice(x,1);
          break;
        }
      }
    }
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('parents/'+id).then(function(data) {
      $scope.form = data;
      $scope.form.studentInfo = data.parentOf;
      $scope.changeView('edit');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('parents/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.stparents = data.list.parents ;
        $scope.totalItems = data.list.totalItems;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.waitingApproval = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('parents/waitingApproval').then(function(data) {
      $scope.stparentsApproval = data;
      $scope.changeView('approval');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.approve = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('parents/approveOne/'+id,'POST').then(function(data) {
      $.gritter.add({
        title: 'Approve parent account',
        text: 'Parent approved successfully'
      });
      $scope.stparentsApproval = data;
      $scope.changeView('approval');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.linkStudent = function(){
    $scope.modalTitle = "Link student to parent";
    $scope.showModalLink = !$scope.showModalLink;
  }

  $scope.linkStudentButton = function(){
    var searchAbout = $('#searchLink').val();
    if(searchAbout.length < 3){
      alert("Min character length is 3");
      return;
    }
    dataFactory.httpRequest('parents/search/'+searchAbout).then(function(data) {
      $scope.searchResults = data;
    });
  }

  $scope.linkStudentFinish = function(student){
    var relationShip = prompt("Please enter your relation to student", "");
    if (relationShip != null && relationShip != "") {
        $scope.form.studentInfo.push({"student":student.name,"relation":relationShip,"id":student.id});
        $scope.showModalLink = !$scope.showModalLink;
    }
  }
  
  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
      $scope.form.studentInfo = [];
    }
    $scope.views.list = false;
    $scope.views.approval = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('newsboardController', function(dataFactory,$routeParams,$sce,$scope) {
  $scope.newsboard = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};
  $scope.userRole ;

  if($routeParams.newsId){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('newsboard/'+$routeParams.newsId).then(function(data) {
      $scope.form = data;
      $scope.form.newsText = $sce.trustAsHtml(data.newsText);
      $scope.changeView('read');
      $('.overlay, .loading-img').hide();
    });
  }else{
    $scope.totalItems = 0;
    $scope.pageChanged = function(newPage) {
      getResultsPage(newPage);
    };

    getResultsPage(1);
  }

  function getResultsPage(pageNumber) {
    dataFactory.httpRequest('newsboard/listAll/'+pageNumber).then(function(data) {
      $scope.newsboard = data.newsboard;
      $scope.userRole = data.userRole;
      $scope.totalItems = data.totalItems;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('newsboard','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.newsboard = data.list.newsboard;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this news?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('newsboard/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove news',
            text: 'News removed successfully'
          });
          $scope.newsboard.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('newsboard/'+id).then(function(data) {
      $scope.form = data;
      $scope.changeView('edit');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('newsboard/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.newsboard = data.list.newsboard;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }  

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('libraryController', function(dataFactory,CSRF_TOKEN,$scope) {
  $scope.library = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};
  $scope.CSRF_TOKEN = CSRF_TOKEN;
  $scope.userRole ;

  $scope.totalItems = 0;
  $scope.pageChanged = function(newPage) {
    getResultsPage(newPage);
  };

  getResultsPage(1);
  function getResultsPage(pageNumber) {
    dataFactory.httpRequest('library/listAll/'+pageNumber).then(function(data) {
      $scope.library = data.bookLibrary;
      $scope.totalItems = data.totalItems;
      $scope.userRole = data.userRole;
      $('.overlay, .loading-img').hide();
    });
  }
  
  $scope.saveAdd = function(content){
    content = uploadSuccessOrError(content);
    if(content){
      $('.overlay, .loading-img').show();
      
      $scope.library = content.list.bookLibrary;
      $scope.totalItems = content.list.totalItems;
      $scope.changeView('list');
      $('.overlay, .loading-img').hide();
    }
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this item?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('library/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove book',
            text: 'Book removed successfully'
          });
          $scope.library.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('library/'+id).then(function(data) {
      $scope.form = data;
      $scope.changeView('edit');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(content){
    content = uploadSuccessOrError(content);
    if(content){
      $('.overlay, .loading-img').show();
      
      $scope.library = content.list.bookLibrary;
      $scope.totalItems = content.list.totalItems;
      $scope.changeView('list');
      $('.overlay, .loading-img').hide();
    }
  }  

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});


Frelancers Group.controller('accountSettingsController', function(dataFactory,CSRF_TOKEN,$scope,$route) {
  $scope.account = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};
  $scope.languages = {};
  $scope.languageAllow ;
  $scope.CSRF_TOKEN = CSRF_TOKEN;
  var methodName = $route.current.methodName;

  $scope.changeView = function(view){
    if(view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.profile = false;
    $scope.views.email = false;
    $scope.views.password = false;
    $scope.views[view] = true;
  }

  if(methodName == "profile"){
    dataFactory.httpRequest('accountSettings/langs').then(function(data) {
      $scope.languages = data.languages;
      $scope.languageAllow = data.languageAllow;
      $('.overlay, .loading-img').hide();
    });
    dataFactory.httpRequest('accountSettings/data').then(function(data) {
      $scope.form = data;
      $scope.changeView('profile');
      $('.overlay, .loading-img').hide();
    });
  }else if(methodName == "email"){
    $scope.form = {};
    $scope.changeView('email');
    $('.overlay, .loading-img').hide();
  }else if(methodName == "password"){
    $scope.form = {};
    $scope.changeView('password');
    $('.overlay, .loading-img').hide();
  }

  $scope.saveEmail = function(){
    if($scope.form.email != $scope.form.reemail){
      alert("E-mail & Re-Email don't match");
    }else{
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('accountSettings/email','POST',{},$scope.form).then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Change E-mail',
            text: 'E-mail changed successfully'
          });
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.savePassword = function(){
    if($scope.form.newPassword != $scope.form.repassword){
      alert("Password & Re-Password don't match");
    }else{
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('accountSettings/password','POST',{},$scope.form).then(function(data) {
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.saveProfile = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('accountSettings/profile','POST',{},$scope.form).then(function(data) {
      $.gritter.add({
        title: 'Change Profile',
        text: 'Profile changed successfully'
      });
      $scope.form = data;
      $scope.changeView('profile');
      $('.overlay, .loading-img').hide();
    });
  }
});

Frelancers Group.controller('classScheduleController', function(dataFactory,$scope) {
  $scope.classes = {};
  $scope.subject = {};
  $scope.days = {};
  $scope.classSchedule = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};
  $scope.userRole ;

  dataFactory.httpRequest('classschedule/listAll').then(function(data) {
    $scope.classes = data.classes;
    $scope.subject = data.subject;
    $scope.userRole = data.userRole;
    $scope.days = data.days;
    $('.overlay, .loading-img').hide();
  });
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('classschedule/'+id).then(function(data) {
      $scope.classSchedule = data;
      $scope.classId = id;
      $scope.changeView('edit');
      $('.overlay, .loading-img').hide();
    }); 
  }

  $scope.removeSub = function(id){
    var confirmRemove = confirm("Sure remove this item?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('classschedule/'+$scope.classId+'/'+id,'DELETE').then(function(data) {
        $scope.classSchedule = data;
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.addSubOne = function(){
    $scope.form = {};
    $scope.views.editSub = false;
    $scope.views.addSub = true;
  }

  $scope.saveAddSub = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('classschedule/'+$scope.classId,'POST',{},$scope.form).then(function(data) {
      $scope.classSchedule = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.editSubOne = function(id){
    $('.overlay, .loading-img').show();
    $scope.form = {};
    dataFactory.httpRequest('classschedule/sub/'+id).then(function(data) {
      $scope.form = data;
      $scope.views.editSub = true;
      $scope.views.addSub = false;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEditSub = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('classschedule/sub/'+id,'POST',{},$scope.form).then(function(data) {
      $scope.classSchedule = data;
      $scope.views.editSub = false;
      $scope.views.addSub = false;
      $('.overlay, .loading-img').hide();
    });
  }  

  $scope.changeView = function(view){
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views.editSub = false;
    $scope.views.addSub = false;
    $scope.views[view] = true;
  }
});


Frelancers Group.controller('settingsController', function(dataFactory,$scope,$route) {
  $scope.views = {};
  $scope.form = {};
  $scope.languages = {};
  var methodName = $route.current.methodName;

  $scope.changeView = function(view){
    $scope.views.settings = false;
    $scope.views.terms = false;
    $scope.views[view] = true;
  }

  if(methodName == "settings"){
    dataFactory.httpRequest('siteSettings/langs').then(function(data) {
      $scope.languages = data.languages;
      $('.overlay, .loading-img').hide();
    });
    dataFactory.httpRequest('siteSettings/siteSettings').then(function(data) {
      $scope.form = data.settings;
      $('.overlay, .loading-img').hide();
    });
    $scope.changeView('settings');
  }else if(methodName == "terms"){
    dataFactory.httpRequest('siteSettings/terms').then(function(data) {
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
    $scope.changeView('terms');
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('siteSettings/siteSettings','POST',{},$scope.form).then(function(data) {
      $.gritter.add({
        title: 'Site settings',
        text: 'Settings updated successfully'
      });
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveTerms = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('siteSettings/terms','POST',{},$scope.form).then(function(data) {
      $.gritter.add({
        title: 'Site settings',
        text: 'Settings updated successfully'
      });
      $('.overlay, .loading-img').hide();
    });
  }

});

Frelancers Group.controller('attendanceController', function(dataFactory,$scope) {
  $scope.classes = {};
  $scope.attendanceModel;
  $scope.subjects = {};
  $scope.views = {};
  $scope.form = {};
  $scope.userRole ;
  $scope.class = {};
  $scope.subject = {};
  $scope.students = {};

  dataFactory.httpRequest('attendance').then(function(data) {
    $scope.classes = data.classes;
    $scope.subjects = data.subject;
    $scope.attendanceModel = data.attendanceModel;
    $scope.userRole = data.userRole;
    $scope.changeView('list');
    $('.overlay, .loading-img').hide();
  });

  $scope.startAttendance = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('attendance/list','POST',{},$scope.form).then(function(data) {
      $scope.class = data.class;
      if(data.subject){
        $scope.subject = data.subject;
      }
      $scope.students = data.students;
      $scope.changeView('lists');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveAttendance = function(){
    $('.overlay, .loading-img').show();
    $scope.form.classId = $scope.class.id;
    $scope.form.attendanceDay = $scope.form.attendanceDay;
    $scope.form.stAttendance = $scope.students;
    if($scope.subject.id){
      $scope.form.subject = $scope.subject.id;
    }
    dataFactory.httpRequest('attendance','POST',{},$scope.form).then(function(data) {
      $scope.changeView('list');
      $('.overlay, .loading-img').hide();
    });
  }  
  
  $scope.changeView = function(view){
    $scope.views.list = false;
    $scope.views.lists = false;
    $scope.views.edit = false;
    $scope.views.editSub = false;
    $scope.views.addSub = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('gradeLevelsController', function(dataFactory,$scope) {
  $scope.gradeLevels = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};

  dataFactory.httpRequest('gradeLevels/listAll').then(function(data) {
    $scope.gradeLevels = data;
    $('.overlay, .loading-img').hide();
  });
  
  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('gradeLevels','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.gradeLevels = data.grades;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('gradeLevels/'+id).then(function(data) {
      $scope.changeView('edit');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('gradeLevels/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.gradeLevels = data.grades;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this item?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('gradeLevels/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove grade',
            text: 'Grade removed successfully'
          });
          $scope.gradeLevels.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('examsListController', function(dataFactory,$scope,$sce) {
  $scope.examsList = {};
  $scope.classes = {};
  $scope.subjects = {};
  $scope.userRole ;
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};

  $scope.showModal = false;
  $scope.studentProfile = function(id){
    dataFactory.httpRequest('students/profile/'+id).then(function(data) {
      $scope.modalTitle = data.title;
      $scope.modalContent = $sce.trustAsHtml(data.content);      
      $scope.showModal = !$scope.showModal;
    });
  };
  
  dataFactory.httpRequest('examsList/listAll').then(function(data) {
    $scope.examsList = data.exams;
    $scope.classes = data.classes;
    $scope.subjects = data.subjects;
    $scope.userRole = data.userRole;
    $('.overlay, .loading-img').hide();
  });
  
  $scope.notify = function(id){
    var confirmNotify = confirm("Are you sure that all subject's marks added successfully?");
    if (confirmNotify == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('examsList/notify/'+id,'POST',{},$scope.form).then(function(data) {
        data = successOrError(data);
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('examsList','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.examsList = data.list;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('examsList/'+id).then(function(data) {
      $scope.changeView('edit');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('examsList/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.examsList = data.list;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this item?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('examsList/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove exam',
            text: 'Exam removed successfully'
          });
          $scope.examsList.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.marks = function(exam){
    $scope.form.exam = exam;
    $scope.changeView('premarks');
  }

  $scope.startAddMarks = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('examsList/getMarks/'+$scope.form.exam+"/"+$scope.form.classId+"/"+$scope.form.subjectId).then(function(data) {
      $scope.form.respExam = data.exam;
      $scope.form.respClass = data.class;
      $scope.form.respSubject = data.subject;
      $scope.form.respStudents = data.students;
      
      $scope.changeView('marks');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveNewMarks = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('examsList/saveMarks/'+$scope.form.exam+"/"+$scope.form.classId+"/"+$scope.form.subjectId,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      $scope.changeView('list');
      $('.overlay, .loading-img').hide();
    });
  }
  
  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views.premarks = false;
    $scope.views.marks = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('eventsController', function(dataFactory,$routeParams,$sce,$scope) {
  $scope.events = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};
  $scope.userRole ;

  if($routeParams.eventId){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('events/'+$routeParams.eventId).then(function(data) {
      $scope.form = data;
      $scope.form.eventDescription = $sce.trustAsHtml(data.eventDescription);
      $scope.changeView('read');
      $('.overlay, .loading-img').hide();
    });
  }else{
    dataFactory.httpRequest('events/listAll').then(function(data) {
      $scope.events = data.events;
      $scope.userRole = data.userRole;
      $('.overlay, .loading-img').hide();
    });
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('events/'+id).then(function(data) {
      $scope.changeView('edit');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('events/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.events = data.list.events;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this event?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('events/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove event',
            text: 'Event removed successfully'
          });
          $scope.events.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('events','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.events = data.list.events;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('assignmentsController', function(dataFactory,CSRF_TOKEN,$scope) {
  $scope.classes = {};
  $scope.subject = {};
  $scope.assignments = {};
  $scope.views = {};
  $scope.CSRF_TOKEN = CSRF_TOKEN;
  $scope.views.list = true;
  $scope.form = {};
  $scope.userRole ;

  dataFactory.httpRequest('assignments/listAll').then(function(data) {
    $scope.classes = data.classes;
    $scope.subject = data.subject;
    $scope.assignments = data.assignments;
    $scope.userRole = data.userRole
    $('.overlay, .loading-img').hide();
  });
  
  $scope.numberSelected = function(item){
    var count = $(item + " :selected").length;
    if(count == 0){
      return true;
    }
  }

  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('assignments/'+id).then(function(data) {
      $scope.changeView('edit');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(content){
    content = uploadSuccessOrError(content);
    if(content){
      $('.overlay, .loading-img').show();
      
      $scope.classes = content.list.classes;
      $scope.subject = content.list.subject;
      $scope.assignments = content.list.assignments;
      $scope.changeView('list');
      $('.overlay, .loading-img').hide();
    }
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this assignment?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('assignments/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove assignment',
            text: 'Assignment removed successfully'
          });
          $scope.assignments.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.saveAdd = function(content){
    content = uploadSuccessOrError(content);
    if(content){
      $('.overlay, .loading-img').show();
      
      $scope.classes = content.list.classes;
      $scope.subject = content.list.subject;
      $scope.assignments = content.list.assignments;
      $scope.changeView('list');
      $('.overlay, .loading-img').hide();
    }
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});


Frelancers Group.controller('mailsmsController', function(dataFactory,$scope) {
  $scope.classes = {};
  $scope.views = {};
  $scope.messages = {};
  $scope.views.send = true;

  $scope.form = {};
  $scope.formS = {};

  dataFactory.httpRequest('classes/listAll').then(function(data) {
    $scope.classes = data.classes;
    $scope.form.userType = 'teachers';
    $scope.form.sendForm = 'email';
    $('.overlay, .loading-img').hide();
  });
  
  $scope.getSents = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('mailsms/listAll').then(function(data) {
      $scope.messages = data;
      $scope.changeView('list');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.settings = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('mailsms/settings').then(function(data) {
      $scope.formS = data.sms;
      $scope.formM = data.mail;
      $scope.changeView('settings');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveSettings = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('mailsms/settings','POST',{},$scope.formS).then(function(data) {
      $.gritter.add({
        title: 'Mail / SMS',
        text: 'Settings saved successfully'
      });
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveMailSettings = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('mailsms/settings','POST',{},$scope.formM).then(function(data) {
      $.gritter.add({
        title: 'Mail / SMS',
        text: 'Settings saved successfully'
      });
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('mailsms','POST',{},$scope.form).then(function(data) {
      $.gritter.add({
        title: 'Mail / SMS',
        text: 'Message sent successfully'
      });
      $scope.messages = data;
      $scope.changeView('list');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "send"){
      $scope.form = {};
      $scope.form.userType = 'teachers';
      $scope.form.sendForm = 'email';
    }
    $scope.views.send = false;
    $scope.views.list = false;
    $scope.views.settings = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('messagesController', function(dataFactory,$route,$scope) {
  $scope.messages = {};
  $scope.message = {};
  $scope.messageDet = {};
  $scope.totalItems = 0;
  $scope.views = {};
  $scope.views.list = true;
  $scope.selectedAll = false;
  $scope.repeatCheck = true;
  $scope.form = {};
  $scope.messageBefore;
  $scope.messageAfter;
  var routeData = $route.current;
  var currentMessageRefreshId;

  $scope.totalItems = 0;
  $scope.pageChanged = function(newPage) {
    getResultsPage(newPage);
  };

  getResultsPage(1);
  function getResultsPage(pageNumber) {
     dataFactory.httpRequest('messages/listAll/'+pageNumber).then(function(data) {
      $scope.messages = data.messages;
      $scope.totalItems = data.totalItems;
      $('.overlay, .loading-img').hide();
    });
  }
  
  $scope.checkAll = function(){
    if ($scope.selectedAll) {
      $scope.selectedAll = true;
    } else {
      $scope.selectedAll = false;
    }
    angular.forEach($scope.messages, function (item) {
      item.selected = $scope.selectedAll;
    });
  }

  $scope.showMessage = function(id){
    $scope.repeatCheck = true;
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('messages/'+id).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.changeView('read');
        $scope.message = data.messages.reverse();
        $scope.messageDet = data.messageDet;
        if($scope.message[0]){
          $scope.messageBefore = $scope.message[0].dateSent;
        }
        if($scope.message[$scope.message.length - 1]){
          $scope.messageAfter = $scope.message[$scope.message.length - 1].dateSent;
        }
        currentMessageRefreshId = setInterval(currentMessagePull, 2000);
        $("#chat-box").slimScroll({ scrollTo: $("#chat-box").prop('scrollHeight')+'px' });
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.loadOld = function(){
    dataFactory.httpRequest('messages/before/'+$scope.messageDet.fromId+'/'+$scope.messageDet.toId+'/'+$scope.messageBefore).then(function(data) {
      angular.forEach(data, function (item) {
        $scope.message.splice(0, 0,item);
      });
      if(data.length == 0){
        $('#loadOld').hide();
      }
      $scope.messageBefore = $scope.message[0].dateSent;
    });
  }

  $scope.markRead = function(){
    $scope.form.items = [];
    angular.forEach($scope.messages, function (item, key) {
      if($scope.messages[key].selected){
        $scope.form.items.push(item.id);
        $scope.messages[key].messageStatus = 0;
      }
    });
    dataFactory.httpRequest('messages/read',"POST",{},$scope.form).then(function(data) {
      $.gritter.add({
        title: 'Messages',
        text: 'Messages marked as Read'
      });
    });
  }

  $scope.markUnRead = function(){
    $scope.form.items = [];
    angular.forEach($scope.messages, function (item, key) {
      if($scope.messages[key].selected){
        $scope.form.items.push(item.id);
        $scope.messages[key].messageStatus = 1;
      }
    });
    dataFactory.httpRequest('messages/unread',"POST",{},$scope.form).then(function(data) {
      $.gritter.add({
        title: 'Messages',
        text: 'Messages marked as unRead'
      });
    });
  }

  $scope.markDelete = function(){
    $scope.form.items = [];
    var len = $scope.messages.length
    while (len--) {
      if($scope.messages[len].selected){
        $scope.form.items.push($scope.messages[len].id);
        $scope.messages.splice(len,1);
      }
    }
    dataFactory.httpRequest('messages/delete',"POST",{},$scope.form).then(function(data) {
      $.gritter.add({
        title: 'Delete Messages',
        text: 'Messages Deleted successfully'
      });
    });
  }
  
  var currentMessagePull = function(){
    if('#'+routeData.originalPath == location.hash){
      dataFactory.httpRequest('messages/ajax/'+$scope.messageDet.fromId+'/'+$scope.messageDet.toId+'/'+$scope.messageAfter).then(function(data) {
        angular.forEach(data, function (item) {
          $scope.message.push(item);
          $("#chat-box").slimScroll({ scrollTo: $("#chat-box").prop('scrollHeight')+'px' });
        });
        if($scope.message[$scope.message.length - 1]){
          $scope.messageAfter = $scope.message[$scope.message.length - 1].dateSent;
        }
      });
    }else{
      clearInterval(currentMessageRefreshId);
    }
  };

  $scope.replyMessage = function(){
    $scope.form.disable = true;
    $scope.form.toId = $scope.messageDet.toId;
    dataFactory.httpRequest('messages/'+$scope.messageDet.id,'POST',{},$scope.form).then(function(data) {
      $("#chat-box").slimScroll({ scrollTo: $("#chat-box").prop('scrollHeight')+'px' });
      $scope.form = {}; 
    });
  }

  $scope.sendMessageNow = function(){
    dataFactory.httpRequest('messages','POST',{},$scope.form).then(function(data) {
      $scope.showMessage(data.messageId);
   });
  }

  $scope.changeView = function(view){
    if(view == "read" || view == "list" || view == "create"){
      $scope.form = {};
    }
    if(view == "list" || view == "create"){
      clearInterval(currentMessageRefreshId);
    }
    $scope.views.list = false;
    $scope.views.read = false;
    $scope.views.create = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('onlineExamsController', function(dataFactory,$scope,$sce) {
  $scope.classes = {};
  $scope.subject = {};
  $scope.onlineexams = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};
  $scope.marksExam ;
  $scope.marks = {};
  $scope.takeData = {};
  $scope.form.examQuestion = [];
  $scope.userRole ;

  $scope.showModal = false;
  $scope.studentProfile = function(id){
    dataFactory.httpRequest('students/profile/'+id).then(function(data) {
      $scope.modalTitle = data.title;
      $scope.modalContent = $sce.trustAsHtml(data.content);      
      $scope.showModal = !$scope.showModal;
    });
  };

  dataFactory.httpRequest('onlineExams/listAll').then(function(data) {
    $scope.classes = data.classes;
    $scope.subject = data.subjects;
    $scope.onlineexams = data.onlineExams;
    $scope.userRole = data.userRole;
    $('.overlay, .loading-img').hide();
  });

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this exam ?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('onlineExams/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove exam',
            text: 'Exam removed successfully'
          });
          $scope.onlineexams.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('onlineExams','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.onlineexams = data.list.onlineExams;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('onlineExams/'+id).then(function(data) {
      $scope.changeView('edit');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    console.log($scope.form);
    dataFactory.httpRequest('onlineExams/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.onlineexams = data.list.onlineExams;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.addQuestion = function(){
    if (typeof $scope.examTitle === "undefined" || $scope.examTitle == "") {
      alert("Exam title is undefined");
      return ;
    }

    var questionData = {};
    questionData.title = $scope.examTitle;

    if (typeof $scope.ans1 != "undefined" || $scope.ans1 != "") {
      questionData.ans1 = $scope.ans1;
    }
    if (typeof $scope.ans2 != "undefined" || $scope.ans2 != "") {
      questionData.ans2 = $scope.ans2;
    }
    if (typeof $scope.ans3 != "undefined" || $scope.ans3 != "") {
      questionData.ans3 = $scope.ans3;
    }
    if (typeof $scope.ans4 != "undefined" || $scope.ans4 != "") {
      questionData.ans4 = $scope.ans4;
    }
    if (typeof $scope.Tans != "undefined" || $scope.Tans != "") {
      questionData.Tans = $scope.Tans;
    }

    $scope.form.examQuestion.push(questionData);
    $scope.examTitle = "";
    $scope.ans1 = "";
    $scope.ans2 = "";
    $scope.ans3 = "";
    $scope.ans4 = "";
    $scope.Tans = "";
  }

  $scope.removeQuestion = function(index){
    $scope.form.examQuestion.splice(index,1);
  }

  $scope.take = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('onlineExams/'+id).then(function(data) {
      if (typeof data.finished != "undefined") {
        alert("You can't take this exam now");
        $('.overlay, .loading-img').hide();
        return;
      }
      if (typeof data.taken != "undefined") {
        alert("Tou already took this exam before");
        $('.overlay, .loading-img').hide();
        return;
      }
      
      $scope.changeView('take');
      $scope.takeData = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.submitExam = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('onlineExams/took/'+$scope.takeData.id,'POST',{},$scope.takeData).then(function(data) {
      if (typeof data.grade != "undefined") {
        alert("Your grade is : "+data.grade);
      }else{
        alert("Your submittion saved, thank you.");
      }
      $scope.changeView('list');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.marksData = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('onlineExams/marks/'+id).then(function(data) {
      $scope.marks = data;
      $scope.marksExam = id;
      $scope.changeView('marks');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
      $scope.form.examQuestion = [];
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views.take = false;
    $scope.views.marks = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('TransportsController', function(dataFactory,$scope,$rootScope) {
  $scope.transports = {};
  $scope.transportsList = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};
  $scope.userRole = $rootScope.dashboardData.role;

  dataFactory.httpRequest('transports/listAll').then(function(data) {
    $scope.transports = data;
    $('.overlay, .loading-img').hide();
  });
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('transports/'+id).then(function(data) {
      $scope.changeView('edit');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('transports/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.transports = data.transportation;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this transport?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('transports/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove Transport',
            text: 'Transport removed successfully'
          });
          $scope.transports.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('transports','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.transports = data.transportation;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.list = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('transports/list/'+id).then(function(data) {
      $scope.changeView('listSubs');
      $scope.transportsList = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views.listSubs = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('mediaController', function($rootScope,dataFactory,CSRF_TOKEN,$scope) {
  $scope.albums = {};
  $scope.media = {};
  $scope.dirParent = -1;
  $scope.dirNow = 0;
  $scope.views = {};
  $scope.views.list = true;
  $scope.userRole = $rootScope.dashboardData.role;
  $scope.form = {};
  $scope.CSRF_TOKEN = CSRF_TOKEN;

  dataFactory.httpRequest('media/listAll').then(function(data) {
    $scope.albums = data.albums;
    $scope.media = data.media;
    $scope.dirParent = -1;
    $scope.dirNow = 0;
    $('.overlay, .loading-img').hide();
  });

  $scope.chDir = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('media/listAll/'+id).then(function(data) {
      $scope.albums = data.albums;
      $scope.media = data.media;
      if(data.current){
        $scope.dirParent = data.current.albumParent;
        $scope.dirNow = id;
      }else{
        $scope.dirParent = -1;
        $scope.dirNow = 0;
      }
      $scope.changeView('list');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveAlbum = function(content){
    content = uploadSuccessOrError(content);
    if(content != false){
      $('.overlay, .loading-img').show();
      
      $scope.albums = content.list.albums;
      $scope.media = content.list.media;
      $scope.changeView('list');
    }
    $('.overlay, .loading-img').hide();
  }

  $scope.removeAlbum = function(item,index){
    var confirmRemove = confirm("Sure remove this album, all enclosed images will be deleted?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('media/album/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove Album',
            text: 'Album removed successfully'
          });
          $scope.albums.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }
  
  $scope.editAlbumData = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('media/editAlbum/'+id).then(function(data) {
      $scope.changeView('editAlbum');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEditAlbum = function(content){
    content = uploadSuccessOrError(content);
    if(content != false){
      $('.overlay, .loading-img').show();
      
      $scope.albums = content.list.albums;
      $scope.media = content.list.media;
      $scope.changeView('list');
    }
    $('.overlay, .loading-img').hide();
  }

  $scope.saveMedia = function(content){
    content = uploadSuccessOrError(content);
    if(content != false){
      $('.overlay, .loading-img').show();
      
      $scope.albums = content.list.albums;
      $scope.media = content.list.media;
      $scope.changeView('list');
    }
    $('.overlay, .loading-img').hide();
  }

  $scope.editItem = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('media/'+id).then(function(data) {
      $scope.changeView('editMedia');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEditItem = function(content){
    content = uploadSuccessOrError(content);
    if(content != false){
      $('.overlay, .loading-img').show();
      
      $scope.albums = content.list.albums;
      $scope.media = content.list.media;
      $scope.changeView('list');
    }
    $('.overlay, .loading-img').hide();
  }

  $scope.removeItem = function(item,index){
    var confirmRemove = confirm("Sure remove this item ?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('media/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove item',
            text: 'Item removed successfully'
          });
          $scope.media.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.addAlbum = false;
    $scope.views.editAlbum = false;
    $scope.views.addMedia = false;
    $scope.views.editMedia = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('staticController', function(dataFactory,$routeParams,$scope,$sce,$rootScope) {
  $scope.staticPages = {};
  $scope.views = {};
  $scope.form = {};
  $scope.userRole = $rootScope.dashboardData.role;
  $scope.pageId = $routeParams.pageId;

  if (typeof $scope.pageId != "undefined" && $scope.pageId != "") {
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('static/'+$scope.pageId).then(function(data) {
      $scope.changeView('show');
      $scope.form.pageTitle = data.pageTitle;
      $scope.form.pageContent = $sce.trustAsHtml(data.pageContent);
      $('.overlay, .loading-img').hide();
    });
  }else{
    dataFactory.httpRequest('static/listAll').then(function(data) {
      $scope.staticPages = data;
      $scope.changeView('list');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('static','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.staticPages = data.staticPages;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('static/'+id).then(function(data) {
      $scope.changeView('edit');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('static/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.staticPages = data.staticPages;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this Page?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('static/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove page',
            text: 'Page removed successfully'
          });
          $scope.staticPages.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.pageActive = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('static/active/'+id).then(function(data) {
      $scope.staticPages = data.staticPages;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views.show = false;
    $scope.views.listSubs = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('attendanceStatsController', function(dataFactory,$scope,$sce) {
  $scope.attendanceStats = {};
  $scope.attendanceData = {};
  $scope.userRole;
  $scope.views = {};
  $scope.form = {};

  $scope.showModal = false;
  $scope.studentProfile = function(id){
    dataFactory.httpRequest('students/profile/'+id).then(function(data) {
      $scope.modalTitle = data.title;
      $scope.modalContent = $sce.trustAsHtml(data.content);
      $scope.showModal = !$scope.showModal;
    });
  };

  dataFactory.httpRequest('attendance/stats').then(function(data) {
    $scope.attendanceStats = data;
    if(data.role == "admin" || data.role == "teacher"){
      $scope.views.list = true;
    }else if(data.role == "student"){
      $scope.changeView('lists');
    }else if(data.role == "parent"){
      $scope.changeView('listp');
    }
    $scope.userRole = data.attendanceModel;
    $('.overlay, .loading-img').hide();
  });

  $scope.statsAttendance = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('attendance/stats','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.attendanceData = data;
        $scope.changeView('listdata');
      }
      $('.overlay, .loading-img').hide();
    });
  }
  
  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.listdata = false;
    $scope.views.lists = false;
    $scope.views.listp = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('pollsController', function(dataFactory,$scope) {
  $scope.polls = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};

  dataFactory.httpRequest('polls/listAll').then(function(data) {
    $scope.polls = data;
    $('.overlay, .loading-img').hide();
  });

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this poll?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('polls/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove Poll',
            text: 'Poll removed successfully'
          });
          $scope.polls.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.addPollOption = function(item){
    var optionTitle = prompt("Please enter option title");
    if (optionTitle != null) {
      if (typeof $scope.form.pollOptions === "undefined" || $scope.form.pollOptions == "") {
        $scope.form.pollOptions = [];
      }
      var newOption = {'title':optionTitle};
      $scope.form.pollOptions.push(newOption);
    }
  }

  $scope.removePollOption = function(item,index){
    $scope.form.pollOptions.splice(index,1);
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('polls/'+id).then(function(data) {
      $scope.changeView('edit');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('polls/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.polls = data.polls;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('polls','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.polls = data.polls;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.makeActive = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('polls/active/'+id,'POST',{}).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.polls = data.polls;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('mailsmsTemplatesController', function(dataFactory,$scope) {
  $scope.templates = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};

  dataFactory.httpRequest('MailSMSTemplates/listAll').then(function(data) {
    $scope.templates = data;
    $('.overlay, .loading-img').hide();
  });
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('MailSMSTemplates/'+id).then(function(data) {
      $scope.changeView('edit');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('MailSMSTemplates/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('dormitoriesController', function(dataFactory,$scope) {
  $scope.dormitories = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};

  dataFactory.httpRequest('dormitories/listAll').then(function(data) {
    $scope.dormitories = data;
    $('.overlay, .loading-img').hide();
  });
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('dormitories/'+id).then(function(data) {
      $scope.changeView('edit');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('dormitories/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.dormitories = data.dormitories;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this dormitory?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('dormitories/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove Dormitory',
            text: 'Dormitory removed successfully'
          });
          $scope.dormitories.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('dormitories','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.dormitories = data.dormitories;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('paymentsController', function(dataFactory,$scope,$sce,$rootScope) {
  $scope.payments = {};
  $scope.students = {};
  $scope.classes = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};
  $scope.invoice = {};
  $scope.payDetails = {};
  $scope.userRole = $rootScope.dashboardData.role;

  $scope.showModal = false;
  $scope.studentProfile = function(id){
    dataFactory.httpRequest('students/profile/'+id).then(function(data) {
      $scope.modalTitle = data.title;
      $scope.modalContent = $sce.trustAsHtml(data.content);      
      $scope.showModal = !$scope.showModal;
    });
  };

  dataFactory.httpRequest('payments/listAll').then(function(data) {
    $scope.payments = data.payments;
    $scope.students = data.students;
    $scope.classes = data.classes;
    $('.overlay, .loading-img').hide();
  });

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this payment?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('payments/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove payment',
            text: 'Payment removed successfully'
          });
          $scope.payments.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('payments','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.payments = data.payments.payments;
        $scope.students = data.payments.students;
        $scope.classes = data.payments.classes;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('payments/'+id).then(function(data) {
      $scope.form = data;
      $scope.changeView('edit');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('payments/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.payments = data.payments.payments;
        $scope.students = data.payments.students;
        $scope.classes = data.payments.classes;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.seeInvoice = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('payments/invoice/'+id).then(function(data) {
      $scope.invoice = data;
      $scope.changeView('invoice');
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.alertPaidData = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('payments/details/'+id).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.payDetails = data;
        $scope.changeView('details');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views.invoice = false;
    $scope.views.details = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('languagesController', function(dataFactory,$scope) {
  $scope.languages = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};

  dataFactory.httpRequest('languages/listAll').then(function(data) {
    $scope.languages = data;
    $('.overlay, .loading-img').hide();
  });
  
  $scope.edit = function(id){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('languages/'+id).then(function(data) {
      $scope.changeView('edit');
      $scope.form = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.saveEdit = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('languages/'+$scope.form.id,'POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.languages = data.languages;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.remove = function(item,index){
    var confirmRemove = confirm("Sure remove this language?");
    if (confirmRemove == true) {
      $('.overlay, .loading-img').show();
      dataFactory.httpRequest('languages/'+item.id,'DELETE').then(function(data) {
        if(data == 1){
          $.gritter.add({
            title: 'Remove languages',
            text: 'Language removed successfully'
          });
          $scope.languages.splice(index,1);
        }
        $('.overlay, .loading-img').hide();
      });
    }
  }

  $scope.saveAdd = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('languages','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        $scope.languages = data.languages;
        $scope.changeView('list');
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});

Frelancers Group.controller('promotionController', function(dataFactory,$scope) {
  $scope.classes = {};
  $scope.students = {};
  $scope.views = {};
  $scope.views.list = true;
  $scope.form = {};

  dataFactory.httpRequest('promotion/listData').then(function(data) {
    $scope.classes = data.classes;
    $('.overlay, .loading-img').hide();
  });

  $scope.studentListUpdate = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('promotion/listStudents/' + $scope.form.classId).then(function(data) {
      $scope.students = data;
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.promoteNow = function(){
    $('.overlay, .loading-img').show();
    dataFactory.httpRequest('promotion','POST',{},$scope.form).then(function(data) {
      data = successOrError(data);
      if(data){
        alert("Students promoted successfully");
      }
      $('.overlay, .loading-img').hide();
    });
  }

  $scope.changeView = function(view){
    if(view == "add" || view == "list" || view == "show"){
      $scope.form = {};
    }
    $scope.views.list = false;
    $scope.views.add = false;
    $scope.views.edit = false;
    $scope.views[view] = true;
  }
});