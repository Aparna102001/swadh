<?php
session_start();
// include('./constant/layout/head.php');
include('connect.php');
$errors = array();

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        if ($username == "") {
            $errors[] = "Username is required";
        }

        if ($password == "") {
            $errors[] = "Password is required";
        }
    } else {
        // Check if the user exists with the provided username
        $sql = "SELECT id, type, password FROM login WHERE username = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Directly compare passwords (no hashing)
            if ($row['password'] === $password) {
                $_SESSION['userId'] = $row['id'];

                // Redirect based on user type
                if ($row['type'] == 1) {
                    header('location: canteen_manager_home_view.php');
                    exit;
                } elseif ($row['type'] == 2) {
                    header('location: kitchen_manager_home_view.php');
                    exit;
                } else {
                    $errors[] = "Invalid user type";
                }
            } else {
                $errors[] = "Invalid password";
            }
        } else {
            $errors[] = "User not found";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Canteen Management Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <header>
        <!-- Navigation can be added here -->
    </header>
    <section>
        <div class="container">
            <form action="#" method="post">
                <h1>Login</h1>
                <?php if (!empty($errors)) { ?>
                    <div class="error">
                        <?php foreach ($errors as $error) { ?>
                            <p><?php echo $error; ?></p>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="input-box">
                    <input type="text" name="username" id="username" placeholder="Email" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="link-forgot">
                    <a href="#">Forgot password?</a>
                </div>
                <input type="submit" value="Login" class="btn">
            </form>
        </div>
    </section>
</body>
</html>
