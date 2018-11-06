

<table  class="table table-sm ">

  <thead >
    <tr>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email</th>
      <th scope="col">Access</th>
      <th scope="col">Enable/Disable</th>
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
      $query = "SELECT email,first_name,last_name,access,is_admin,is_account_admin FROM users WHERE company=(SELECT company FROM companies WHERE id=".$company.") order by access DESC, first_name ASC";
      $result = mysqli_query($db,$query) or die(mysqli_error());
      $num_rows = mysqli_num_rows($result);
        if($num_rows > 0){
          while($row = mysqli_fetch_assoc($result)){

            $fname = $row['first_name'];
            $lname = $row['last_name'];
            $email = $row['email'];
            $acess = $row['access'];
            $mapperadmin = $row['is_admin'];
            $accountadmin = $row['is_account_admin'];

            ?>
            <tr>
              <th style="width: 20%;font-weight:bold;" scope="row"><?php echo $fname; ?></th>
              <td style="width: 20%;font-weight:bold;" scope="row"><?php echo $lname; ?></a></td>
              <td style="width: 20%;font-weight:bold;" scope="row"><?php echo $email; ?></td>
              <td style="width: 10%" scope="row"><?php echo $acess; ?></td>
              <?php
                if($acess == 0){
                  ?>
                  <td style="width: 30%" scope="row"><button type="button" class="btn btn-success btn-block" ><i class="fa fa-user-plus"></i> Enable</button></td>
                  <?php
                }else{
                  ?>
                  <td style="width: 30%" scope="row"><button type="button" class="btn btn-danger btn-block" ><i class="fa fa-user-times"></i> Disable</button></td>
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
