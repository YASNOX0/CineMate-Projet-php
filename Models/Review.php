<?php
require_once('User.php');
require_once('Movie.php');
class Review
{
    /* #region //? Attributes */
    private ?User $user;
    private ?Movie $movie;
    private float $rating;
    private ?string $comment;
    private ?DateTime $reviewDate;
    /* #endregion */

    /* #region //? Getters and Setters */
    public function getUser() : ?User
    {
        return $this->user;
    }
    public function setUser(?User $user)
    {
        $this->user = $user;
    }

    public function getMovie() : ?Movie
    {
        return $this->movie;
    }
    public function setMovie(?Movie $movie)
    {
        $this->movie = $movie;
    }

    public function getRating() : float
    {
        return $this->rating;
    }
    public function setRating(float $rating)
    {
        if($rating <0 || $rating > 10){
            throw new Exception ("Invalid rating");
        }
        $this->rating = $rating;
    }

    public function getComment() : ?string
    {
        return $this->comment;
    }
    public function setComment(?string $comment)
    {
        $this->comment = $comment;
    }

    public function getReviewDate() : ?DateTime
    {
        return $this->reviewDate;
    }
    public function setReviewDate(?DateTime $reviewDate)
    {
        $this->reviewDate = $reviewDate;
    }
    /* #endregion */

    /* #region //? Constructor */
    //* new DateTime('now', new DateTimeZone('Africa/Casablanca'));
    public function __construct(?User $user = null, ?Movie $movie = null, float $rating, ?string $comment = null , ?DateTime $reviewDate)
    {
        $this->setUser($user);
        $this->setMovie($movie);
        $this->setRating($rating);
        $this->setComment($comment);
        $this->setReviewDate($reviewDate);
    }
    /* #endregion */
}
?>