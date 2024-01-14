let header = document.querySelector("header");
let menu = document.querySelector("#menu-icon");
let navbar = document.querySelector(".navbar");

window.addEventListener("scroll", () => {
  header.classList.toggle("shadow", window.scrollY > 0);
});

menu.onclick = () => {
  menu.classList.toggle("bx-x");
  navbar.classList.toggle("active");
};
window.onscroll = () => {
  menu.classList.remove("bx-x");
  navbar.classList.remove("active");
};

var swiper = new Swiper("#home", {
  spaceBetween: 30,
  centeredSlides: true,
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});

// Swiper
var swiper = new Swiper(".coming-container", {
  spaceBetween: 20,
  loop: true,
  autoplay: {
    deley: 55000,
    disableOnInteraction: false,
  },
  centeredSlides: true,
  breakpoints: {
    0: {
      slidesPerView: 2,
    },
    568: {
      slidesPerView: 3,
    },
    768: {
      slidesPerView: 4,
    },
    968: {
      slidesPerView: 5,
    },
  },
});

//swiper popular 
var swiper = new Swiper(".popular-container", {
  spaceBetween: 20,
  loop: true,
  autoplay: {
      delay: 5500,
      disableOnInteraction: false,
  },
  centeredSlides: true,
  breakpoints: {
      0: {
          slidesPerView: 2,
      },
      568: {
          slidesPerView: 3,
      },
      768: {
          slidesPerView: 4,
      },
      968: {
          slidesPerView: 5,
      },
  },
});

//TOP RATED
var swiper = new Swiper(".top-rated-container", {
  spaceBetween: 20,
  loop: true,
  autoplay: {
      delay: 5500,
      disableOnInteraction: false,
  },
  centeredSlides: true,
  breakpoints: {
      0: {
          slidesPerView: 2,
      },
      568: {
          slidesPerView: 3,
      },
      768: {
          slidesPerView: 4,
      },
      968: {
          slidesPerView: 5,
      },
  },
});

//Recommended
//swiper popular 
var swiper = new Swiper(".recommended-container", {
  spaceBetween: 20,
  loop: true,
  autoplay: {
      delay: 5500,
      disableOnInteraction: false,
  },
  centeredSlides: true,
  breakpoints: {
      0: {
          slidesPerView: 2,
      },
      568: {
          slidesPerView: 3,
      },
      768: {
          slidesPerView: 4,
      },
      968: {
          slidesPerView: 5,
      },
  },
});


let searchInput = document.getElementById('search-input');
searchInput.addEventListener('keyup', function () {
    searchMovies();
});

function searchMovies() {
    let search_input = document.getElementById('search-input').value;
    let searchResultsContainer = document.getElementById('search-result');

    if (search_input.trim() !== '') {
        fetch(`https://api.themoviedb.org/3/search/movie?api_key=e8bc4a7ca4c7fe40a0232061a945526d&query=${encodeURIComponent(search_input)}`)
            .then(response => response.json())
            .then(response => {
                searchResultsContainer.innerHTML = "";
                let searchResults = response.results;
                searchResults.forEach(searchResult => {
                    if (searchResult.poster_path) {
                        searchResultsContainer.innerHTML += `
                        <a href="/MoviesProject/movieInfo.php?movieId=${searchResult.id}&movieTitle=${searchResult.title}&moviePosterPath=${searchResult.poster_path}&movieOverview=${searchResult.overview}&movieVoteAverage=${searchResult.vote_average}&movieReleaseDate=${searchResult.release_date}" class="card">
                                <img src="https://image.tmdb.org/t/p/w500/${searchResult.poster_path}" alt="${searchResult.title}">
                                <div class="content">
                                    <p>${searchResult.title}</p>
                                    <div class="content_info">
                                        <span>${searchResult.release_date} | ${searchResult.genre_ids.join(', ')}</span>
                                    </div>
                                </div>
                            </a>
                        `;
                    }
                });
                console.log(response);
            })
            .catch(err => console.error(err));
    } else {
        searchResultsContainer.innerHTML = ''; // Clear existing results
    }
}

