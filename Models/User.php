<?php
require_once('Movie.php');
require_once('Genre.php');
require_once(__DIR__ . '/../Database/CRUDS/fMoviesCrud.php');
require_once(__DIR__ . '/../Database/CRUDS/fUsersCrud.php');
require_once(__DIR__ . '/../Database/CRUDS/fGenreCrud.php');
class User
{
    /* #region //? Attributes */
    private ?string $id;
    private ?string $username;
    private ?string $password;
    private ?string $email;
    private int $age;
    private ?string $avatarUrl;
    private ?array $watchlist;
    private ?array $favoriteGenres;
    /* #endregion */

    /* #region //? Getters and Setters */
    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function setUsername(?string $username)
    {
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function setPassword(?string $password)
    {
        $this->password = $password;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(?string $email)
    {
        $this->email = $email;
    }

    public function getAge(): int
    {
        return $this->age;
    }
    public function setAge(int $age)
    {
        if (is_int($age)) {
            $this->age = $age;
        } else {
            throw new Exception("Age must be an Integer");
        }
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }
    public function setAvatarUrl(?string $avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;
    }


    public function getWatchlist(): ?array
    {
        return $this->watchlist;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFavoriteGenres(): ?array
    {
        return $this->favoriteGenres;
    }
    /* #endregion */

    /* #region //? Constructor */
    public function __construct(
        ?string $username = null,
        ?string $password = null,
        ?string $email = null,
        int $age = 0,
        ?string $avatarUrl = null,
        ?array $watchlist = null,
        ?array $favoriteGenres = null
    ) {

        $this->setUsername($username);
        $this->setPassword($password);
        $this->setEmail($email);
        $this->setAvatarUrl($avatarUrl);
        $this->watchlist = $watchlist;
        $this->setAge($age);
        $this->favoriteGenres = $favoriteGenres;
    }
    /* #endregion */

    /* #region //? Methodes to manipulate the watchList*/
    public function addMovieToWatchlist(Movie $movie)
    {
        if (!getMovieById($movie->getMovieID())) {
            createMovie($movie);
        }

        if (!in_array($movie->getMovieID(), $this->watchlist)) {
            array_push($this->watchlist, $movie->getMovieID());

            if (!empty($this->watchlist)) {
                $strWatchList = implode(",", $this->watchlist);

                $strWatchList = ltrim($strWatchList, ',');

                updateUser(
                    $this->getId(),
                    $this->getUsername(),
                    $this->getEmail(),
                    $this->getPassword(),
                    $this->getAge(),
                    $this->getAvatarUrl(),
                    $strWatchList,
                );
            }
        }
    }

    public function removeMovieFromWatchlist(string $movieID)
    {

        $key = array_search($movieID, $this->watchlist);

        if ($key !== false) {
            unset($this->watchlist[$key]);
            $this->watchlist = array_values($this->watchlist);
            $strWatchList = implode(",", $this->watchlist);
            updateUser(
                $this->getId(),
                $this->getUsername(),
                $this->getEmail(),
                $this->getPassword(),
                $this->getAge(),
                $this->getAvatarUrl(),
                $strWatchList
            );
        }
    }
    /* #endregion */

    /* #region //? Methodes to manipulate the favorite Genres*/ 
    public function addGenreToFavoriteGenres(Genre $genre)
    {
        if (!getGenreById($genre->getId())) {
            createGenre($genre);
        }

        if (!in_array($genre->getId(), $this->favoriteGenres)) {
            array_push($this->favoriteGenres, $genre->getId());

            if (!empty($this->favoriteGenres)) {
                $favoriteGenres = implode(",", $this->favoriteGenres);

                $favoriteGenres = ltrim($favoriteGenres, ',');

                updateUser(
                    $this->getId(),
                    $this->getUsername(),
                    $this->getEmail(),
                    $this->getPassword(),
                    $this->getAge(),
                    $this->getAvatarUrl(),
                    $this->getWatchlist(),
                    $favoriteGenres,
                );
            }
        }
    }

    public function removeGenreFromFavoriteGenres(string $genreId)
    {

        $key = array_search($genreId, $this->favoriteGenres);

        if ($key !== false) {
            unset($this->favoriteGenres[$key]);
            $this->favoriteGenres = array_values($this->favoriteGenres);
            $favoriteGenres = implode(",", $this->favoriteGenres);
            updateUser(
                $this->getId(),
                $this->getUsername(),
                $this->getEmail(),
                $this->getPassword(),
                $this->getAge(),
                $this->getAvatarUrl(),
                $this->getWatchlist(),
                $favoriteGenres,
            );
        }
    }
    /* #endregion */

    // public function equals(User $user){
    //     return $this->getUsername() === $user->getUsername() 
    //     && $this->getEmail() === $user->getEmail() 
    //     && $this->getPassword() === $user->getPassword();
    // }

}
