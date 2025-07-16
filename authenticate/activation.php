<?php
//coded by samfer
error_reporting(E_ALL);
ini_set('display_errors', 1);

include './conn.php';
session_start();
if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    $query = "SELECT * FROM user_invitation WHERE token = '$token'";
    $res = mysqli_query($conn, $query);
    if (mysqli_num_rows($res) == 1) {
        $fetch = mysqli_fetch_assoc($res);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
             $password = $_POST['password'];
             $email = $fetch['email'];
             $username = $fetch['username'];
            $phone = $_POST['phone'];
            if(!preg_match('/^\d{10,12}$/',$phone)){
                $usermsg = "Incorrect Phone Number Format";
            }
            if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])[A-Za-z\d=?*_@]{8,}$/',$password)){
                $passmsg = "Password Must At Least 8 Characters Long, Contains A Lowercase, An Uppercase Letter And A Special Character";
                exit;
            }
            $queryCheck = "SELECT * FROM users WHERE email = '$email'";
            $resCheck = mysqli_query($conn, $queryCheck);

            if (mysqli_num_rows($resCheck) == 0) {
                $hashPass = password_hash($password, PASSWORD_DEFAULT);
                $query2 = "INSERT INTO users (email, username, password_hash) VALUES ('$email', '$username', '$hashPass')";
                $res2 = mysqli_query($conn, $query2);

                if ($res2) {
                    $user_id = mysqli_insert_id($conn);
                    $query3 = "INSERT INTO userprofiles (user_id, first_name, last_name, phone_number) VALUES ('$user_id', 'Guest', 'Guest', '$phone')";
                    $res3 = mysqli_query($conn, $query3);
                    if ($res3) {
                       $query5 = "INSERT INTO userroles (user_id, role_id) VALUES ('$user_id',1)";
                       $res5 = mysqli_query($conn, $query5);
                       if (!$res5) {
    die("❌ Role insertion failed: " . mysqli_error($conn));
}
                        $query6 = "INSERT INTO UserBrands (user_id, brand_id) VALUES ('$user_id',20)";
                       $res6 = mysqli_query($conn, $query6);
                       if($res5 && $res6){
                            mysqli_query($conn, "DELETE FROM user_invitation WHERE token = '$token'");
                        header('Location: ./Sign-In.php');
                        exit;
                       }
                    

                    } else {
                        echo "<script>
                        window.addEventListener('DOMContentLoaded', () => {
                        alert('Failed to create user profile. Redirecting To Login Page...');
                        window.location.href = './Sign-In.php';
                        });
                        </script>";
                       }
                } else {
                        echo "<script>
                        window.addEventListener('DOMContentLoaded', () => {
                        alert('❌ Failed to insert user. Redirecting To Login Page...');
                        window.location.href = './Sign-In.php';
                        });
                        </script>";                }
            } else {
                echo "<script>
                    window.addEventListener('DOMContentLoaded', () => {
                        alert('Account already exists. Redirecting To Login Page...');
                        window.location.href = './Sign-In.php';
                    });
                </script>";
            }
        }
    }
    else{
         echo "<script>
         alert('No Token Found. Redirecting To Login Page...');
         window.location.href = './Sign-In.php';
         </script>";
    }
}else{
         echo "<script>
                    window.addEventListener('DOMContentLoaded', () => {
                        alert('Invalid Token. Redirecting To Registeration Page...');
                        window.location.href = './Sign-In.php';
                    });
                </script>";
    }
        // ✅ HTML Form Display (if no POST yet)
        ?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up - Digital Shelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
<body class="h-screen w-screen bg-white m-0 overflow-x-hidden">
//coded by samfer  <div  class="flex">
      <h1 class="text-3xl absolute font-bold mb-2 px-4 py-4"><span class="text-orange-500">Digital</span><span class="text-gray-800">Shelf</span>
      </h1>

    <!-- Left: Login Form (40%) -->
    <div class="w-full md:w-[40%] p-4 mt-10 sm:p-0 md:p-10 bg-white flex flex-col justify-center items-start">
  <h1 class="text-3xl font-bold mb-2">
    <span class="text-black">Welcome</span> <span class="text-black"></span>
  </h1>
  <p class="text-gray-500 mb-6">Enter the fields to continue to your account.</p>

  <form class="space-y-5 w-full" method="post">
    <div class="relative w-full">
      <input
        type="tel"
        placeholder="+92123123123"
        class="mt-1 w-full px-4 py-4 border border-red-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
        name="phone"
      />
      <label for="phone"
    class="absolute left-2 -top-2 px-1 text-sm bg-white text-orange-500 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-orange-500"
  >
    Phone Number
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
        <!--<span class="absolute inset-y-0 right-3 flex items-center text-gray-400">👁️</span>--!>
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


    <button
      type="submit"
      class="w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-4 rounded-lg font-semibold"
    >
      Create Account
    </button>

  
  </form>
</div>



    <!-- Right: Image (60%) -->
    <div class="hidden md:flex md:w-[60%] items-center justify-center p-10">
  <div class=" w-screen h-screen rounded-xl border border-gray-300 overflow-hidden">
    <img 
      src="../assets/images/backgrounds/maxresdefault.jpg" 
      alt="Visual"
      class="w-full h-full object-cover object-top"
    />
  </div>
</div>

</div>
</body>

</html>
ject-cover object-top"
    />
  </div>
</div>

</div>
</body>

</html>
