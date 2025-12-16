<?php
class Actualite
{
	public $date;
	public $titre;
    public $contenu;

	public function __construct(string $titre, string $date, string $contenu)
    {
        $this->titre = $titre;
        $this->date = $date;
        $this->contenu = $contenu;
    }
}
