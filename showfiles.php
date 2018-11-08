

<table  class="table table-striped ">

  <thead >
    <tr>
      <th scope="col">File ID</th>
      <th scope="col">File Name</th>
      <th scope="col">Requested On</th>
      <th scope="col">View File</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $company = $_GET['company'];
      $db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
      mysqli_set_charset($db, "utf8");
        if (mysqli_connect_errno()){
          echo 'Error In Database Connection';
          exit;
        }
      $db->select_db('uploads');
      $query = "SELECT id,path,filename,uploadedon FROM uploads WHERE company=REPLACE((SELECT company FROM companies WHERE id= ".$company."),' ','_') order by filename ASC";
      $result = mysqli_query($db,$query) or die(mysqli_error());
      $num_rows = mysqli_num_rows($result);
        if($num_rows > 0){
          while($row = mysqli_fetch_assoc($result)){
            $userid = $row['id'];
            $rname = $row['filename'];
            $requested = $row['uploadedon'];
            $pathtofile = $row['path'];

            ?>
            <tr>
              <th style="width: 10%;font-weight:bold;" scope="row"><?php echo $userid; ?></th>
              <td style="width: 40%;font-weight:bold;" scope="row"><?php echo $rname; ?></a></td>
              <td style="width: 30%;font-weight:bold;" scope="row"><?php echo $requested; ?></td>
              <td style="width: 20%" scope="row"> <a href="<?php echo $pathtofile.$rname ?>"> <button type="button"  class="btn btn-success btn-block"><i class="fa fa-search"></i> View Report</button></a></td>
            </tr>
            <?php
          }
        }
      $db->close();
    ?>

  </tbody>
</table>
