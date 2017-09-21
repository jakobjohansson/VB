<?php

namespace kiwi\System\Templating;

use kiwi\System\Filesystem;
use kiwi\System\Templating\Compilers\CompilerInterface;

class Engine
{
    /**
     * The path to the file to interpret.
     *
     * @var string
     */
    private $path;

    /**
     * The file content.
     *
     * @var string
     */
    private $content;

    /**
     * An array holding the compilers.
     *
     * @var array
     */
    private $compilers = [];

    /**
     * Create a new Engine instance.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;

        $this->storePathContent();

        $this->addCompilers(CompilerMap::get());
    }

    /**
     * Store the file's content into a string.
     *
     * @return $this
     */
    private function storePathContent()
    {
        $this->content = file_get_contents($this->path);
    }

    /**
     * Add a compiler to the engine.
     *
     * @param CompilerInterface $compiler
     */
    public function addCompiler(CompilerInterface $compiler)
    {
        $this->compilers[] = $compiler;
    }

    /**
     * Add an array of compilers to the engine.
     *
     * @param array $compilers
     */
    public function addCompilers(array $compilers)
    {
        foreach ($compilers as $compiler) {
            $this->addCompiler(new $compiler());
        }
    }

    /**
     * Compile the directives in the file.
     *
     * @return void
     */
    public function compile()
    {
        foreach ($this->compilers as $compiler) {
            $this->content = $compiler->run($this->content);
        }

        $this->writeCache();
    }

    /**
     * Write the processed content to cache.
     *
     * @return void
     */
    private function writeCache()
    {
        Filesystem::remove('cache/' . basename($this->path));
        Filesystem::write($this->content, 'cache/' . basename($this->path));
    }
}
