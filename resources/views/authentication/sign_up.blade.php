<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    {{-- For Font --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poltawski+Nowy:ital,wght@0,400..700;1,400..700&display=swap"
      rel="stylesheet">
  <style>
      body {
          font-family: 'Poltawski Nowy', serif;
          background-color: #FCF1D5;
      }
  </style>

    @vite('resources/css/app.css')
</head>

<body class="bg-[#20252f]">
    <div class="container-fluid h-full content-center w-full my-6">
        <form method="POST" action="{{ route('store_account') }}"
            class="max-w-lg m-auto p-14 pb-5 bg-[#f6f1e3] rounded-lg" enctype="multipart/form-data">
            @csrf
            <div class="grid justify-items-center">
                <h1 class="text-3xl font-bold mb-10">SIGN UP</h1>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <label class="block mb-2 text-sm font-medium text-gray-500 dark:text-white" for="photo">Foto
                    3x4</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
          aria-describedby=" user_avatar_help" id="photo" name="photo" type="file">
            </div>
            <div class="grid grid-cols-2 gap-x-12 gap-y-3">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="name" id="name"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-900 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-[#002366] peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                        Panggilan</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="address" id="address"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-900 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="address"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-[#002366] peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Alamat</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="birth_place_date" id="birth_place_date"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-900 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="birth_place_date"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-[#002366] peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tempat,
                        Tanggal Lahir</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="region" id="region"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-900 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="region"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-[#002366] peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Wilayah</label>
                </div>
            </div>
            <div class="grid gap-y-3">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="email" name="email" id="floating_email"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-900 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="floating_email"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#002366] peer-focus:dark:text-[blue-500] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                        address</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="password" id="floating_password"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-900 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="floating_password"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-[#002366] peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="confirm_password" id="floating_confirm_password"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-900 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="floating_confirm_password"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-[#002366] peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm
                        Password</label>
                </div>
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert" id="error_alert" style="display: none;">
                    Password dan confirm password tidak sama.
                </div>
            </div>

            <div class="relative mt-14 z-0 w-full mb-5 group">
                <button type="submit"
                    class="text-white bg-[#002366] hover:bg-[#001742] focus:ring-4 focus:outline-none focus:ring-[#0A3431] font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-[#2F575D] dark:hover:bg-[#103A38] dark:focus:ring-[#0A3431]">Create
                    Account</button>
            </div>
            <div class="relative z-0 w-full mb-5 group text-center">
                Already have an account? <span><a href="{{ route('start_login') }}"
                        class="font-medium underline underline-offset-2">Login</a></span>
            </div>
            <div class="grid z-0 w-full mt-4 group justify-items-center">
                <img src="../../../images/LOGO_MISDINAR.png" class="w-[50px] h-[50px]" alt="logo gereja">
            </div>
        </form>
    </div>

    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    <script>
        // Function to check if passwords match
        function checkPasswordMatch() {
            var password = document.getElementById("floating_password").value;
            var confirmPassword = document.getElementById("floating_confirm_password").value;
            var errorDiv = document.getElementById("error_alert");

            // Show the error message if passwords don't match
            if (password !== confirmPassword) {
                errorDiv.style.display = "block";
            } else {
                errorDiv.style.display = "none";
            }
        }

        // Attach the function to password input events
        document.getElementById("floating_password").addEventListener("keyup", checkPasswordMatch);
        document.getElementById("floating_confirm_password").addEventListener("keyup", checkPasswordMatch);
    </script>
    @vite('resources/js/app.js')
</body>

</html>