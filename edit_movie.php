<?php
    include 'inc/header.php';
    session_start();

    $_SESSION['edit'] =$_GET['edit'];//Get and store url varible edit into session

    $edit = $_SESSION['edit']; //for sql query store $_SESSION['edit'] into $edit

    //Retrieve data from Movies table 
    $sql = "Select * from  movies where movie_ID= $edit";
    $exec = mysqli_query($con, $sql);
    $results =mysqli_fetch_array($exec, MYSQLI_ASSOC); 

     //Retrieve data from Category table into <Select>
     $sql1 = "Select * from  movie_categories";
     $exec1 = mysqli_query($con, $sql1);
     $results1 =mysqli_fetch_all($exec1, MYSQLI_ASSOC); 

    //Store Textboxes into variables
    $m_id = FILTER_INPUT(INPUT_POST,'m_id',FILTER_SANITIZE_SPECIAL_CHARS);
    $m_name = FILTER_INPUT(INPUT_POST,'m_name',FILTER_SANITIZE_SPECIAL_CHARS);
    $m_cat = FILTER_INPUT(INPUT_POST,'Cat',FILTER_SANITIZE_SPECIAL_CHARS);
    $m_date= FILTER_INPUT(INPUT_POST,'m_date',FILTER_SANITIZE_SPECIAL_CHARS);
    $m_rate = FILTER_INPUT(INPUT_POST,'m_rate',FILTER_SANITIZE_SPECIAL_CHARS);
    $m_duration= FILTER_INPUT(INPUT_POST,'m_duration',FILTER_SANITIZE_SPECIAL_CHARS);
    $m_producer = FILTER_INPUT(INPUT_POST,'m_producer',FILTER_SANITIZE_SPECIAL_CHARS);
    $m_language = FILTER_INPUT(INPUT_POST,'m_language',FILTER_SANITIZE_SPECIAL_CHARS);
    $m_picture = FILTER_INPUT(INPUT_POST,'m_picture',FILTER_SANITIZE_SPECIAL_CHARS);
    $err_Msg ='';
    $add_Msg = '';


    
    if(isset($_POST['edit_Movie']))
    {
       
        //Check if textboxes are empty and show error message
        if(empty($m_id)||empty($m_name)){
            $err_Msg ='Enter data';
        }
        else{ $err_Msg ='';}

        //Allowed picture extensions
        $allowed =['jpg','jpeg','png','tif','pdf']; 

        if(!empty($_FILES['m_picture']['name']))
        {
            //Define details of pic such as name , size, tmp location using $_File[]
            //Supper global

            $file_Name = $_FILES['m_picture']['name'];
            $file_Size = $_FILES['m_picture']['size'];
            $file_Tmp = $_FILES['m_picture']['tmp_name'];

            //Specify fold path to upload pics to
            $target_dir ="uploads/${file_Name}";
            // Extract file extension from from file
            $file_ext =explode('.',$file_Name);

            //Convert file extensions to lower case
            $file_ext = strtolower(end($file_ext ));

            //Check if file ext is allowed
            if(in_array($file_ext,$allowed))
            {
                //uploading file
                move_uploaded_file($file_Tmp , $target_dir );
            } 
            else{
                echo 'Invalid File'; //if file ext is not in allowed list
            }
            
        }

         // End of pic validation
           //Update data in movie table
           $sql2 ="update movies set Title='$m_name', Category_ID =$m_cat,
                   Picture='$target_dir' where  Movie_ID=$edit";
            var_dump($sql2);
            
            if(mysqli_query($con,$sql2)) //Connect to dabatase and run query
            {
                    $add_Msg ='Record Updated';
            }
            else {$add_Msg ='Record Not Updated'.mysqli_error($con);} 
        



    }
?>
<main>
  <div class="container d-flex flex-column align-items-center">
    <img src="logo.png" class="w-25 mb-3" alt="">
    <h2>Movie Show Ticketing System</h2>
    <p class="lead text-center">Add New Movie Show</p>
    <p class="lead text-center" style="color:green"><?php echo $add_Msg; ?></p>
   
    <form action="<?php echo $_SERVER['PHP_SELF'];?>?edit=<?php echo $edit ?>" class="mt-4 w-75" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Movie ID</label>
            <input type="text" class="form-control" id="m_id" name="m_id" 
              value="<?php echo  $results['Movie_ID']; ?>" 
              readonly>
            <?php echo  $err_Msg; ?>
        </div>

      <div class="mb-3">
        <label for="name" class="form-label">Movie Title</label>
        <input type="text" class="form-control" id="m_name" name="m_name"
        value="<?php echo  $results['Title']; ?>" 
        placeholder="Enter your Movie Show">
      </div>

      <div class="mb-3">
      <select name="Cat">
        <?php echo  $err_Msg; ?>
            <option selected="selected">Select Movie Category</option>
            <?php foreach($results1 as $movie_Cat):  ?>
                <option value='<?php echo $movie_Cat['Category_ID'];?>' 
                    <?php if($results['Category_ID']== $movie_Cat['Category_ID']){ ?>
                            selected="selected"
                    <?php } ?>
                
                >

                    <?php echo $movie_Cat['Category_Name'];?>
                </option>
            <?php endforeach ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="Year" class="form-label">Year Release</label>
        <input type="Date" class="form-control" id="m_date" name="m_date" 
        value="<?php echo  $results['Year_Release']; ?>" 
        placeholder="Select your Date">
      </div>
      
      <div class="mb-3">
        <label for="Rate" class="form-label">Ratings</label>
        <input type="text" class="form-control" id="m_rate" name="m_rate"
        value="<?php echo  $results['Year_Release']; ?>" 
        placeholder="Select your Date">
      </div>

      <div class="mb-3">
        <label for="Duration" class="form-label">Duration</label>
        <input type="text" class="form-control" id="m_duration" name="m_duration" placeholder="Select your Date">
      </div>

      <div class="mb-3">
        <label for="Producer" class="form-label">Producer</label>
        <input type="text" class="form-control" id="m_producer" name="m_producer" placeholder="Select your Date">
      </div>

      <div class="mb-3">
        <label for="Lang" class="form-label">Language</label>
        <input type="text" class="form-control" id="m_language" name="m_language" placeholder="Select your Date">
      </div>

      <div class="mb-3">
        <label for="Pic" class="form-label">Picture</label>
        <input type="file" class="form-control" id="m_picture" value="<?php echo  $results['Picture']; ?>"
        name="m_picture" placeholder="Select your Date">
        <?php echo  $err_Msg; ?>
    </div>

      <div class="mb-3">
        <input type="submit" name="edit_Movie" value="Edit Movie" class="btn btn-dark w-100">
      </div>
    </form>
    </div>
</main>

<?php
    include 'inc/footer.php';

?>