<!DOCTYPE html>
<html lang="en">
<head>
 
<style type="text/css">
      * {
        margin: 0;
        padding: 0;
        text-indent: 0;
      }
      body {
max-width: max-content;
margin: auto;
}
      h1 {
        color: #383838;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        
      }

      .p,
      p {
        color: #383838;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        
        margin: 0pt;
      }

      .s1 {
        color: #383838;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        
        vertical-align: 4pt;
      }

      .s2 {
        color: #383838;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        
        vertical-align: -4pt;
      }

      h2 {
        color: #383838;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: underline;
        font-size: 7.5pt;
      }

      .s3 {
        color: #383838;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 7.5pt;
      }

      .s4 {
        color: #383838;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        
      }

      table,
      tbody {
        vertical-align: top;
        overflow: visible;
      }
      .tablereport{

      }

      table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

      
    </style>
</head>
<body>

<?php 
 
// Load the database configuration file 
//include_once 'dbConfig.php'; 
 
// Include PhpSpreadsheet library autoloader 
require_once 'vendor/autoload.php'; 
use PhpOffice\PhpSpreadsheet\Reader\Xlsx; 
 
if(isset($_POST['importSubmit'])){ 
     
    // Allowed mime types 
    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
     
    // Validate whether selected file is a Excel file 
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)){ 
         
        // If the file is uploaded 
        if(is_uploaded_file($_FILES['file']['tmp_name'])){ 
            $reader = new Xlsx(); 
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']); 
            $worksheet = $spreadsheet->getActiveSheet();  
            $worksheet_arr = $worksheet->toArray(); 
          //  $count= (int)count($worksheet_arr);
 
            // Remove first 7 rows
            unset($worksheet_arr[0]); 
            unset($worksheet_arr[1]); 
            unset($worksheet_arr[2]); 
            unset($worksheet_arr[3]); 
            unset($worksheet_arr[4]); 
            unset($worksheet_arr[5]); 
            unset($worksheet_arr[6]); 
           echo ' <h1>DAILY SALES REPORT</h1>
		  <p> DETSY ENTERPRISE (BUMBUNG-PJ SEA PARK)</p>
		   <table class="tablereport"><thead><tr><td>DATE</td><td>DOCUMENT</td><td>AMOUNT<br>(EXCLUDE TAX)</td><td>DISC<br>ADJ.</td><td>TAX</td><td>AMOUNT<br>(INCLUDE TAX)</td></tr></thead><tbody>';
    // echo '<pre>';
       //     print_r($worksheet_arr);
        //    echo '</pre>';
           
          // echo $count;
         //  echo '<br>';
 
            foreach($worksheet_arr as $row){ 
                     $date = $row[0];
              $document  = str_replace('C200', ' ', $row[1]);              
               // $type  = $row[5];
                $amount_exclude_tax  = $row[6];
                $disc_adj  = $row[7];
                $tax  = $row[8];
                $amount_include_tax  = $row[9];

                if(!str_starts_with($date,'TOTAL') )
                     {
           // echo $date.'-'. $document.'-'. $type.'-'. $amount_exclude_tax.'-'. $disc_adj.'-'. $tax.'-'. $amount_include_tax/*.'-'. $count.'-'.$ii*/;
            echo '<tr><td >'.$date.'</td><td>'. $document.'</td><td>'. $amount_exclude_tax.'</td><td>'. $disc_adj.'</td><td>'. $tax.'</td><td>'. $amount_include_tax.'</td></tr>';
               // echo '<br>';
            }
              
            } 

            echo '</tbody></table>';
             die();
            $qstring = '?status=succ'; 
        }else{ 
            $qstring = '?status=err'; 
        } 
    }else{ 
        $qstring = '?status=invalid_file'; 
    } 
} 
 
// Redirect to the listing page 
header("Location: index.php".$qstring); 
 
?>


</body>
</html>