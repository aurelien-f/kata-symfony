<?php

namespace App\Class;

class MovieDTO
{
  public $title;
  public $year;
  public $imdbID;
  public $type;
  public $poster;

  public function __construct(array $data)
  {
    $this->title = $data['Title'] ?? null;
    $this->year = $data['Year'] ?? null;
    $this->imdbID = $data['imdbID'] ?? null;
    $this->type = $data['Type'] ?? null;
    $this->poster = $data['Poster'] ?? null;
  }
}