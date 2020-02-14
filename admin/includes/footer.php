  </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- javascript -->
    <script src="js/scripts.js"></script>
   
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <!-- Pie Chart Script -->
    <script type="text/javascript">
      
      // Load Charts and the corechart package.
      google.charts.load('current', {'packages':['corechart']});
      
      // Draw the pie chart 1 and 2
      google.charts.setOnLoadCallback(drawChart_Photos);
      google.charts.setOnLoadCallback(drawChart_Users);
      google.charts.setOnLoadCallback(drawChart_Comments);
      google.charts.setOnLoadCallback(drawChart_Categories);

      // Callback that draws the pie chart 1
      function drawChart_Photos() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          width:500,
          height:400
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_Photos'));

        chart.draw(data, options);
      }
      
      // Callback that draws the pie chart 2
      function drawChart_Users() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          width:500,
          height:400
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_Users'));

        chart.draw(data, options);
      }
      
                                        
      // Callback that draws the pie chart 2
      function drawChart_Comments() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          width:500,
          height:400
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_Comments'));

        chart.draw(data, options);
      }                        

        
      // Callback that draws the pie chart 2
      function drawChart_Categories() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          width:500,
          height:400
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_Categories'));

        chart.draw(data, options);
      }
    </script>

</body>

</html>
