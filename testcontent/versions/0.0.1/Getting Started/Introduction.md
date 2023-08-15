# Introduction
This is a page

```php
for($i = 0; $i < $numSections; $i++) {
    $versionConfig['directory'][$i]['pageContent'] = [];
    foreach($versionConfig['directory'][$i]['pages'] as $page) {
        $contentPath = $versionPath . $versionConfig['directory'][$i]['name'] . DIRECTORY_SEPARATOR . $page . '.md';
        $rawContent = file_get_contents($contentPath);
        $content = $parsedown->parse($rawContent);
        $versionConfig['directory'][$i]['pageContent'][$page] = $content;
    }
}
```