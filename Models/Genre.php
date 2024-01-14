<?php
class Genre
{
    /* #region //? Attributes */
    private int $id;
    private ?string $name;
    /* #endregion */

    /* #region //? Getters */
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    /* #endregion */

    /* #region //? Constructor */
    public function __construct(int $id = 0, ?string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }
    /* #endregion */
}
?>