<?php

namespace BandMergerBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="image", nullable=true, type="string", length=255)
     */
    private $image;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * 
     * @ORM\ManyToMany(targetEntity="Band", inversedBy="users")
     * @ORM\JoinTable(name="users_bands")
     */
    private $bands;
    
     /**
     * @ORM\OneToMany(targetEntity="Band", mappedBy="admin")
     */
    private $ownedBands;
    
    public function __construct()
    {
        parent::__construct();
        $this->bands = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ownedBands = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set image
     *
     * @param string $image
     * @return User
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return User
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add bands
     *
     * @param \BandMergerBundle\Entity\Band $bands
     * @return User
     */
    public function addBand(\BandMergerBundle\Entity\Band $bands)
    {
        $this->bands[] = $bands;

        return $this;
    }

    /**
     * Remove bands
     *
     * @param \BandMergerBundle\Entity\Band $bands
     */
    public function removeBand(\BandMergerBundle\Entity\Band $bands)
    {
        $this->bands->removeElement($bands);
    }

    /**
     * Get bands
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBands()
    {
        return $this->bands;
    }

    /**
     * Add ownedBands
     *
     * @param \BandMergerBundle\Entity\Band $ownedBands
     * @return User
     */
    public function addOwnedBand(\BandMergerBundle\Entity\Band $ownedBands)
    {
        $this->ownedBands[] = $ownedBands;

        return $this;
    }

    /**
     * Remove ownedBands
     *
     * @param \BandMergerBundle\Entity\Band $ownedBands
     */
    public function removeOwnedBand(\BandMergerBundle\Entity\Band $ownedBands)
    {
        $this->ownedBands->removeElement($ownedBands);
    }

    /**
     * Get ownedBands
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwnedBands()
    {
        return $this->ownedBands;
    }
}
