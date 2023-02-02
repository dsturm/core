<?php

namespace Waterhole\Formatter;

use Illuminate\Contracts\Cache\Repository;
use s9e\TextFormatter\Configurator;
use s9e\TextFormatter\Parser;
use s9e\TextFormatter\Renderer;
use s9e\TextFormatter\Unparser;

/**
 * The Formatter parses plain text content and renders it as HTML.
 *
 * Waterhole uses the TextFormatter library to safely format markup. This class
 * is an abstraction around TextFormatter, enabling extension and caching of its
 * configuration and renderer.
 *
 * @link https://github.com/s9e/TextFormatter
 */
class Formatter
{
    protected string $cacheDir;
    protected Repository $cache;
    protected string $cacheKey;
    protected array $configurationCallbacks = [];
    protected array $parsingCallbacks = [];
    protected array $renderingCallbacks = [];

    public function __construct(string $cacheDir, Repository $cache, string $cacheKey)
    {
        $this->cacheDir = $cacheDir;
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
    }

    /**
     * Add a configuration callback to the formatter.
     */
    public function configure(callable $callback): void
    {
        $this->configurationCallbacks[] = $callback;
    }

    /**
     * Parse plain text into an XML document for storage in the database.
     */
    public function parse(string $text, Context $context = null): string
    {
        $parser = $this->getParser();

        foreach ($this->parsingCallbacks as $callback) {
            $callback($parser, $text, $context);
        }

        return $parser->parse($text);
    }

    /**
     * Add a parsing callback to the formatter.
     */
    public function parsing(callable $callback): void
    {
        $this->parsingCallbacks[] = $callback;
    }

    /**
     * Transform a parsed XML document into HTML.
     */
    public function render(string $xml, Context $context = null): string
    {
        $renderer = $this->getRenderer();

        foreach ($this->renderingCallbacks as $callback) {
            $callback($renderer, $xml, $context);
        }

        return $renderer->render($xml);
    }

    /**
     * Add a rendering callback to the formatter.
     */
    public function rendering(callable $callback): void
    {
        $this->renderingCallbacks[] = $callback;
    }

    /**
     * Revert a parsed XML document back into plain text.
     */
    public function unparse(string $xml): string
    {
        return Unparser::unparse($xml);
    }

    /**
     * Flush the formatter from the cache.
     */
    public function flush(): void
    {
        $this->cache->forget($this->cacheKey);
    }

    protected function getConfigurator(): Configurator
    {
        $configurator = new Configurator();

        $configurator->tags->onDuplicate('replace');

        $this->configureRenderingCache($configurator);

        foreach ($this->configurationCallbacks as $callback) {
            $callback($configurator);
        }

        $this->configureExternalLinks($configurator);

        return $configurator;
    }

    protected function getComponent(string $name)
    {
        $components = $this->cache->rememberForever(
            $this->cacheKey,
            fn() => $this->getConfigurator()->finalize(),
        );

        return $components[$name];
    }

    protected function getParser(): Parser
    {
        return $this->getComponent('parser');
    }

    protected function getRenderer(): Renderer
    {
        spl_autoload_register(function ($class) {
            if (file_exists($file = "$this->cacheDir/$class.php")) {
                include $file;
            }
        });

        return $this->getComponent('renderer');
    }

    private function configureExternalLinks(Configurator $configurator): void
    {
        $dom = $configurator->tags['URL']->template->asDOM();

        foreach ($dom->getElementsByTagName('a') as $a) {
            $a->setAttribute('target', '_blank');
            $a->setAttribute('rel', 'nofollow ugc');
        }

        $dom->saveChanges();
    }

    private function configureRenderingCache(Configurator $configurator): void
    {
        $configurator->rendering->engine = 'PHP';
        $configurator->rendering->engine->cacheDir = $this->cacheDir;
    }
}
