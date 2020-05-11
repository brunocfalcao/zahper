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
     * Adds a new component to the mjml parent component.
     *
     * @param  string Component name
     * @param  mixed [string title | array attributes ]
     *
     * @return ZahperComponent
     */
    public function with(string $component, ...$args)
    {
        $text = null;
        $attributes = [];

        if (count($args) == 1) {
            if (is_array($args[0])) {
                $attributes = $args[0];
            } else {
                $text = $args[0];
            }
        };

        if (count($args) == 2) {
            $text = $args[0];
            $attributes = $args[1];
        };

        $component = new ZahperComponent($component, $text, $attributes);
        $component-> parent = $this;

        $this->components->push($component);

        return $component;
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
        /**
         * In case an attribute key is 'src', then we need to render
         * the image accordingly to the config('zahper.image.render').
         *
         */
        if ($name == 'src' && config('zahper.images.render') == 'cid') {
            $value = "{{ \$message->embed('{$value}') }}";
        }

        $this->attributes->push(new ZahperAttribute($name, $value));

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
            $this->attribute(Str::kebab($method), $parameters[0]);
        }

        return $this;
    }
}
