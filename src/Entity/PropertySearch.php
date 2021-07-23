<?php

namespace App\Entity;

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
}
