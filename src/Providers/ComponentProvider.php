<?php


namespace Netflex\FormBuilder\Providers;


abstract class ComponentProvider extends \Illuminate\Support\ServiceProvider
{

    public const FIELD_KEY = "form-builder-fields";
    public const RENDERER_KEY = "form-builder-renderer";


    /**
     *
     * The renderer name is the name you have to specify to the form builder blade component to specify which
     * renderer you want to use.
     *
     * If you only use one renderer, use the name default as you then dont have to specify it when rendering
     *
     * @param string $rendererName
     * @param string $class
     */
    protected function registerRenderer(string $rendererName,string $class) {
        if(!$this->app->has(self::RENDERER_KEY)) {
            $this->app->bind(self::RENDERER_KEY, []);
        }
        $this->app->bind(self::RENDERER_KEY, array_merge($this->app->get(self::RENDERER_KEY), [
            $rendererName => $class
        ]));
    }

    /**
     *
     * Registers a question/field tupe for the form builder.
     * Used when converting matrix entries to form builder fields.
     *
     * **$matrixType** has to be consistent with the alias of the matrix field in netflex
     *
     * @param string $matrixType
     * @param string $class
     */
    protected function registerField(string $matrixType, string $class) {
        if(!$this->app->has(self::FIELD_KEY)) {
            $this->app->bind(self::FIELD_KEY, []);
        }
        $this->app->bind(self::FIELD_KEY, array_merge($this->app->get(self::FIELD_KEY), [
            $matrixType => $class
        ]));
    }

}
