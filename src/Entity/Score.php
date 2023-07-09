<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="scores")
 */
class Score
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $playerName;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreValue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayerName(): ?string
    {
        return $this->playerName;
    }

    public function setPlayerName(string $playerName): void
    {
        $this->playerName = $playerName;
    }

    public function getScoreValue(): ?int
    {
        return $this->scoreValue;
    }

    public function setScoreValue(int $scoreValue): void
    {
        $this->scoreValue = $scoreValue;
    }
}
