<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->config['name']?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/9000.0.1/themes/prism-tomorrow.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        .token {
            text-shadow: none;
        }

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
                                <button class="nav-link pt-1 pb-1"
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
            <?php foreach($versionConfig['directory'] as $section) { ?>
                <?php foreach($section['pages'] as $page) { ?>
                    <section class="tab-pane fade" id="<?=$page?>">
                        <div class="container">
                            <?=$section['pageContent'][$page]?>
                        </div>
                    </section>
                <?php } ?>
            <?php } ?>
        </div>
    </main>
    <script
            src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/9000.0.1/prism.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/9000.0.1/components/prism-php.min.js" crossorigin="anonymous"></script>
    <script>
        $('#sidebar .nav-item:first button').trigger('click');
    </script>
</body>
</html>
