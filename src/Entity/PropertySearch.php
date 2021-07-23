<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch
{

   /**
    * @var int | null
    * @Assert\Range(min = 20000, max = 2000000)
    */

   private $maxPrice;

   /**
    * @var int | null
    * @Assert\Range(min = 10, max=400)
    */

   private $minSurface;

   /**
    * @var ArrayCollection
    */
   private $options;

   public function __construct()
   {
      $this->options = new ArrayCollection();
   }




   /**
    * Get the value of maxPrice
    */
   public function getMaxPrice()
   {
      return $this->maxPrice;
   }

   /**
    * Set the value of maxPrice
    */
   public function setMaxPrice(int $maxPrice): self
   {
      $this->maxPrice = $maxPrice;

      return $this;
   }

   /**
    * Get the value of minSurface
    */
   public function getMinSurface()
   {
      return $this->minSurface;
   }

   /**
    * Set the value of minSurface
    */
   public function setMinSurface(int $minSurface): self
   {
      $this->minSurface = $minSurface;

      return $this;
   }

   /**
    * Get the value of options
    */
   public function getOptions()
   {
      return $this->options;
   }

   /**
    * Set the value of options
    */
   public function setOptions($options): self
   {
      $this->options = $options;

      return $this;
   }
}
