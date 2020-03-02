<?php require_once("init.php")?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gallery System</title>
    
    <!-- Custom CSS for Dropzone css-->
    <link href="css/dropzone.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    
    <!-- Custom CSS for SIDEBAR in Edit Photo page -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    
    
                            <!-- Java Script && JQuery -->
    
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- Pie Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    
     <!-- Pie Chart Script --> 
    <script type="text/javascript">
      
      // Load Charts and the corechart package.
      google.charts.load('current', {'packages':['corechart']});
      
      // Draw the pie chart 1 and 2
      google.charts.setOnLoadCallback(drawChart_Photos);
      google.charts.setOnLoadCallback(drawChart_UserPhotos);
      google.charts.setOnLoadCallback(drawChart_Users);
      google.charts.setOnLoadCallback(drawChart_Comments);

      // Callback that draws the pie chart 1
      function drawChart_Photos() {

        var data = google.visualization.arrayToDataTable([
          ['photo_status', 'Photo Count'],
          ['draft',<? echo Photo::counter_approved(); ?>],
          ['published',<? echo Photo::counter_unapproved();?>]
        ]);

        var options = {
          title: 'Photos Status',
          width:500,
          height:400
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_Photos'));

        chart.draw(data, options);
      }
      
      // Callback that draws the pie chart 2
      function drawChart_UserPhotos() {
        var data = google.visualization.arrayToDataTable([
          ['User admin', 'count photos'],
          <? $admin_users = User::get_admin_users(); ?>
          <? foreach($admin_users as $admin_user): ?>
          <? 
            $user_photos = Photo::find_photos_by_userID($admin_user->user_id);
            $count_user_photos = count($user_photos);
          ?>
          ['<? echo $admin_user->username; ?>', <? echo $count_user_photos; ?> ],
          <? endforeach; ?>
          ['', 0]
        ]);

        var options = {
          title: 'Users Photos',
          width:500,
          height:400
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_UserPhotos'));

        chart.draw(data, options);
      }
      
                                        
      // Callback that draws the pie chart 3
      function drawChart_Users() {

        var data = google.visualization.arrayToDataTable([
          ['User_role', 'User Count'],
          ['admin',<? echo User::counter_approved() ?>],
          ['subscriber',<? echo User::counter_unapproved() ?>]
        ]);

        var options = {
          title: 'Users Role',
          width:500,
          height:400
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_Users'));

        chart.draw(data, options);
      }                        

        
      // Callback that draws the pie chart 4
      function drawChart_Comments() {

        var data = google.visualization.arrayToDataTable([
          ['Comment Status', 'Comment Count'],
          ['pinned',<? echo Comment::counter_approved() ?>],
          ['unpinned',<? echo Comment::counter_unapproved() ?>]
        ]);

        var options = {
          title: 'Comments Status',
          width:500,
          height:400
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_Comments'));

        chart.draw(data, options);
      }
    </script>
    
    
    
</head>

<body>

    <div id="wrapper">
        