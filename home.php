<?php
include 'connection.php';
session_start();
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
//     header('location: index.php');
//     exit;
// }

$insert = false;
$update = false;
$delete = false;
$email = $_SESSION['email'];
if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $del = "DELETE FROM `notes` WHERE `sno`=$sno;";
    $res = mysqli_query($con,$del);
    if($res){
        $delete = true;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['snoEdit'])) {
        $sno = $_POST['snoEdit'];
        $title = $_POST['note-title-edit'];
        $content = $_POST['note-content-edit'];
        $add = "UPDATE `notes` SET `title`='$title' , `content`='$content', `date`=current_timestamp() WHERE `notes`.`sno`=$sno ;";
        $adder = mysqli_query($con, $add);
        if($adder){
            $update = true;
        }
    }else{
        $content = $_POST['note-content'];
        $title = $_POST['note-title'];
        $add = "INSERT INTO `notes` (`title`, `content`, `email`, `date`) 
                VALUES ('$title', '$content', '$email', current_timestamp());";
        $adder = mysqli_query($con, $add);
        if ($adder) {
            $insert = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quickote App</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>
    <!-- Header Section -->
    <?php include 'header.php'; ?>



    <!-- The Modal -->
    <div id="myModal" class="modal">
        <form class="form modal-content" action="home.php" method="POST" autocomplete="">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
                <input class="input" type="text" name="note-title-edit" id="note-title-edit" placeholder="Title" required>
            </div>
            <div class="form-group">
                <textarea name="note-content-edit" id="note-content-edit" rows="20" cols="20" placeholder="Content"></textarea>
            </div>
            <div class="form-group edit-button-group">
                <input class="add-button" type="submit" name="edit" id="edit" value="Edit">
            </div>
        </form>

    </div>


    <!-- Navbar Section -->
    <section class="navbar">
        <div class="greeting navbar-items">
            <p>Welcome&nbsp;<?php echo $_SESSION['username']; ?>!</p>
        </div>
        <div class="icons navbar-items">
            <div class="logout-icon" onclick="logout()">Logout&nbsp;<i class="bi bi-box-arrow-right"></i></div>
        </div>
    </section>

    <section class="note-page">
        <!-- Adding Note Section -->
        <section class="container note-container">
            <div class="form note-form" id="note-form">
                <form action="home.php" method="POST" autocomplete="">
                    <h1 class="form-heading">Add A Note</h1>
                    <p class="form-description">Put an unique title and add your note</p>
                    <?php
                    if ($insert) {
                        echo '<p class="success">Your note is added succesfully!</p>';
                    }
                    if ($update) {
                        echo '<p class="success">Your note has been updated succesfully!</p>';
                    }
                    if ($delete) {
                        echo '<p class="success">Your note has been deleted succesfully!</p>';
                    }
                    ?>
                    <div class="form-group">
                        <input class="input" type="text" name="note-title" id="note-title" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <textarea name="note-content" id="note-content" rows="10" cols="20" placeholder="Content"></textarea>
                    </div>
                    <div class="form-group">
                        <input class="add-button" type="submit" name="add" id="add" value="Add Note">
                    </div>
                </form>
            </div>
        </section>


        <section class="container note-display">
            <h1>Your Notes</h1>
            <!-- <form action="search.php" class="search-form">
                <div class="search-box">
                    <input class="input" type="text" name="search-title" placeholder="Search for your title" required>
                    <button class="input search-button" type="submit" name="search-button"><i class="bi bi-search"></i></button>
                </div>
            </form> -->
            <table class="table notes-table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">Sl. No.</th>
                        <th scope="col">Title</th>
                        <th scope="col">Content</th>
                        <th scope="col">Date Modified</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $email = $_SESSION['email'];
                    $note = "SELECT * FROM `notes` WHERE email='$email'";
                    $result = mysqli_query($con, $note);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                        <tr>
                            <td scope='row'>" . $count . "</td>
                            <td scope='row'>" . $row['title'] . "</td>
                            <td scope='row'>" . $row['content'] . "</td>
                            <td scope='row'>" . $row['date'] . "</td>
                            <td scope='row' class='actions'><button id=" . $row['sno'] . " class='edit myBtn'>Edit</button><button class='delete' id=" . $row['sno'] . ">Delete</button></td>
                        </tr>";
                        $count++;
                    }
                    ?>
                </tbody>
            </table>
        </section>

    </section>



    <!-- Footer Section -->
    <footer>
        <?php include 'footer.php'; ?>
    </footer>


    <!-- Internal Java Script -->
    <script>
        function github() {
            window.open("https://github.com/Soumyajit-12")
        }

        function linkedIn() {
            window.open("https://www.linkedin.com/in/soumyajit-mitra-038827244/")
        }

        function instagram() {
            window.open("https://www.instagram.com/soumyajit_2641/")
        }

        function logout() {
            window.open('http://localhost/Quickotes/logout.php', '_self')
        }


        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        edits = document.getElementsByClassName("edit");
        Array.from(edits).forEach((element) => {
            element.addEventListener('click', (e) => {
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[1].innerText;
                content = tr.getElementsByTagName("td")[2].innerText;
                console.log(title, content);
                titleEdit = document.getElementById('note-title-edit');
                contentEdit = document.getElementById('note-content-edit');
                snoEdit = document.getElementById('snoEdit');
                contentEdit.value = content;
                titleEdit.value = title;
                snoEdit.value = e.target.id;
                console.log(e.target.id);
                modal.style.display = "block";

            })
        })
        
        deletes = document.getElementsByClassName("delete");
        Array.from(deletes).forEach((element) => {
            element.addEventListener('click', (e) => {
                sno = e.target.id;
                console.log(sno);
                
                if(confirm('Do you want to delete the Note?')){
                    console.log('yes');
                    window.location = `home.php?delete=${sno}`;
                }else{
                    console.log('no');
                }
            })
        })

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

</body>

</html>