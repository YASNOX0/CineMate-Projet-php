<?php
class Movie
{
    /* #region //? Attributes */
    private int $movieId;
    private ?string $posterURI;
    private ?string $title;
    private ?string $releaseDate;
    private ?string $overview;
    private ?string $genres;
    private float $rating;
    /* #endregion */

    /* #region //? Getters and setters */
    public function getMovieID(): int
    {
        return $this->movieId;
    }

    public function getPosterURI(): ?string
    {
        return $this->posterURI;
    }
    public function setPosterURI($posterURI)
    {
        $this->posterURI = $posterURI;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }
    public function setOverview($overview)
    {
        $this->overview = $overview;
    }

    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    public function getGenres(): ?string
    {
        return $this->genres;
    }
    public function setGenres($genres)
    {
        $this->genres = $genres;
    }

    public function getRating(): float
    {
        return $this->rating;
    }
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
    /* #endregion */

    /* #region //? Constructor */
    public function __construct($movieId = 0, ? string $posterURI = null, ? string $title = null, ? string $overview = null , ? string $releaseDate = null, ? string $genres =  null, $rating = 0.0)
    {
        $this->movieId = $movieId;
        $this->setPosterURI($posterURI);
        $this->setTitle($title);
        $this->setOverview($overview);
        $this->setReleaseDate($releaseDate);
        $this->setGenres($genres);
        $this->setRating($rating);
    }
    /* #endregion */

    /* #region //? Methods */
    public function __toString()
    {
        return "[movieId={$this->getMovieID()},posterURI={$this->getPosterURI()},title={$this->getTitle()},overview={$this->getOverview()},genres={$this->getGenres()},releaseDate={$this->getReleaseDate()},rating={$this->getRating()}]";
    }

    public static function extractFromToString($strMovie)
    {
        $pattern = '/[movieId=(\d+),posterURI=([^,]+),title=([^,]+),overview=([^,]+),genres=([^,]+),releaseDate=([^,]+),rating=([0-9.]+)\]/';

        if (preg_match($pattern, $strMovie, $matches)) {

            $mId = (int)$matches[1];
            $mPosterURI = $matches[2];
            $mTitle = $matches[3];
            $mOverview = $matches[4];
            $mGenres = $matches[5];
            $mReleaseDate = $matches[6];
            $mRating = (float)$matches[7];

            return new Movie($mId, $mPosterURI, $mTitle, $mOverview, $mReleaseDate, $mGenres, $mRating);
        } else {

            return null;
        }
    }
    /* #endregion */
}
