let header = document.querySelector('header');
let menu = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbar');



window.addEventListener('scroll', () => {
    header.classList.toggle('shadow',window.scrollY>0);
});

menu.onclick = () => {
    menu.classList.toggle('bx-x');
    navbar.classList.toggle('active');
}
window.onscroll = () => {
    menu.classList.remove('bx-x');
    navbar.classList.remove('active');
}

let movie_id = document.getElementById('movie-id');
let movie_poster = document.getElementById('movie-poster');
let movie_title = document.getElementById('movie-title');
let movie_overview = document.getElementById('movie-overview');
let movie_rating = document.getElementById('movie-rating');
let movie_release_date = document.getElementById('movie-release-date');
let btn_add_movie_to_watch_list = document.getElementById('btn-add-movie-to-watch-list');
let btn_comment = document.getElementById('btn-comment');
let review_comment = document.getElementById('review-comment');
let review_rating = document.getElementById('review-rating');

const params = new URLSearchParams(window.location.search);
    const movieId = params.get('movieId');
    const movieTitle = params.get('movieTitle');
    const moviePosterPath = params.get('moviePosterPath');
    const movieOverview = params.get('movieOverview');
    const movieRating = params.get('movieVoteAverage');
    const movieReleaseDate = params.get('movieReleaseDate');


movie_poster.src="https://image.tmdb.org/t/p/w500/"+moviePosterPath;
movie_title.innerHTML=movieTitle;
movie_overview.innerHTML=movieOverview;
movie_rating.innerHTML += movieRating;
movie_release_date.innerHTML=movieReleaseDate;
movie_id.innerHTML=movieId;
movie_id.setAttribute('value', movieId);


btn_add_movie_to_watch_list.addEventListener('click', () =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "userInfos.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            location.reload();
        }
    };

    xhr.send(`movieId=${movieId}&movieTitle=${encodeURIComponent(movieTitle)}&moviePosterPath=${encodeURIComponent(moviePosterPath)}&movieOverview=${encodeURIComponent(movieOverview)}&movieVoteAverage=${movieRating}&movieReleaseDate=${movieReleaseDate}&addMovie=true`);
});

btn_comment.addEventListener("click", () => {
    // let xhr = new XMLHttpRequest();
    // xhr.open("POST", "movieInfo.php", true);
    // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    // xhr.onreadystatechange = function () {
    //     if (xhr.readyState === 4 && xhr.status === 200) {
    //         location.reload();
    //     }
    // };

    // xhr.send(`movieId=${movieId}&movieTitle=${encodeURIComponent(movieTitle)}&moviePosterPath=${encodeURIComponent(moviePosterPath)}&movieOverview=${encodeURIComponent(movieOverview)}&movieVoteAverage=${movieRating}&movieReleaseDate=${movieReleaseDate}&comment=${comment.value}&addComment=true`);

    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `movieId=${movieId}&movieTitle=${encodeURIComponent(movieTitle)}&moviePosterPath=${encodeURIComponent(moviePosterPath)}&movieOverview=${encodeURIComponent(movieOverview).replace(/'/g, "%27")}&movieVoteAverage=${movieRating}&movieReleaseDate=${encodeURIComponent(movieReleaseDate)}&reviewComment=${encodeURIComponent(review_comment.value)}&reviewRating=${parseFloat(review_rating.value)}&addReview=true`,
    };

    fetch('movieInfo.php', options)
        .then(response => response.text())
        .then(message => {
            location.reload();
            console.log(message);
        })
        .catch(error => console.error('Error:', error));
});

function deleteReview(reviewId){
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `reviewId=${reviewId}&deleteReview=true`,
    };

    fetch('movieInfo.php', options)
        .then(response => response.text())
        .then(message => {
            location.reload();
            console.log(message);
        })
        .catch(error => console.error('Error:', error));
}



