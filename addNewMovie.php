<?php
include 'inc/header.php';

session_start();
//Retrieve data from Category table into <Select>
$sql = "Select * from  movie_categories;";
$exec = mysqli_query($con, $sql);
$results = mysqli_fetch_all($exec, MYSQLI_ASSOC);

//Store Textboxes into variables
$m_id = FILTER_INPUT(INPUT_POST, 'm_id', FILTER_SANITIZE_SPECIAL_CHARS);
$m_name = FILTER_INPUT(INPUT_POST, 'm_name', FILTER_SANITIZE_SPECIAL_CHARS);
$m_cat = FILTER_INPUT(INPUT_POST, 'Cat', FILTER_SANITIZE_SPECIAL_CHARS);
$m_date = FILTER_INPUT(INPUT_POST, 'm_date', FILTER_SANITIZE_SPECIAL_CHARS);
$m_rate = FILTER_INPUT(INPUT_POST, 'm_rate', FILTER_SANITIZE_SPECIAL_CHARS);
$m_duration = FILTER_INPUT(INPUT_POST, 'm_duration', FILTER_SANITIZE_SPECIAL_CHARS);
$m_producer = FILTER_INPUT(INPUT_POST, 'm_producer', FILTER_SANITIZE_SPECIAL_CHARS);
$m_language = FILTER_INPUT(INPUT_POST, 'm_language', FILTER_SANITIZE_SPECIAL_CHARS);
$m_picture = FILTER_INPUT(INPUT_POST, 'm_picture', FILTER_SANITIZE_SPECIAL_CHARS);
$err_Msg = '';
$add_Msg = '';



if (isset($_POST['add_NewMovie'])) {

  //Check if textboxes are empty and show error message
  if (empty($m_id) || empty($m_name)) {
    $err_Msg = 'Enter data';
  } else {
    $err_Msg = '';
  }


  //Allowed picture extensions
  $allowed = ['jpg', 'jpeg', 'png', 'tif', 'pdf'];

  if (!empty($_FILES['m_picture']['name'])) {
    //Define details of pic such as name , size, tmp location using $_File[]
    //Supper global

    $file_Name = $_FILES['m_picture']['name'];
    $file_Size = $_FILES['m_picture']['size'];
    $file_Tmp = $_FILES['m_picture']['tmp_name'];

    //Specify fold path to upload pics to
    $target_dir = 'uploads/'.$file_Name;

    // Extract file extension from from file
    $file_ext = explode('.', $file_Name);

    //Convert file extensions to lower case
    $file_ext = strtolower(end($file_ext));

    //Check if file ext is allowed
    if (in_array($file_ext, $allowed)) {
      //uploading file
      move_uploaded_file($file_Tmp, $target_dir);
    } else {
      echo 'Invalid File'; //if file ext is not in allowed list
    }
  }

  // End of pic validation
  //add data to movie table
  $sql2 = "UPDATE movie set Category_ID= $m_cat, picture='$target_dir' WHERE Mocie_ID= ) VALUES (?, ?, ?, ?)";

  $stmt = mysqli_prepare($con, $sql2);
  mysqli_stmt_bind_param($stmt, "ssss", $m_id, $m_name, $m_cat, $target_dir);

  if (mysqli_stmt_execute($stmt)) {
    $add_Msg = 'Movie Added';
  } else {
    $add_Msg = 'Not Added: ' . mysqli_error($con);
  }

  mysqli_stmt_close($stmt);
}
?>
<main>
  <div class="container d-flex flex-column align-items-center">
    <img src="logo.png" class="w-25 mb-3" alt="">
    <h2>Movie Show Ticketing System</h2>
    <p class="lead text-center">Add New Movie Show</p>
    <p class="lead text-center" style="color:green"><?php echo $add_Msg; ?></p>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4 w-75" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="name" class="form-label">Movie ID</label>
        <input type="text" class="form-control" id="m_id" name="m_id" placeholder="Enter your Movie Show">
        <?php echo  $err_Msg; ?>
      </div>

      <div class="mb-3">
        <label for="name" class="form-label">Movie Title</label>
        <input type="text" class="form-control" id="m_name" name="m_name" placeholder="Enter your Movie Show">
      </div>

      <div class="mb-3">

        <select name="Cat">
          <?php echo  $err_Msg; ?>
          <option>Select Movie Category</option>
          <?php foreach ($results as $movie_Cat) :  ?>
            <option value='<?php echo $movie_Cat['Category_ID']; ?>'>
              <?php echo $movie_Cat['Category_Name']; ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="Year" class="form-label">Year Release</label>
        <input type="date" class="form-control" id="m_date" name="m_date">
      </div>

      <div class="mb-3">
        <label for="Rate" class="form-label">Ratings</label>
        <input type="number" class="form-control" id="m_rate" name="m_rate">
      </div>

      <div class="mb-3">
        <label for="Duration" class="form-label">Duration</label>
        <input type="text" class="form-control" id="m_duration" name="m_duration">
      </div>

      <div class="mb-3">
        <label for="Producer" class="form-label">Producer</label>
        <input type="text" class="form-control" id="m_producer" name="m_producer">
      </div>

      <div class="mb-3">
        <label for="Lang" class="form-label">Language</label>
        <input type="text" class="form-control" id="m_language" name="m_language">
      </div>

      <div class="mb-3">
        <label for="Pic" class="form-label">Picture</label>
        <input type="file" class="form-control" id="m_picture" name="m_picture">
        <?php echo  $err_Msg; ?>
      </div>

      <div class="mb-3">
        <input type="submit" name="add_NewMovie" value="Add Movie" class="btn btn-dark w-100">
      </div>
    </form>
  </div>
</main>

<?php
include 'inc/footer.php';

?>