const options = {
  method: "GET",
  headers: {
    accept: "application/json",
    Authorization:
      "Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJlOGJjNGE3Y2E0YzdmZTQwYTAyMzIwNjFhOTQ1NTI2ZCIsInN1YiI6IjY0MTA5Mzg3ZWRlMWIwMjg2MzVjYTY0YSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.cUltxj6iJIAtXn3T1de-6_VqrUSJJ5pP9b75oVUrptE",
  },
};
var min = 1;
var max = 3;
var randomInt = Math.floor(Math.random() * (max - min)) + min;
fetch(`https://api.themoviedb.org/3/movie/now_playing?language=en-US&page=${randomInt.toString()}`,options)
  .then((response) => response.json())
  .then((response) => {
    let homeContainer = document.getElementById("home-container");
    let movies = response.results;
    movies.forEach((movie) => {
      homeContainer.innerHTML += `
                <div class="swiper-slide conatiner">
                    <img src="https://image.tmdb.org/t/p/w500/${movie.poster_path}" alt="${movie.title}" style="width: 100%; height: 640px;">
                    <div class="home-text">
                        <span>${movie.original_title}</span>
                        <h1>${movie.title}</h1>
                        <a class="btn" href="/MoviesProject/movieInfo.php?movieId=${movie.id}&movieTitle=${movie.title}&moviePosterPath=${movie.poster_path}&movieOverview=${movie.overview}&movieVoteAverage=${movie.vote_average}&movieReleaseDate=${movie.release_date}">Book in</a>
                        <a href="#" class="play">
                            <i class='bx bx-play'></i>
                        </a>
                    </div>
                </div>`;
    });
  })
  .catch((err) => console.error(err));

  fetch('https://api.themoviedb.org/3/discover/movie?api_key=e8bc4a7ca4c7fe40a0232061a945526d')
  .then(response => response.json())
  .then(response => {
      let Movies = document.getElementById('list-movies');
      let movies = response.results;
      Movies.innerHTML = "";

      for (let i = 0; i < 20; i++) {
          let movieHtml = `
          <div class="swiper-slide box">
              <div class="box-img">
                  <img src="https://image.tmdb.org/t/p/w500/${movies[i].poster_path}" alt="${movies[i].title}">
                  <h3>${movies[i].title}</h3>
                  <div class="overlay">
                      <div class="read-more">
                          <p>${movies[i].overview.substring(0, 100) + "..."}</p>
                          <a href="bookin.html">Read more</a>
                          <button class="toggleButton" onclick="toggleState(this)">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                                  <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                              </svg>
                          </button>
                          <div class="prompt hidden">
                              Add successful!
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          `;
          Movies.innerHTML += movieHtml;
      }
  })
  .catch(err => console.error(err));

