<?php

namespace Brunocfalcao\Zahper;

use Illuminate\Support\Str;

class ZahperComponent
{
    protected $components;

    protected $attributes;

    protected $text = null;

    public $parent = null;

    /**
     * MJML component tag name.
     *
     * @see https://mjml.io/documentation/#components
     *
     * @var string
     */
    protected $tag;

    public function __construct(string $tag, string $text = null, array $attributes = [])
    {
        $this->components = collect();
        $this->attributes = collect();

        if (count($attributes) > 0) {
            foreach ($attributes as $key => $value) {
                $this->attribute($key, $value);
            }
        }

        $this->tag = $tag;
        $this->text = $text;
    }

    /**
     * Returns the parsed MJML.
     *
     * REMARK: There is no parsing error verifications.
     *
     * @return string
     */
    public function parse()
    {
        $output = "<{$this->tag}";

        // Attributes rendering inside the component tag.
        $this->attributes->each(function ($attribute) use (&$output) {
            $output .= $attribute->render();
        });

        // Closing component start tag, so we can then render the component children.
        $output .= '>';

        // Render any filled tag text.
        $output .= $this->text;

        $this->components->each(function ($component) use (&$output) {
            $output .= $component->parse();
        });

        // Closing component end tag. Render ended.
        $output .= "</{$this->tag}>";

        return $output;
    }

    public function parent()
    {
        return $this->parent;
    }

    /**
     * Adds a new child component to the current component.
     *
     * @param  string Child component name
     * @param  mixed [string title | array attributes ]
     * @param  array attributes
     *
     * @return ZahperComponent
     */
    public function with(string $component, ...$args)
    {
        $text = null;
        $attributes = [];

        /*
         * We can have a with(<component>)
         * or
         * We can have a with(<component>, <inner text>)
         * or
         * We can have a with(<component>, <inner text>, <attributes array>)
         */

        if (count($args) == 1) {
            if (is_array($args[0])) {
                $attributes = $args[0];
            } else {
                $text = $args[0];
            }
        }

        if (count($args) == 2) {
            $text = $args[0];
            $attributes = $args[1];
        }

        $childComponent = new ZahperComponent($component, $text, $attributes);
        $childComponent->parent = $this;

        $this->components->push($childComponent);

        return $childComponent;
    }

    /**
     * Adds a single attribute to the component.
     *
     * @param  string Attribute name
     * @param  string|null Attribute value
     *
     * @return ZahperComponent
     */
    public function attribute(string $name, string $value = null)
    {
        $this->attributes->push(new ZahperAttribute($name, $this->parseValue($name, $value)));

        return $this;
    }

    public static function make(string $tag = null, string $text = null)
    {
        return new self($tag ?? 'mjml', $text);
    }

    public function __call($method, $parameters)
    {
        if (count($parameters) == 0) {
            $this->attribute(Str::kebab($method));
        } else {
            // There can be only one parameter for now.
            $this->attribute(Str::kebab($method), $parameters[0]);
        }

        return $this;
    }

    /**
     * For each attribute name/value there might be a value conversion to apply.
     * This method checks for the attribute name and in certain cases apply
     * a value transformation. In case more are needed we just need to add
     * them here.
     *
     * @param  string $name
     * @param  string|null $value
     *
     * @return string
     */
    public function parseValue(string $name, string $value = null)
    {
        switch ($name) {
            case 'src':
                return config('zahper.images.render') == 'cid' ? "{{ \$message->embed('{$value}') }}" : $value;
            break;

            default:
                return $value;
        }
    }

    public function __toString()
    {
        return $this->parse();
    }
}
