<?php
    // if(isset($_GET['submit'])){
    //     echo $_GET['email'] . '<br/>';
    //     echo $_GET['title'] . '<br/>';
    //     echo $_GET['ingredients'] . '<br/>';
    // }
    include('config/db_connect.php');

    $email = $title = $ingredients = '';
    $errors = array('email' => '','title' => '', 'ingredients'=> '');
    if(isset($_POST['submit'])){

        if(empty($_POST['email'])){
            $errors['email'] = 'An email is required <br />';
        }else{
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Email must be a valid email address';
            }
            // echo htmlspecialchars($_POST['email']) . '<br />';
        }

        if(empty($_POST['title'])){
            $errors['title'] = 'A title is required <br />';
        }
        else{
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/',$title)){
                $errors['title'] = 'Title must be letters and spaces only';
            }
            //echo htmlspecialchars($_POST['title']) . '<br />';
        }

        if(empty($_POST['ingredients'])){
            $errors['ingredients'] = 'At least one ingredient is required <br />';
        }
        else{
            $ingredients = $_POST['ingredients'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/',$ingredients)){
                $errors['ingredients']= 'Ingredients must be a comma separated list with no numbers';
            }
            //echo htmlspecialchars($_POST['ingredients']) . '<br />';
        }


        if(array_filter($errors)){
            // echo "Errors exists";
        }
        else{
            $email = mysqli_real_escape_string($conn,$_POST['email']);
            $title = mysqli_real_escape_string($conn,$_POST['title']);
            $ingredients = mysqli_real_escape_string($conn,$_POST['ingredients']);
            
            $sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title','$email','$ingredients')";

            if(mysqli_query($conn,$sql)){
                header('Location: index.php');
            } else{
                echo "Query error" . mysqli_error($conn);
            }
            
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <?php include('templates/header.php'); ?>

    <section class="container grey-text">
        <h4 class="center">Add a Pizza</h4>
        <form class="white" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <label>Your Email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
            <div class="red-text"><?php echo $errors['email']; ?></div>
            <label>Pizza Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
            <div class="red-text"><?php echo $errors['title']; ?></div>
            <label>Ingredients (comma seperated):</label>
            <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
            <div class="red-text"><?php echo $errors['ingredients']; ?></div>
            <div class="center">
                <input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
            </div>
        </form>
    </section>

    <?php include('templates/footer.php'); ?>
</body>
</html>