<?php

namespace Brunocfalcao\Zahper;

class ZahperAttribute
{
    protected $name;

    protected $value;

    public function __construct(string $name = null, string $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function render()
    {
        return " {$this->name}=\"{$this->value}\"";
    }

    public function name(string $name)
    {
        $this->name = $name;
    }

    public function value(string $value)
    {
        $this->value = $value;
    }

    public static function make(string $name, string $value)
    {
        return new self($name, $value);
    }
}
