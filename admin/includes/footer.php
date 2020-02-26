  </div>
    <!-- /#wrapper -->
   

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- javascript dropzone -->
    <script src="js/dropzone.js"></script>
   
   <!-- javascript custome scripts -->
    <script src="js/scripts.js"></script>
   
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    
    
    
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
          ['draft',<? echo Photo::draft_counter(); ?>],
          ['published',<? echo Photo::published_counter();?>]
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
          ['admin',<? echo User::admin_counter() ?>],
          ['subscriber',<? echo User::subscriber_counter() ?>]
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
          ['pinned',<? echo Comment::pinned_counter() ?>],
          ['unpinned',<? echo Comment::unpinned_counter() ?>]
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

</body>

</html>

