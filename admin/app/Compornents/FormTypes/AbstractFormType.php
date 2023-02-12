<?php
namespace App\Compornents\FormTypes;

abstract class AbstractFormType
{
    protected $template;
    protected $name;
    protected $label;
    protected $defaultData;

    

    /**
     * Get the value of label
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of label
     *
     * @return  self
     */ 
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the value of defaultData
     */ 
    public function getDefaultData()
    {
        return $this->defaultData;
    }

    /**
     * Set the value of defaultData
     *
     * @return  self
     */ 
    public function setDefaultData($defaultData)
    {
        $this->defaultData = $defaultData;

        return $this;
    }
}