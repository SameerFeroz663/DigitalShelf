
<?php
//coded by samfer 
session_start();
include './conn.php';
if(isset($_SESSION['id'])){
    header('location:../index.php');
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $keepLoggedIn = isset($_POST['keep_logged_in']);

    $query = "SELECT * FROM users WHERE email='$email'";
    $res = mysqli_query($conn, $query);

    if ($res && mysqli_num_rows($res) == 1) {
        $user = mysqli_fetch_assoc($res);
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            if ($keepLoggedIn) {
                setcookie("user_id", $user['id'], time() + (86400 * 30), "/"); // 30 days
                setcookie("email", $user['email'], time() + (86400 * 30), "/");
            }

        header("location:../index.php");
            exit();
        } else {
            $passmsg = "Invalid password.";
        }
    } else {
        $usermsg = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In - Digital Shelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
<body class="h-screen w-screen bg-white m-0 overflow-x-hidden">
<!--
    ...
    ...
    ...
    ...
    Coded By Samfer
    ...
    ...
    ...
    -->  <div  class="flex">
      <h1 class="text-3xl absolute font-bold mb-2 px-4 py-4"><span class="text-orange-500">Digital</span><span class="text-gray-800">Shelf</span>
      </h1>

    <!-- Left: Login Form (40%) -->
    <div class="w-full md:w-[40%] p-4 mt-10 sm:p-0 md:p-10 bg-white flex flex-col justify-center items-start">
  <h1 class="text-3xl font-bold mb-2">
    <span class="text-black">Sign</span> <span class="text-black">In</span>
  </h1>
  <p class="text-gray-500 mb-6">Please login to continue to your account.</p>

  <form class="space-y-5 w-full" method="post">
    <div class="relative w-full">
      <input
        type="email"
        placeholder="you@example.com"
        class="mt-1 w-full px-4 py-4 border border-red-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
        name="email"
      />
      <label for="password"
    class="absolute left-2 -top-2 px-1 text-sm bg-white text-orange-500 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-orange-500"
  >
    Email
  </label>
       <?php if(isset($usermsg)){
      echo "
    <p class='text-red-500'>$usermsg</p>
      ";
      }?>
    </div>

    <div>
      <div class="relative">

        <input
          type="password"
          class="mt-1 w-full px-4 py-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 pr-10"
          name="password"
          placeholder="User_1234"
        />
        <span class="absolute inset-y-0 right-3 flex items-center text-gray-400">👁️</span>
          <label for="password"
    class="absolute left-2 -top-2 px-1 text-sm bg-white text-orange-500 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-orange-500"
  >
    Password
  </label>
      </div>
      <?php if(isset($passmsg)){
      echo "
    <p class='text-red-500'>$passmsg</p>
      ";
      }?>
    </div>

    <div class="flex items-center justify-between text-sm">
      <label class="flex items-center space-x-2">
        <input type="checkbox" name="keep_logged_in" class="accent-orange-500" />
        <span>Keep me logged in</span>
      </label>
    </div>

    <button
      type="submit"
      class="w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-4 rounded-lg font-semibold"
    >
      Sign in
    </button>

  
  </form>
</div>



    <!-- Right: Image (60%) -->
    <div class="hidden md:flex md:w-[60%] items-center justify-center p-10">
  <div class=" w-screen h-screen rounded-xl border border-gray-300 overflow-hidden">
    <img 
      src="DS-IMG.jpg" 
      alt="Visual"
      class="w-full h-full object-cover object-top"
    />
  </div>
</div>

</div>
</body>


</html>
