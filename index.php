
<!-- database connection code -->
<?php 

  $db = mysqli_connect("localhost", "root", "", "newstoday");

  if($db){
    // echo "Database connection established!";
  }else{
    echo "Database connection error!";
  }

  ob_start();

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- custom css file link -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>News Today!</title>
  </head>
  <body>

    <center class="my-5">
      <h1>CRUD Operation</h1>
    </center>

    <div class="container">
      <div class="row">
        <!--create operation -->
        <div class="col-md-6">
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Add New Category</label>
              <input type="text" class="form-control" placeholder="Category Name"  name="cat_name">
            </div>
            <div class="mb-3">
              <label class="form-label">Category Description</label>
              <textarea name="desc" class="form-control" rows="3"></textarea>
            </div>
            <input type="submit" class="btn btn-md btn-primary" name="add_cat" value="Add Category">
          </form>

           <!--Update Operation-->

           <?php

           if(isset($_GET['edit_id'])){
            $edit_id = $_GET['edit_id'];
            $update_form = "SELECT * FROM Category WHERE   c_id = $edit_id ";
            $update_result = mysqli_query($db, $update_form );
            while ($row = mysqli_fetch_assoc($update_result)) {
              $c_name = $row['c_name'];
              $c_desc = $row['c_desc'];
            }

            ?>
            <form method="POST">
            <h1 class="mt-5">Update Information</h1>
            <div class="mb-3">
              <label class="form-label">Add New Category</label>
              <input type="text" class="form-control" placeholder="Category Name"  name="cat_name" value="<?php echo $c_name;?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Category Description</label>
              <textarea name="desc" class="form-control" rows="3">
               <?php echo  $c_desc;?>
              </textarea>
            </div>
            <input type="submit" class="btn btn-md btn-primary" name="update_cat" value="Update Category">
          </form>
            <?php 

              }

           ?>
             
        </div>

       

        <?php 

          // create operation
          if(isset($_POST['add_cat'])){
             $cat_name  = $_POST['cat_name'];
             $desc      = $_POST['desc'];

            // send value to the database

             $insert_value = "INSERT INTO category (c_name,c_desc) VALUES ('$cat_name','$desc')";
             $result = mysqli_query($db,$insert_value);

             if($result){
              header('Location: index.php');
             }else{
              echo "Error!";
             }

          }



          //update information
          if(isset($_POST['update_cat'])){
            $name = $_POST['cat_name'];
            $desc = $_POST['desc'];

            $update = "UPDATE category SET c_name = '$name', c_desc='$desc' WHERE c_id = '$edit_id' ";
            $update_result = mysqli_query($db, $update );

            if($update_result){
              header('Location: index.php');
             }else{
              echo "Error!";
             }

          }

        ?>


        <!-- table (read operation) -->
        <div class="col-md-6">
          <table class="table  table-hover">
            <thead>
              <tr>
                <th scope="col">Serial</th>
                <th scope="col">Name</th>
                <th scope="col">Desciption</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>

              <?php 

              // read from database
              // 3

              $show_data = "SELECT * FROM category";
              $result = mysqli_query($db,$show_data);

              $count = 0;

              while($row = mysqli_fetch_assoc($result)){
                  $c_id   = $row['c_id'];
                  $c_name = $row['c_name'];
                  $c_desc = $row['c_desc'];
                  $count++;
              ?>
                  
                  <tr>
                    <th scope="row"><?php echo $count;?></th>
                    <td><?php echo $c_name;?></td>
                    <td><?php echo $c_desc;?></td>
                    <td>
                     <a class="mx-2" href="index.php?edit_id=<?php echo $c_id;?>" >
                        <span >Edit</span>
                      </a>
                      <a href="index.php?delete_id=<?php echo $c_id;?>" >
                        <span >Delete</span>
                      </a>
                    </td>
                  </tr>
              <?php
              }

              ?>

              
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php 

      // delete operation

      if(isset($_GET['delete_id'])){
        $del_id = $_GET['delete_id'];

        // delete

        $sql3 = "DELETE FROM category WHERE c_id = '$del_id'";
        $result = mysqli_query($db,$sql3);

        if($result){
          header('Location: index.php');
        }else{
          echo "Delete Operation error!";
        }


      }

    ?>
    

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <?php 

      ob_end_flush();

    ?>

  </body>
</html>