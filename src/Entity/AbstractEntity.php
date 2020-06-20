<?php


namespace App\Entity;


use DateTime;
use Doctrine\ORM\Mapping as ORM;

class AbstractEntity
{
	/**
	 * @var DateTime
	 * @ORM\Column(name="date_update", type="datetime", nullable=false)
	 */
    public DateTime $dateUpdate;

	/**
	 * @var DateTime
	 * @ORM\Column(name="date_create", type="datetime", nullable=false)
	 */
    public DateTime $dateCreate;

	public function __construct()
	{
		$this->dateUpdate = new DateTime();
		$this->dateCreate = new DateTime();
	}

}