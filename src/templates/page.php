<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->config['name']?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        .sidebar {
            position: fixed;
            top: 4em;
            bottom: 0;
            left: 0;
            padding: 0 0; /* Height of navbar */
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
            width: 220px;
            z-index: 600;
        }

        main {
            padding-left: 240px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><?=$this->config['name']?></a>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?=$version?>
                                </button>
                                <ul class="dropdown-menu">
                                    <?php foreach($this->versionDirectories as $outputVersion) { ?>
                                        <li><a class="dropdown-item" href="<?=$outputVersion?>.html"><?=$outputVersion?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </li>

                        <?php foreach($this->config['header_links'] as $header_link) { ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?=$header_link['url']?>"><?=$header_link['label']?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

            </div>
        </nav>

        <nav id="sidebar" class="sidebar ms-1 ps-2">
            <div class="mb-3">

                <ul class="nav flex-column">
                    <?php foreach($versionConfig['directory'] as $section) { ?>
                        <li>
                            <p class="h5 mt-3"><?=$section['name']?></p>
                        </li>
                        <?php foreach($section['pages'] as $page) { ?>
                            <li class="nav-item">
                                <button class="nav-link pt-1 pb-1 active"
                                        data-bs-toggle="tab"
                                        data-bs-target="#<?=$page?>"><?=$page?></button>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <div class="tab-content mt-3">
            <section class="tab-pane fade show active" id="introduction">
                <h1>Introduction</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
            </section>
            <section class="tab-pane fade" id="setup">
                <h1>Setup</h1>
                <pre class="chroma">
                    <code class="language-html" data-lang="html">
                        &lt;?php echo "hello world";
                        &lt;html&gt;
                    </code>
                </pre>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
            </section>
            <section class="tab-pane fade" id="routing">
                <h1>Routing</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
            </section>
            <section class="tab-pane fade" id="database">
                <h1>Database</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis dolorem, fugiat ipsum, magni, nam neque nisi similique sit tempora tenetur veritatis. Doloremque earum error esse ex expedita magni necessitatibus odio officiis, optio porro quo rem repellat sequi velit voluptate. At, debitis, ipsam! Adipisci aspernatur dignissimos error illum modi nisi nobis perferendis, possimus quidem sint ullam velit vero. Architecto beatae dicta dolore eligendi explicabo fugit impedit ipsum molestias nobis, provident saepe vero voluptate! Aliquid asperiores autem deleniti dolorum facilis quis sunt. Alias assumenda, consectetur deserunt dicta dolorem dolores excepturi expedita facere, possimus provident quibusdam quidem quis quisquam quod sapiente tempora?</p>
            </section>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
