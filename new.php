<?php
 // set_time_limit(30);
 $starttime = time();

require 'simple_html_dom.php';
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=export.csv');
header("Content-type:application/pdf");
// header("Content-Disposition:attachment;filename='export.pdf'");
 echo "Enter your csv file name: ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
if(trim($line) != 'sample.csv'){
    echo "Enter a correct file name!\n";
    exit;
}
$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
$context = stream_context_create($opts);
  $filename = explode(".", 'sample.csv');
  if($filename[1] == 'csv')
  {
   $handle = fopen('sample.csv', "r");
   while($data = fgetcsv($handle))
   {
     // echo $data.'\n';
      for( $i=1; $i<3;$i++)
      {
      $x = json_encode($data[1]);
      $y = json_encode($data[2]);
      $ht= file_get_contents('http://www.fantasy.mn/checkcerts/GetData.aspx?weight=1.06&certno=1305598611&lab=GIA',false,$context);
       // $htm = file_get_contents('http://www.fantasy.mn/checkcerts/JSON.aspx?lab=GIA&color=&weight=1.06&certificateid=1305598611&PDF=1',false,$context);
       file_put_contents("export.pdf", file_get_contents("http://www.fantasy.mn/checkcerts/JSON.aspx?lab=GIA&color=&weight=1.06&certificateid=1305598611&PDF=1"));

      $html = str_get_html($ht);
      // $html2 = str_get_html($htm);
       $fp = fopen("../csv/export.csv", "w");
       // $fr = fopen("../csv/export.pdf", "w");

      foreach($html->find('tr') as $element)
      {
          $td = array();
          foreach( $element->find('th') as $row)
          {
              $td [] = $row->plaintext;
          }
          fputcsv($fp, $td);

          $td = array();
          foreach( $element->find('td') as $row)
          {
              $td [] = $row->plaintext;
          }
         fputcsv($fp, $td);
          // readfile($htm);
      }
      $now = time()-$starttime;
         if ($now > 10) {             //assuming you're looking at 30 seconds
         die();
         }
          // echo $item[$i];
                // $item2 = mysqli_real_escape_string($connect, $data[1]);(STOCK_NO,STOCK_CERTIFICATE,LAB,SHAPE,SIZE,COLOR,CLARITY,CUT,POLISH,SYMMETRY,FLOUR,DISCOUNT,PR/CT,MEASURMENTS,DEPTH,TABLES,IMAGE_LINKS,KEY_SYMBOL)
      }

   }


   echo "<script>alert('Import done');</script>";
  }
  fclose($handle);

     fclose($fp);

//
//
//
//
//
//
//

?>
