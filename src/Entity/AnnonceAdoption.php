<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AnnonceAdoption
 *
 * @ORM\Table(name="annonce_adoption", indexes={@ORM\Index(name="fk_annonceAdoption_chien", columns={"idChien"}), @ORM\Index(name="idIndividu", columns={"idIndividu"})})
 * @ORM\Entity(repositoryClass="App\Repository\AnnonceAdoptionRepository")
 */
class AnnonceAdoption
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAnnonceAdoption", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idannonceadoption;

    /**
     * @var \DateTime
     *@Assert\NotBlank(message=" titre doit etre non vide")
     * @ORM\Column(name="datePublication", type="date", nullable=false)
     */
    private $datepublication;

    /**
     * @var string|null
     * @Assert\Length(
     *      min = 5,
     *      minMessage=" au moin 5 caractéres"
     *
     *     )
     * @ORM\Column(name="description", type="string", length=200, nullable=true, options={"default"="NULL"})
     * 
     */
    private $description ;

    /**
     * @var string|null
     *@Assert\Length(
     *      min = 5,
     *      minMessage=" au moin 5 caractéres"
     *
     *     )
     * @ORM\Column(name="localisation", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $localisation ;

    /**
     * @var \Individu
     *@Assert\NotBlank(message=" champ obligatoire")
     * @ORM\ManyToOne(targetEntity="Individu")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idIndividu", referencedColumnName="idIndividu")
     * })
     */
    private $idindividu;

    /**
     * @var \Chien
     *@Assert\NotBlank(message=" champ obligatoire")
     * @ORM\ManyToOne(targetEntity="Chien")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idChien", referencedColumnName="idChien")
     * })
     */
    private $idchien;

    public function getIdannonceadoption(): ?int
    {
        return $this->idannonceadoption;
    }

    public function getDatepublication(): ?\DateTimeInterface
    {
        return $this->datepublication;
    }

    public function setDatepublication(\DateTimeInterface $datepublication): self
    {
        $this->datepublication = $datepublication;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getIdindividu(): ?Individu
    {
        return $this->idindividu;
    }

    public function setIdindividu(?Individu $idindividu): self
    {
        $this->idindividu = $idindividu;

        return $this;
    }

    public function getIdchien(): ?Chien
    {
        return $this->idchien;
    }

    public function setIdchien(?Chien $idchien): self
    {
        $this->idchien = $idchien;

        return $this;
    }


}
