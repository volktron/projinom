## Syntax Highlighting
Projinom uses [Prism](https://prismjs.com) as its syntax highlighter, with the following languages available by default:

* __PHP__
* Bash
* Javascript
* Typescript

## Usage
In order to syntax highlight a block of code, simply use standard markdown syntax for code blocks,
and make sure to specify which language it's in.

For example:
```php
<?php echo "Hello, World!";
```
can be generated by (ignoring the leading `>`s):
````
> ```php
> <?php echo "Hello, World!";
> ```
````