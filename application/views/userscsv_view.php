<?php

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
 <head> 
   <meta charset="utf-8"> 
   <title>Export MySQL data to CSV file in CodeIgniter 3</title>
 </head>
 <body>
   <!-- Export Data --> 
   <a href='<?= base_url() ?>Csv_file/exportCSV'>Export</a><br><br>

   <!-- User Records --> 
   <table border='1' style='border-collapse: collapse;'> 
     <thead> 
      <tr> 
      
       <th>Name</th>
       <th>Phone</th>
       <th>Email</th> 
      </tr> 
     </thead> 
     <tbody> 
     <?php
     foreach($usersData as $key=>$val){ 
       echo "<tr>";
       echo "<td>".$val['name']."</td>";
       echo "<td>".$val['phone']."</td>"; 
       echo "<td>".$val['email']."</td>"; 
       echo "</tr>"; 
      } 
      ?> 
     </tbody> 
    </table>
  </body>
</html>