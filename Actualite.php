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

    public function getTitre() :string
    {
        return $this->titre;
    }
    
    public function setDate() :void
    {
        $this->date = date('Y-m-d');
    }

    public function getContenu() :string
    {
        return $this->contenu;
    }
}