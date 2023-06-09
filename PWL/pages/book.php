<?php
$deleteCommand = filter_input(INPUT_GET, 'cmd');
if (isset($deleteCommand) && $deleteCommand == 'del') {
    $bookIsbn = filter_input(INPUT_GET, 'isbn');
    $result = deleteBookFromDb($bookIsbn);
    if ($result) {
        echo '<div class="d-flex justify-content-center">Data succesfully removed</div>';
    } else {
        echo '<div class="d-flex justify-content-center">Failed to remove data</div>';
    }
}

$submitPressed = filter_input(INPUT_POST, 'btnSave');
if (isset($submitPressed)) {
  $isbn = filter_input(INPUT_POST, 'isbn');
  $title = filter_input(INPUT_POST, 'judul');
  $author = filter_input(INPUT_POST, 'author');
  $pub = filter_input(INPUT_POST, 'publisher');
  $pubyear = filter_input(INPUT_POST, 'publish_year');
  $desc = filter_input(INPUT_POST, 'desc');
  $cover = filter_input(INPUT_POST, 'cover');
  $id = filter_input(INPUT_POST, 'genre_id');
  if ((trim($isbn) == '') || (trim($title) == '') || (trim($author) == '') || (trim($pub) == '') || (trim($pubyear) == '') || (trim($desc) == '') || (trim($id) == '')){
    echo '<div class="d-flex justify-content-center>Please provide with a valid name</div>';
  } else {
    $results = addNewBook($isbn, $title, $author, $pub, $pubyear, $desc, $id);
    if ($results) {
        echo '<div class="d-flex justify-content-center">Data Succesfully Loaded</div>';
    } else {
        echo '<div class="d-flex justify-content-center">Failed to add data</div>';
    }
  }
}

?>

<div class="container pt-4">
    <div class="row">
        <div class="col-sm-3">
            <div class="d-flex justify-content-center">
                <h3>Tambah Buku</h3>
            </div>
            <form method="post" action="">
                <div class="form-group mb-3">
                    <label for="isbn">ISBN</label>
                    <input type="text" class="form-control" name="isbn" id="isbn" placeholder="ISBN" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label for="author">Author</label>
                    <input type="text" class="form-control" name="author" id="author" placeholder="Author" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label for="publisher">Publisher</label>
                    <input type="text" class="form-control" name="publisher" id="publisher" placeholder="Publisher" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label for="publish_year">Publish Year</label>
                    <input type="number" class="form-control" name="publish_year" id="publish_year" placeholder="Publish Year" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label for="desc">Description</label>
                    <textarea class="form-control" name="desc" id="desc" rows="5" placeholder="Short Description" required autofocus></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="genre_id">Genre</label>
                    <select class="form-select" aria-label="Default select example" name="genre_id" id="genre_id" required autofocus>
                        <option selected disabled>Choose Genre</option>
                        <?php
                            $results = fetchGenreFromDb();
                            foreach ($results as $genre) {
                                echo '<option value="' . $genre['id'] . '">' . $genre['name'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <input class="btn btn-dark" type="submit" value="Save Data" name="btnSave">
                </div>
            </form>
        </div>
        <div class="col-sm-9">
            <table class="table table-striped" style="text-align: center;">
                <thead class="thead-dark">
                    <tr style="border-bottom: 1px;">
                        <th scope="col">ISBN</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Publisher</th>
                        <th scope="col">Publish&nbsp;Year</th>
                        <th scope="col">Description</th>
                        <th scope="col">Cover</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $results = fetchBookFromDb();
                    foreach ($results as $book) {
                        $fileName = $book['cover'];
                        $imageFile = 'uploads/'.$fileName;
                        echo '<tr>';
                        echo '<td>' . $book['isbn'] . '</td>';
                        echo '<td>' . $book['title'] . '</td>';
                        echo '<td>' . $book['author'] . '</td>';
                        echo '<td>' . $book['publisher'] . '</td>';
                        echo '<td>' . $book['publish_year'] . '</td>';
                        echo '<td>' . $book['short_description'] . '</td>';
                        if(isset($book['cover'])){
                            echo '<td> <img width="100" src="' . $imageFile . '"></td>';
                        }else{
                            echo '<td> <img width="100" src="uploads/default.jpg"></td>';
                        }
                        echo '<td>' . $book['name'] . '</td>';
                        echo '<td>
                        <button class="btn btn-primary" style="margin-bottom: 10px;" onclick="uploadImgBook(\'' . $book['isbn'] . '\')"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>
                        <br>
                        <button class="btn btn-warning" style="margin-bottom: 10px;" onclick="editBook(\'' . $book['isbn'] . '\')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                        <button class="btn btn-danger" onclick="deleteBook(\'' . $book['isbn'] . '\')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </td>';
                        echo '</tr>';
                        }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="js/book_index.js"></script>
<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
</script>