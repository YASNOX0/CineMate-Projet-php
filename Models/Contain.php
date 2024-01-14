<?php
class Contain
{
    /* #region //? Attributes */
    private Genre $genre;
    private Movie $movie;
    /* #endregion */

    /* #region //? Getters */
    public function getGenre(): Genre
    {
        return $this->genre;
    }
    public function getMovie(): Movie
    {
        return $this->movie;
    }
    /* #endregion */

    /* #region //? Constructor */
    public function __construct(Genre $genre , Movie $movie)
    {
        $this->genre = $genre;
        $this->movie = $movie;
    }
    /* #endregion */
}
?>