fetch("https://api.themoviedb.org/3/movie/upcoming", options)
  .then((response) => response.json())
  .then((response) => {
    let upcomingMovies = document.getElementById("upcoming-movies");
    let movies = response.results;
    movies.forEach((movie) => {
      upcomingMovies.innerHTML += `
            <div class="swiper-slide box">
                <div class="box-img">
                    <img src="https://image.tmdb.org/t/p/w500/${encodeURIComponent(movie.poster_path)}" alt="${movie.title}">
                </div>
                <h3>${movie.title}</h3>
                <div class="overlay">
                    <div class="read-more">
                        <p>${movie.overview.substring(0, 100) + "..."}</p>
                        <a href="/MoviesProject/movieInfo.php?movieId=${movie.id}&movieTitle=${movie.title}&moviePosterPath=${movie.poster_path}&movieOverview=${movie.overview}&movieVoteAverage=${movie.vote_average}&movieReleaseDate=${movie.release_date}">Book in</a>
                        <button class="toggleButton" onclick="toggleState(this, '${encodeURIComponent(movie.id)}', '${encodeURIComponent(movie.title)}', '${encodeURIComponent(movie.poster_path)}','${encodeURIComponent(movie.overview).replace(/'/g, "%27")}', '${encodeURIComponent(movie.vote_average)}', '${encodeURIComponent(movie.release_date)}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                            </svg>
                        </button>
                        <div class="prompt hidden">
                            Add successful!
                        </div>
                    </div>
                </div>
            </div>
            `;
    });
  })
  .catch((err) => console.error(err));

  //Popular movie

  fetch('https://api.themoviedb.org/3/movie/popular', options)
  .then(response => response.json())
  .then(response => {
      let popularMovies = document.getElementById('popular-movies');
      let movies = response.results;
      popularMovies.innerHTML = '';
      movies.forEach(movie => {
          let movieHtml = `
          <div class="swiper-slide box">
              <div class="box-img">
                  <img src="https://image.tmdb.org/t/p/w500/${movie.poster_path}" alt="${movie.title}">
              </div>
              <h3>${movie.title}</h3>
              <div class="overlay">
                  <div class="read-more">
                      <p>${movie.overview.substring(0, 100) + "..."}</p>
                      <a href="bookin.html">Read more</a>
                      <button class="toggleButton" onclick="toggleState(this)">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                              <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                          </svg>
                      </button>
                      <div class="prompt hidden">
                          Add successful!
                      </div>
                  </div>
              </div>
          </div>
          `;
          popularMovies.innerHTML += movieHtml;
      });
  })
  .catch(err => console.error(err));

  //end fetch popular movie

  //TOP RATED

  fetch('https://api.themoviedb.org/3/movie/top_rated', options)
  .then(response => response.json())
  .then(response => {
      let topRatedMovies = document.getElementById('toprated-movies');
      let topRateds = response.results;
      topRatedMovies.innerHTML = '';
      topRateds.forEach(topRated => {
          let movieHtml = `
          <div class="swiper-slide box">
              <div class="box-img">
                  <img src="https://image.tmdb.org/t/p/w500/${topRated.poster_path}" alt="${topRated.title}">
              </div>
              <h3>${topRated.title}</h3>
              <div class="overlay">
                  <div class="read-more">
                      <p>${topRated.overview.substring(0, 100) + "..."}</p>
                      <a href="bookin.html">Read more</a>
                      <button class="toggleButton" onclick="toggleState(this)">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                              <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                          </svg>
                      </button>
                      <div class="prompt hidden">
                          Add successful!
                      </div>
                  </div>
              </div>
          </div>
          `;
          topRatedMovies.innerHTML += movieHtml;
      });
  })
  .catch(err => console.error(err));

  //END TOP RATED
 
  let ageRating = "GA";
  if(parseInt(document.getElementById("user-age").value) <= 17){
    ageRating = "PG"
  }
   //Recommended start
   fetch(`https://api.themoviedb.org/3/discover/movie?api_key=e8bc4a7ca4c7fe40a0232061a945526d&certification_country=US&certification=${ageRating}`)
   .then(response => response.json())
   .then(response => {
       let recommendedMovies = document.getElementById('recommended-movies');
       let recommended_movies = response.results;
       recommendedMovies.innerHTML = '';
       recommended_movies.forEach(recommended_movie => {
           let movieHtml = `
           <div class="swiper-slide box">
               <div class="box-img">
                   <img src="https://image.tmdb.org/t/p/w500/${recommended_movie.poster_path}" alt="${recommended_movie.title}">
               </div>
               <h3>${recommended_movie.title}</h3>
               <div class="overlay">
                   <div class="read-more">
                       <p>${recommended_movie.overview.substring(0, 100) + "..."}</p>
                       <a href="bookin.html">Read more</a>
                       <button class="toggleButton" onclick="toggleState(this)">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                               <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                           </svg>
                       </button>
                       <div class="prompt hidden">
                           Add successful!
                       </div>
                   </div>
               </div>
           </div>
           `;
           recommendedMovies.innerHTML += movieHtml;
       });
   })
   .catch(err => console.error(err));

   //Recommended End

