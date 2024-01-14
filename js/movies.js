const options = {
    method: 'GET',
    headers: {
      accept: 'application/json',
      Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJlOGJjNGE3Y2E0YzdmZTQwYTAyMzIwNjFhOTQ1NTI2ZCIsInN1YiI6IjY0MTA5Mzg3ZWRlMWIwMjg2MzVjYTY0YSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.cUltxj6iJIAtXn3T1de-6_VqrUSJJ5pP9b75oVUrptE'
    }
  };
  
  fetch('https://api.themoviedb.org/3/movie/now_playing?', options)
  .then(response => response.json())
  .then(response => {
      let card = document.getElementById('card');
      let movies = response.results;
      movies.forEach(movie => {
          card.innerHTML += 
          `<div class="card" style="width: 18rem;">
              <img src="https://image.tmdb.org/t/p/w500/${movie.poster_path}" alt="${movie.title}" style="width: 500px; height: 500px;">
              <div class="card-body">
                  <h5 class="card-title">${movie.title}</h5>
              </div>
              <ul class="list-group list-group-flush">
                  <li class="list-group-item">${movie.overview}</li>
                  <li class="list-group-item">imdb : ${movie.vote_average}</li>
              </ul>
              <button onclick="addMovieToWatchList('${encodeURIComponent(movie.id)}', '${encodeURIComponent(movie.title)}', '${encodeURIComponent(movie.poster_path)}','${encodeURIComponent(movie.overview).replace(/'/g, "%27")}', '${encodeURIComponent(movie.vote_average)}', '${encodeURIComponent(movie.release_date)}')">Add to watch list</button>
              <a href="/MoviesProject/movieInfo.php?movieId=${movie.id}&movieTitle=${movie.title}&moviePosterPath=${movie.poster_path}&movieOverview=${movie.overview}&movieVoteAverage=${movie.vote_average}&movieReleaseDate=${movie.release_date}"><button>Book in</button></a>
          </div>`
      });
  })
  .catch(err => console.error(err));

function addMovieToWatchList(movieId, movieTitle, moviePosterPath, movieOverview, movieVoteAverage, movieReleaseDate) {
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `movieId=${movieId}&movieTitle=${encodeURIComponent(movieTitle)}&moviePosterPath=${encodeURIComponent(moviePosterPath)}&movieOverview=${encodeURIComponent(movieOverview)}&movieVoteAverage=${movieVoteAverage}&movieReleaseDate=${movieReleaseDate}&addMovie=true`,
    };

    fetch('userInfos.php', options)
        .then(response => response.text())
        .then(message => {
            console.log(message); 
        })
        .catch(error => console.error('Error:', error));
}


function removeMovieFromWatchList(movieId){
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `movieId=${movieId}&removeMovie=true`,
    };

    fetch('userInfos.php', options)
        .then(response => response.text())
        .then(message => {
            location.reload();
            console.log(message); 
        })
        .catch(error => console.error('Error:', error));
}

// function addMovieToWatchList(movieId, movieTitle, moviePosterPath, movieOverview, movieVoteAverage, movieReleaseDate) {
//     let xhr = new XMLHttpRequest();
//     xhr.open("POST", "userInfos.php", true);
//     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             location.reload();
//         }
//     };

//     xhr.send(`movieId=${movieId}&movieTitle=${encodeURIComponent(movieTitle)}&moviePosterPath=${encodeURIComponent(moviePosterPath)}&movieOverview=${encodeURIComponent(movieOverview)}&movieVoteAverage=${movieVoteAverage}&movieReleaseDate=${movieReleaseDate}&addMovie=true`);
// }

// function reedMore(movieId, movieTitle, moviePosterPath, movieOverview, movieVoteAverage, movieReleaseDate){
//     let xhr = new XMLHttpRequest();
//     xhr.open("POST", "movieInfo.php", true);
//     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             window.location.href = "movieInfo.php";
//         }
//     };

//     xhr.send(`movieId=${movieId}&movieTitle=${encodeURIComponent(movieTitle)}&moviePosterPath=${encodeURIComponent(moviePosterPath)}&movieOverview=${encodeURIComponent(movieOverview)}&movieVoteAverage=${movieVoteAverage}&movieReleaseDate=${movieReleaseDate}`); 
// }

function reedMore(movieId, movieTitle, moviePosterPath, movieOverview, movieVoteAverage, movieReleaseDate) {
    let movie_poster = document.getElementById('movie-poster');
    let movie_title = document.getElementById('movie-title');
    let movie_overview = document.getElementById('movie-overview');
    let movie_rating = document.getElementById('movie-rating');
    let movie_release_date = document.getElementById('movie-release-date');

    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `movieId=${movieId}&removeMovie=true`,
    };

    fetch('movieInfo.php', options)
        .then(response => response.text())
        .then(message => {
            movie_title.innerHTML = "hgdjkjlkllkjhfdxghjkllkjhgfhjk";
            console.log(message);
            window.location.href = "movieInfo.php"; 
        })
        .catch(error => console.error('Error:', error));

    
}