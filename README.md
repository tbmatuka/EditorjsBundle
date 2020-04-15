# EditorjsBundle
Symfony bundle that integrates Editor.js primarily with Symfony Forms.

## Installation

### Symfony

1. Download the package with composer: `$ composer require tbmatuka/editorjs-bundle`
1. Add the bundle to `bundles.php` if it wasn't added automatically: `Tbmatuka\EditorjsBundle\TbmatukaEditorjsBundle::class => ['all' => true],`
1. Copy the example package config file (`examples/ediotrjs.yaml`) or use it as an example to create your own configuration.
1. Add the form theme to your twig configuration:
```php
twig:
  form_themes:
    - '@TbmatukaEditorjs/Form/editorjs_widget.html.twig'
```

### JavaScript

There is an example of the JS implementation in `examples/editorjs-init.js`.

#### Encore/webpack

If you're using Encore, you will need to install the npm package for Editor.js (`@editorjs/editorjs`) and any plugins that you want to use. Copy the example to your assets dir, add the plugin classes to the array and import the file from your main JS file.

#### Inline
Configuration options and examples will have to be added for other loading methods (like loading JS from the CDN or a local path inline in the widget), but they're not there for now.

## Usage

### Symfony Forms

You can use the `EditorjsType` in your forms to get Editor.js on the frontend. Data (decoded json) is returned as an array.

### Twig

You can get an Editor.js config directly from the Twig extension. Check the form widget in `src/Resources/views/Form/editorjs_widget.html.twig` to see how to use it. The `editorjs()` Twig function accepts either a configuration object or just the name of a configuration that you want to use.

## Contributing

Any kind of help is welcome, but especially information about the included JS not working in specific browsers. Please open an issue to discuss whatever you want to work on before you submit a pull request and avoid any kind of BC breaking changes unless they are agreed to in the issue discussion.
