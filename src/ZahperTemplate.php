<?php

namespace Brunocfalcao\Zahper;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class ZahperTemplate
{
    /**
     * The Zahper mjml component that will be parsed into html.
     *
     * @var ZahperComponent
     */
    protected $component;

    /**
     * MJMP api results after a call.
     *
     * @see https://mjml.io/api/documentation/
     *
     * @var object
     */
    protected $apiResult;

    /**
     * A generated uuid. Used as a link for the view in browser feature.
     *
     * @var string
     */
    protected static $uuid;

    /**
     * Template name. This is based in a full namespace name and stored in
     * the zahper disk. Used to verify if the template is cached or not.
     *
     * @var string
     */
    protected $name;

    /**
     * Should we reuse a view that was already cached?
     * Pro's and con's so be aware about it.
     *
     * REMARKS:
     * 1. The view rendering is not cached. Meaning you can use things like:
     * $with('mj-text', "{{ \$variable }}").
     *
     * 2. This view is, by default, cached. In case you don't want to cache
     * it you need to use uncomment the line in the constructor method.
     *
     * 3. If you don't cache, you are hitting the MJML API each time you
     * render the mailable! So, if you are sending 500 newsletters you will
     * use the API 500 times! Make sure don't get your API blocked due to this
     * mistake.
     *
     * 3. The cache content is static, but the view rendering is not.
     * As examples:
     * ->with('mj-text', 'Hi there ' . Str::random(10));
     * will be cached with the same random number.
     *
     * ->with('mj-text', 'Hi there {{ str_random(10) }}');
     * will NOT be cached since it is calculated directly in the view.
     *
     * @var bool
     */
    public static $cache = false;

    public function __construct(ZahperComponent $component, $name)
    {
        // Configure template.
        $this->component = $component;
        $this->name = $this->setName($name);

        // Compile template. Yeap. Done immediately upon object instanciation.
        $this->compile();
    }

    /**
     * Store the view rendered content.
     *
     * @param  array $viewData The mailable view data.
     *
     * @return void
     */
    public function renderAndStore(string $uuid, array $viewData = [])
    {
        $content = View::make('zahper::'.$this->getName().'-html')
                       ->with($viewData)
                       ->render();

        Storage::disk('zahper-emails')->put(
            $uuid.'.html',
            $content
        );
    }

    /**
     * Stores the compiled template blade view, ready to be used by the
     * zahper mailable. The first time it is rendered, it gets written in the
     * storage defined in your zahper config.
     *
     * @return ZahperTemplate
     */
    protected function storeView()
    {
        if (! blank($this->apiResult->html)) {
            Storage::disk('zahper-views')->put(
                $this->name.'-html.blade.php',
                $this->apiResult->html
            );

            // Transform it to a text version. For now, strip all the html tags.
            Storage::disk('zahper-views')->put(
                $this->name.'-text.blade.php',
                $this->convertToText(($this->apiResult->html))
            );
        }

        return $this;
    }

    /**
     * Converts the api result into text.
     *
     * @param  string $html The api resulted blade view html.
     *
     * @return string
     */
    protected function convertToText(string $html)
    {
        return strip_tags($html);
    }

    /**
     * Do we have this template view cached?
     *
     * @return bool
     */
    protected function exists()
    {
        return File::exists(config('zahper.storage.paths.views').
                            '/'.
                            $this->name.
                            '-html.blade.php');
    }

    /**
     * Calculate or define the template name for views.
     *
     * @param  string $name given name.
     *
     * @return string
     */
    protected function setName($name = null)
    {
        if (! is_null($name)) {
            return strtolower(strtr($name, ['\\' => '-', '/' => '-']));
        } else {
            return Str::random(10);
        }
    }

    /**
     * Compiles an mjml into a blade view via mjml api.
     * This html is still a blade view, that will then be parsed in the mailable.
     * Compilation occurs only if the view is not in the zahper disk cache.
     * If it exists, then it will retrieve the cached view.
     *
     * @see https://mjml.io/api/documentation/
     *
     * @return object|ZahperTemplate
     */
    protected function compile()
    {
        if (! $this->exists() || ! static::$cache) {
            $this->apiResult = (object) ZahperApi::compile($this->component->parse());
            $this->storeView();

            return $this;
        }

        // Template is cached, and cache was used. Nothing to do.
        return $this;
    }

    /**
     * Generates an uuid (for view in browser and unsubscribe).
     *
     * @return string
     */
    public static function generateUUid()
    {
        $uuid = Str::random(20);
        static::$uuid = $uuid;

        return $uuid;
    }

    public static function make(ZahperComponent $component, string $name = null)
    {
        return new self($component, $name);
    }

    /**
     * Returns the mjml api results.
     *
     * @return string
     */
    public function getResults()
    {
        return $this->apiResult;
    }

    /**
     * Returns the name of the template.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
