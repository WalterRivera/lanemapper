
<?php
$company = $_GET['company'];
?>

<table  class="table table-striped ">

  <thead >
    <tr>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Account Admin</th>
      <?php
        if($company == 1){


       ?>
      <th scope="col">LaneMapper Admin</th>
      <?php
        }
       ?>
      <th scope="col">Save</th>
    </tr>
  </thead>
  <tbody>
    <?php

      $db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
      mysqli_set_charset($db, "utf8");
        if (mysqli_connect_errno()){
          echo 'Error In Database Connection';
          exit;
        }
      $db->select_db('users');
      $query = "SELECT id,first_name,last_name,access,is_admin,is_account_admin FROM users WHERE company=(SELECT company FROM companies WHERE id=".$company.") order by access DESC, first_name ASC";
      $result = mysqli_query($db,$query) or die(mysqli_error());
      $num_rows = mysqli_num_rows($result);
        if($num_rows > 0){
          while($row = mysqli_fetch_assoc($result)){
            $access = $row['access'];
            $userid = $row['id'];
            $fname = $row['first_name'];
            $lname = $row['last_name'];
            $mapperadmin = $row['is_admin'];
            $accountadmin = $row['is_account_admin'];

            ?>
            <tr>
              <th style="width: 15%;font-weight:bold;" scope="row"><?php echo $fname; ?></th>
              <td style="width: 15%;font-weight:bold;" scope="row"><?php echo $lname; ?></a></td>
              <td style="width: 20%;font-weight:bold;" scope="row">
                <?php
                  if($access == 1){
                ?>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="manageadminaccount<?php echo $userid ?>" <?php if($accountadmin == 1){?> checked <?php } ?>>
                  <label class="custom-control-label" for="manageadminaccount<?php echo $userid ?>"></label>
                </div>
              </td>
              <?php
              if($company == 1){
               ?>
              <td style="width: 25%;font-weight:bold;" scope="row">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="manageadminmapper<?php echo $userid ?>" <?php if($mapperadmin == 1){?> checked <?php } ?>>
                  <label class="custom-control-label" for="manageadminmapper<?php echo $userid ?>"></label>
                </div>
              </td>
              <?php
                }
               ?>
              <td style="width: 25%" scope="row"><button type="button" class="btn btn-success btn-block" onclick="saveadmins(<?php echo $userid; ?>)" ><i class="fa fa-floppy-o"></i> Save</button></td>

            </tr>
            <?php
            }
          }
        }
      $db->close();
    ?>

  </tbody>
</table>
