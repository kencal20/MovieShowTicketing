<?php
include 'inc/header.php';

//View or Show all Movies 
$sql = "Select * from movies";
$exec = mysqli_query($con, $sql);
$result = mysqli_fetch_all($exec, MYSQLI_ASSOC); //Store all data from category table into $result


//Store Textboxes into variables
$ms_name = FILTER_INPUT(INPUT_POST, 'ms_name', FILTER_SANITIZE_SPECIAL_CHARS);
$movietoshow = FILTER_INPUT(INPUT_POST, 'movietoshow', FILTER_SANITIZE_SPECIAL_CHARS);
$ms_date = FILTER_INPUT(INPUT_POST, 'ms_date', FILTER_SANITIZE_SPECIAL_CHARS);
$ms_venue = FILTER_INPUT(INPUT_POST, 'ms_venue', FILTER_SANITIZE_SPECIAL_CHARS);



//Create Show
$sql2 = "insert into  movie_show(show_Name,Movie_ID,Venue,Show_Date,DateShowCreate) values('$ms_name','$movietoshow','$ms_date','$ms_venue')";
//var_dump($sql2);
if (mysqli_query($con, $sql2)) {
    echo 'Added';
} else {
    echo mysqli_error($con);
}
?>
<main>
    <div class="container d-flex flex-column align-items-center">
        <img src="logo.png" class="w-25 mb-3" alt="">

        <h2>Movie Show Ticketing System</h2>
        <p class="lead text-center">Create New Show</p>
        <p class="lead text-center" style="color:green"><?php echo $add_Msg; ?></p>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4 w-75" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Movie Show Name</label>
                <input type="text" class="form-control" id="ms_name" name="ms_name" placeholder="Enter your Movie Show">
            </div>

            <div class="mb-3">

                <select name="movietoshow">
                    <?php echo  $err_Msg; ?>
                    <option>Movie Title</option>
                    <?php foreach ($result as $movie_title) :  ?>
                        <option value='<?php echo $movie_title['Movie_ID']; ?>'>
                            <?php echo $movie_title['Title']; ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>


            <div class="mb-3">
                <label for="Date" class="form-label">Show Date</label>
                <input type="Date" class="form-control" id="ms_date" name="ms_date" placeholder="Select your Date">
            </div>

            <div class="mb-3">
                <label for="txt" class="form-label">Venue</label>
                <input type="text" class="form-control" id="ms_venue" name="ms_venue" placeholder="Select your Date">
            </div>

            <div class="mb-3">
                <input type="submit" name="CreateShow" value="Create Show" class="btn btn-dark w-100">
            </div>
        </form>
    </div>
</main>
<?php
include 'inc/footer.php';

?>