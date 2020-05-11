<?php

namespace Brunocfalcao\Zahper;

use Brunocfalcao\Zahper\ZahperComponent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ZahperTemplate
{
    protected $component;
    protected $apiResult;
    protected $uuid;
    protected $name;
    public static $dontCache = false;

    public static $cached = [];

    public function __construct(ZahperComponent $component, $name = null)
    {
        // Configure template.
        $this->component = $component;
        $this->name = $this->name($name);
        $this->uuid = (string) Str::uuid();

        // Compile template.
        $this->compile();
    }

    /**
     * Stores the compiled template into a view, ready to be used by the
     * zahper mailable. The first time it is rendered, it gets cached.
     * At the moment it's computed the html version.
     *
     * $TODO: Store a text version too.
     *
     * @return ZahperTemplate
     */
    protected function store()
    {
        if (!blank($this->apiResult->html)) {
            Storage::disk('zahper-views')->put($this->name . '-html.blade.php', $this->apiResult->html);
        }

        return $this;
    }

    /**
     * Do we have this template view cached?
     *
     * @return bool
     */
    protected function exists()
    {
        return File::exists(config('zahper.storage.paths.views') . '/' . $this->name . '-html.blade.php');
    }

    /**
     * Calculate or define the template name for views.
     *
     * @param  string $name given name.
     *
     * @return void
     */
    protected function name($name = null)
    {
        if (!is_null($name)) {
            return strtolower(strtr($name, ['\\' => '-', '/' => '-']));
        } else {
            Str:random(10);
        }
    }

    /**
     * Compiles an MJML into HTML via MJML api.
     * Compilation occurs only if the view is not in the zahper disk cache.
     * If it exists, then it will retrieve the cached view.
     *
     * @see https://mjml.io/api/documentation/
     *
     * @return stdClass|ZahperTemplate
     */
    protected function compile()
    {
        if (!$this->exists() || static::$dontCache) {
            $this->apiResult = (object) ZahperApi::compile($this->component->parse());
            $this->store();

            return $this;
        };

        return $this;
    }

    /**
     * If you don't want to cache your template, and recompile it each time a
     * new mailable is generated to send an email.
     *
     * @return void
     */
    public static function dontCache()
    {
        static::$dontCache = false;
    }

    public static function make(ZahperComponent $component, string $name = null)
    {
        return new self($component, $name);
    }

    public function getResults()
    {
        return $this->apiResults;
    }

    public function getName()
    {
        return $this->name;
    }
}
