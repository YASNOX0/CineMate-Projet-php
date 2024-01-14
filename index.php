<?php
session_start();
require_once('Database/CRUDS/fUsersCrud.php');

if(isset($_SESSION['state'])){
    $isConnected = 'hidden';
    $user = getUserByUsername($_SESSION['username']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineMate</title>
    <link rel="stylesheet" href="css/style.css">
    <!--Box icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!--Tailwindcss-->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <!--Link To Custom JS -->
    <script src="js/main.js" defer></script>
    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!--Tailwindcss-->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <!--Flowbite css-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <!--flowbite js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js" defer></script>
</head>

<body>
    <!--Navbar-->
    <header>
        <a href="#" class="logo">
            <i class='bx bxs-movie'></i>CineMate
        </a>
        <div class="bx bx-menu" id="menu-icon"></div>

        <!--Menu-->
        <ul class="navbar">
            <li><a href="#home" class="home-active">Home</a></li>
            <li><a href="#coming">Coming</a></li>
            <li><a href="#popular">Popular</a></li>
            <li><a href="#movies">Movies</a></li>
            <li><a href="#top-rated">TopRated</a></li>
            <li><a href="#newsletter">NewsLetteer</a></li>
            <div class="search_container">
                <div class="relative text-gray-600">
                <input type="search" name="serch" id="search-input" placeholder="Search" class="bg-white h-10 px-5 pr-10 rounded-full text-sm focus:outline-none" style="padding-right: 50px;">
                    <button type="button" class="absolute right-0 top-0 mt-3 mr-4">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                            <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"/>
                        </svg>
                    </button>
                    <div class="search_result" id="search-result"></div>
                </div>
            </div>
        </ul>
        <a href="log_reg.php" class="btn" <?php echo isset($isConnected) ? $isConnected : ""; ?>>
            Sign in <i class='bx bxs-user'></i>
        </a>

        <div id="profile-dropDown" <?php isset($isConnected) ? !$isConnected : "";?>>
            <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName" class="flex items-center text-sm pe-1 font-medium text-gray-900 rounded-full hover:text-blue-600 dark:hover:text-blue-500 md:me-0 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white" type="button">
                <span class="sr-only">Open user menu</span>
                <img class="w-10 h-10 me-2 rounded-full" src="<?php echo $user->getAvatarUrl();?>" alt="user photo">
                <span id="user-dropmenu">My Account</span>
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdownAvatarName" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                    <div class="font-medium "><?php echo $user->getUsername();?></div>
                    <div class="truncate"><?php echo $user->getEmail(); ?></div>
                </div>
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                    <li>
                        <a href="userInfos.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                    </li>
                </ul>
                <div class="py-2">
                    <a href="signOut.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                </div>
            </div>
        </div>
    </header>
    <!-- Home -->
    <section class="swiper" id="home">
        <div class="swiper-wrapper" id="home-container"></div>
    </section>

    <section class="coming" id="coming">
        <h2 class="heading">Coming Soon</h2>
        <!--Coming Container-->
        <div class="coming-container swiper">
            <div class="swiper-wrapper" id="upcoming-movies">

            </div>
        </div>
    </section>
    <!--Popular_movie-->
    <section class="popular" id="popular">
        <h2 class="heading">Popular Movies</h2>
        <!--Coming Container-->
        <div class="popular-container swiper">
            <div class="swiper-wrapper" id="popular-movies">

            </div>
        </div>
    </section>
    <!--Movies List-->
    <section class="movies" id="movies">
        <h2 class="heading">All movies</h2>
        <div class="filter-container">
            <select id="genre-filter">
                <option class="genre" value="0" selected>All</option>
            </select>
        </div>
        <!-- Movies Conatiner-->
        <div class="movies-container" id="list-movies">

        </div>
    </section>
    <!--TOP RATED-->
    <section class="top-rated" id="top-rated">
        <h2 class="heading">Top Rated</h2>
        <!--Coming Container-->
        <div class="top-rated-container swiper">
            <div class="swiper-wrapper" id="toprated-movies">

            </div>
        </div>
    </section>
    <!--Recomanded Movies-->
    <input id="user-age" type="text" value="<?php echo $user->getAge() != null ? $user->getAge() : ""; ?>" hidden>
    <section class="recommended" id="recommended">
        <h2 class="heading">Recomanded For You</h2>
        <div class="recommended-container swiper">
            <div class="swiper-wrapper" id="recommended-movies">

            </div>
        </div>
    </section>
    <!-- NewsLetter -->
    <section class="newsletter" id="newsletter">
        <h2>Subscribe To Get <br>Newsletter</h2>
        <form action="">
            <input type="email" class="email" placeholder="Enter Email ..." required>
            <input type="submit" value="Subscribe" class="btn">
        </form>
    </section>
    <!-- Footer -->
    <section class="footer">
        <a href="#" class="logo">
            <i class='bx bxs-movie'></i>CineMate
        </a>
        <div class="social">
            <a href="#"><i class='bx bxl-facebook'></i></a>
            <a href="#"><i class='bx bxl-twitter'></i></a>
            <a href="#"><i class='bx bxl-instagram'></i></a>
            <a href="#"><i class='bx bxl-tiktok'></i></a>
        </div>
    </section>
    <!-- Copyright -->
    <div class="copyright">
        <p>&#169; CineMate 2023</p>
    </div>
</body>

</html>


//!
<!--Coming-->