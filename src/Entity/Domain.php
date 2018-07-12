<?php

namespace PreviewTechs\DomainReseller\Entity;


class Domain
{
    /**
     * @var string
     */
    public $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Domain
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}