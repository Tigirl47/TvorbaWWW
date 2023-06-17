<?php

$pageIdx = isset($_GET['sid']) ? $_GET['sid'] : 0;

?>


<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Ctvrte cviceni - sablony</title>
  <style>
    header {
      background-color: aqua;
    }

    nav {
      background-color: yellow;
    }

    main {
      background-color: green;
    }

    footer {
      background-color: goldenrod;
    }
  </style>
</head>

<body>
  <header>
    <?php

    renderHeader($pageIdx);

    function renderHeader($id)
    {
      switch ($id) {
        case 0:
          echo "?";
          //include("index.php");
          break;
        case 1:
          echo "Sortiment";
          //include("./inc/sortiment.php");
          break;
        case 2:
          echo "Kontakty";
          //include("./inc/kontakty.php");
          break;
      }
    }

    ?>
  </header>

  <nav>
    <a href="sablona.php?sid=0">Úvod</a>
    &nbsp;|&nbsp;
    <a href="sablona.php?sid=1">Sortiment</a>
    &nbsp;|&nbsp;
    <a href="sablona.php?sid=2">Kontakty</a>
  </nav>

  <main>
    <?php

    renderDifferentPage($pageIdx);

    function renderDifferentPage($id)
    {
      switch ($id) {
        case 0:
          echo "0";
          //include("./inc/uvod.php");
          break;
        case 1:
          echo "1";
          //include("./inc/sortiment.php");
          break;
        case 2:
          echo "2";
          //include("./inc/kontakty.php");
          break;
        default:
          echo "Default";
        // here we could've handled e.g. 404 error and render 404 page :)
        //include("./inc/uvod.php");
      }
    }

    ?>
  </main>

  <footer>
    Footer
  </footer>
</body>

</html>