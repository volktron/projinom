## Projinom
Projinom is a static site generator for software project documentation.
It parses a directory of markdown files and creates a clean static site
similar to documentation for Bootstrap.

Documentation: https://volktron.github.io/projinom/index.html

## Usage
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
./vendor/bin/projinom build <source>
```

Projinom will generate files based on content in `source` and place the output in `destination`.

