# Projinom
Projinom is a static site generator for software project documentation.
It parses a directory of markdown files and creates a clean static site
similar to documentation for Bootstrap.

# Usage
```shell
composer require volktron/projinom
```

## Setup
To create a new Projinom set of documentation, run the following command:

```shell
./vendor/bin/projinom init <destination>
```

Follow instructions on screen.

## Build
To run Projinom, run the following command in your project directory:

```shell
./vendor/bin/projinom build <source> <destination>
```

Projinom will generate files based on content in `source` and place the output in `destination`.

## Configuration
In the root of the documentation materials, a `projinom.php` must be defined.
This file must follow the following format:

```php
return [
    'name' => '<the name of your project>',
    'type' => '<documentation>',
    'versions_directory' => '<versions>',
    'header_links' => [
        [
            'label' => 'Github',
            'url' => 'https://github.com/<your project>'
        ]
    ]
];
```

Within the `versions_directory`, create folders for each version of your project you want documentation for.

Within each version, an `index.php` must be created to specify sections of documentation and their
individual sections. It is defined in PHP (as opposed to JSON) to make preserving the order of each element
easier to maintain. This also allows for programmatic generation of the data structure if desired.

For example:

```php
return [
    'directory' => [
        [
            'name' => 'Getting Started',
            'pages' => [
                'Introduction',
                'Setup'
            ]
        ],
        [
            'name' => 'Tutorial',
            'pages' => [
                'Breakfast',
                'Lunch',
                'Dinner'
            ]
        ]
    ]
];
```

Each element in a `pages` array also corresponds to a markdown file, 
e.g. `Breakfast` will tell Projinom to look for a `Breakfast.md`. 