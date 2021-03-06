<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Individu
 *
 * @ORM\Table(name="individu", indexes={@ORM\Index(name="fk_individu_utilisateur", columns={"idUtilisateur"})})
 * @ORM\Entity(repositoryClass="App\Repository\IndividuRepository")
 */
class Individu
{
    /**
     * @var int
     *
     * @ORM\Column(name="idIndividu", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idindividu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $nom ;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(message=" nom ne doit etre non vide")
     *
     * @ORM\Column(name="prenom", type="string", length=100, nullable=true, options={"default"="NULL"})
     */

    private $prenom  ;


    /**
     * @var \DateTime|null
     *
     *
     * @ORM\Column(name="dateNaissance", type="date", nullable=true, options={"default"="NULL"})
     */
    private $datenaissance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=true, options={"default"="NULL"})
     */
    private $sexe ;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse", type="string", length=300, nullable=true, options={"default"="NULL"})
     */
    private $adresse ;

    /**
     * @var string|null
     *
     *
     * @ORM\Column(name="facebook", type="string", length=300, nullable=true, options={"default"="NULL"})
     */
    private $facebook;

    /**
     * @var string|null
     *
     * @ORM\Column(name="instagram", type="string", length=300, nullable=true, options={"default"="NULL"})
     */
    private $instagram;

    /**
     * @var string|null
     *
     * @ORM\Column(name="whatsapp", type="string", length=300, nullable=true, options={"default"="NULL"})
     */
    private $whatsapp ;

    /**
     * @var bool
     *
     * @ORM\Column(name="proprietaireChien", type="boolean", nullable=false)
     */
    private $proprietairechien = '0';

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUtilisateur", referencedColumnName="idUtilisateur")
     * })
     */
    private $idutilisateur;

    /**
     * @param int $idindividu
     */

    public function __construct()
    {

    }


    public function getIdindividu(): ?int
    {
        return $this->idindividu;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(?\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getWhatsapp(): ?string
    {
        return $this->whatsapp;
    }

    public function setWhatsapp(?string $whatsapp): self
    {
        $this->whatsapp = $whatsapp;

        return $this;
    }

    public function getProprietairechien(): ?bool
    {
        return $this->proprietairechien;
    }

    public function setProprietairechien(bool $proprietairechien): self
    {
        $this->proprietairechien = $proprietairechien;

        return $this;
    }

    public function getIdutilisateur(): ?Utilisateur
    {
        return $this->idutilisateur;
    }

    public function setIdutilisateur(?Utilisateur $idutilisateur): self
    {
        $this->idutilisateur = $idutilisateur;

        return $this;
    }

    public function __toString() {
        return (strval($this->idindividu).'-'.$this->prenom);
    }

}
