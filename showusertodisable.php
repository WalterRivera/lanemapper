

<table  class="table table-striped ">

  <thead >
    <tr>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email</th>
      <th scope="col">Enable/Disable</th>
      <th scope="col">Reset Password</th>
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
      $db->select_db('users');
      $query = "SELECT id,email,first_name,last_name,access,is_admin,is_account_admin FROM users WHERE company=(SELECT company FROM companies WHERE id=".$company.") order by access DESC, first_name ASC";
      $result = mysqli_query($db,$query) or die(mysqli_error());
      $num_rows = mysqli_num_rows($result);
        if($num_rows > 0){
          while($row = mysqli_fetch_assoc($result)){
            $userid = $row['id'];
            $fname = $row['first_name'];
            $lname = $row['last_name'];
            $email = $row['email'];
            $acess = $row['access'];
            $mapperadmin = $row['is_admin'];
            $accountadmin = $row['is_account_admin'];

            ?>
            <tr>
              <th style="width: 15%;font-weight:bold;" scope="row"><?php echo $fname; ?></th>
              <td style="width: 15%;font-weight:bold;" scope="row"><?php echo $lname; ?></a></td>
              <td style="width: 20%;font-weight:bold;" scope="row"><?php echo $email; ?></td>
              <?php
                if($acess == 0){
                  ?>
                  <td style="width: 20%" scope="row"><button type="button" class="btn btn-danger btn-block" onclick="changeuseraccess(1,<?php echo $userid; ?>)" > Disabled</button></td>
                  <?php
                }else{
                  ?>
                  <td style="width: 20%" scope="row"><button type="button" class="btn btn-success btn-block" onclick="changeuseraccess(0,<?php echo $userid; ?>)" > Enabled</button></td>
                  <td style="width: 20%;font-weight:bold;" scope="row"><button type="button" class="btn btn-info btn-block" onclick="resetpassword(<?php echo $userid; ?>,'<?php echo $email; ?>')" > Reset Password</button></td>
                  <?php
                }


              ?>

            </tr>
            <?php
          }
        }
      $db->close();
    ?>

  </tbody>
</table>