//toggle button
function toggleState(
  button,
  movieId,
  movieTitle,
  moviePosterPath,
  movieOverview,
  movieVoteAverage,
  movieReleaseDate
) {
  let prompt = button.parentElement.querySelector(".prompt");
  let isBookmarkAdded = !button.classList.contains("added");

  if (isBookmarkAdded) {
    button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5m8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3"/>
                            </svg>`;
    prompt.innerText = "Add successful!";
    prompt.style.color = "#fff";
    prompt.style.background = "#ff0000a7";
    addMovieToWatchList(
      movieId,
      movieTitle,
      moviePosterPath,
      movieOverview,
      movieVoteAverage,
      movieReleaseDate
    );
  } else {
    button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                            </svg>`;
    prompt.innerText = "Remove successful!";
    prompt.style.color = "#fff";
    prompt.style.background = "#ffffffa8";
    removeMovieFromWatchList(movieId);
  }

  button.classList.add("added");
  prompt.classList.remove("hidden");
  setTimeout(() => {
    prompt.classList.add("hidden");
    button.classList.remove("added");
  }, 2000);
}

function removeMovieFromWatchList(movieId) {
  const options = {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `movieId=${movieId}&removeMovie=true`,
  };

  fetch("userInfos.php", options)
    .then((response) => response.text())
    .then((message) => {
      location.reload();
      console.log(message);
    })
    .catch((error) => console.error("Error:", error));
}

function addMovieToWatchList(
  movieId,
  movieTitle,
  moviePosterPath,
  movieOverview,
  movieVoteAverage,
  movieReleaseDate
) {
  const options = {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `movieId=${movieId}&movieTitle=${encodeURIComponent(movieTitle)}&moviePosterPath=${encodeURIComponent(moviePosterPath)}&movieOverview=${encodeURIComponent(movieOverview)}&movieVoteAverage=${movieVoteAverage}&movieReleaseDate=${movieReleaseDate}&addMovie=true`,
  };

  fetch("userInfos.php", options)
    .then((response) => response.text())
    .then((message) => {
      console.log(message);
    })
    .catch((error) => console.error("Error:", error));
}
let genreFilter = document.getElementById("genre-filter");
fetch("https://api.themoviedb.org/3/genre/movie/list?language=en", options)
  .then((response) => response.json())
  .then((response) => {
    let genres = response.genres;
    genres.forEach((genre) => {
      genreFilter.innerHTML += `
          <option class="genre" value="${genre["id"]}">${genre["name"]}</option>`;
    });
  })
  .catch((err) => console.error(err));

genreFilter.addEventListener("change", () => {
  let selectedGenreId = genreFilter.options[genreFilter.selectedIndex].value;
  fetch(`https://api.themoviedb.org/3/discover/movie?api_key=e8bc4a7ca4c7fe40a0232061a945526d&with_genres=${selectedGenreId}`)
  .then((response) => response.json())
  .then((response) => {
    let Movies = document.getElementById('list-movies');
      let movies = response.results;
      Movies.innerHTML = "";
      for (let i = 0; i < 25; i++) {
        Movies.innerHTML += `
          <div class="swiper-slide box">
              <div class="box-img">
                  <img src="https://image.tmdb.org/t/p/w500/${movies[i].poster_path}" alt="${movies[i].title}">
                  <h3>${movies[i].title}</h3>
                  <div class="overlay">
                      <div class="read-more">
                          <p>${movies[i].overview.substring(0, 100) + "..."}</p>
                          <a href="bookin.html">Read more</a>
                          <button class="toggleButton" onclick="toggleState(this)">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                                  <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                              </svg>
                          </button>
                          <div class="prompt hidden">
                              Add successful!
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          `;
      }
  })
  .catch((err) => console.error(err)); 
});

