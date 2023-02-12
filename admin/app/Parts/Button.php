<?php
namespace App\Parts;

class Button
{
    protected $buttons = [];

    public function addButton($name, $label, $attr=[])
    {
        $this->buttons[$name] = [
            'name' => $name,
            'label' => $label,
            'attr' => $attr,
        ];

        return $this;
    }

    public function getButtons()
    {
        $buttons = $this->buttons;

        return $buttons;
    }

    public function isEmpty()
	{
		return empty($this->buttons);
	}

}