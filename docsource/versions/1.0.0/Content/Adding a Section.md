## Adding a Section
Adding a section to your documentation is simple:

### Create a file
Create a file with the markdown extension, e.g. `Adding a Section.md`

### Update index.php
Add the name of the file (without the extension) to the `index.php` of the version you are working in.

Before:
```php
'pages' => [
    'Apple',
    'Orange',
]
```

After:
```php
'pages' => [
    'Apple',
    'Orange',
    'Adding a Section'
]
```

Once this is done, rebuild the project and the new content will show up.
