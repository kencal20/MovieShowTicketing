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
            <thead>
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
                    <td><?php echo $movie['Movie_ID']; ?></td>
                    <td><?php echo $movie['Title']; ?></td>
                    <td><?php echo $movie['Category_ID']; ?></td>
                    <td>
                        <img height="200" width="300" src="<?php echo $movie['picture']; ?>" alt="Movie Poster">
                    </td>
                    <td>
                        <a href="edit_movie.php" ?edit=<?php echo $movie['Movie_ID']; ?> class="btn btn-success">Edit</a>
                        <a class="btn btn-danger" href="Delete_movie.php" ?delete=<?php echo $movie['Movie_ID']; ?>>Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>

        </table>
        <input type="button" value="print" onclick="window.print()" />
    </div>

    <?php
    include 'inc/footer.php';
    ?>