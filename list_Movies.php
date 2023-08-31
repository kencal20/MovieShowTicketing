    <?php
    include 'inc/header.php';

    session_start();
    // View or Show all Movie categories
    $sql = "SELECT * FROM movies";
    $exec = mysqli_query($con, $sql);
    $result = mysqli_fetch_all($exec, MYSQLI_ASSOC);

    ?>

    <div class="container d-flex flex-column align-items-center">
        <h2>List of Movies</h2>

        <?php if (empty($result)) : ?>
            <h3><?php echo "No Movies found"; ?></h3>
        <?php endif ?>

        <a class="btn btn-primary" href="addNewMovie.php">CREATE NEW MOVIE</a>
        <br>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead class="bg-dark text-light
            ">
                <tr>
                    <th>Movie_ID</th>
                    <th>Title</th>
                    <th>Category_ID</th>
                    <th>Picture</th>
                    <th>Action</th>
                </tr>
            </thead>

            <?php foreach ($result as $movie) : ?>
                <tr>
            
            <td> <?php echo $movie['Movie_ID']; ?> </td>
            <td><?php echo $movie['Title']; ?> </td>
            <td><?php echo $movie['Category_ID']; ?> </td>
            <td> <img src="<?php echo $movie['picture']; ?>" width="70px" /> </td>
            <td>
              <a href="edit_movie.php?edit=<?php echo $movie['Movie_ID']; ?>">
               <button class="btn btn-primary px-3" type="button">
                  Edit
               </button>
              </a>

              <a href="delete_Movie.php?delete=<?php echo $movie['Movie_ID']; ?>">
               <button class="btn btn-danger px-3" type="button" 
               onclick="return confirm('Are you sure you want to delete')"> 
                   Delete
                </button>
              </a>
            </td>

        </tr>
    <?php endforeach ?>

        </table>

    </div>

    <?php
    include 'inc/footer.php';
    ?>