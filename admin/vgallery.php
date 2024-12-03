<?php include "index.php"; ?>
<?php include "./db_connect.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Gallery</title>

    <style type="text/css">
        .gallery-container {
            margin: 20px 0;
            text-align: center;
        }

        .gallery-table {
            width: 80%;
            margin: 0 auto;
            border-collapse: separate;
            border-spacing: 15px;
        }

        .gallery-item img {
            width: 210px;
            height: 210px;
            border-radius: 5px;
            box-shadow: 5px 4px 10px 2px;
        }

        .gallery-item a {
            color: red;
            text-decoration: none;
            display: block;
            margin-top: 5px;
        }

        .gallery-item a:hover {
            color: blue;
        }
    </style>
</head>
<body>

<div class="content">
    <center>
        <a href="gallery.php" style="text-decoration: none; color: red;"></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="vgallery.php" style="text-decoration: none; color: red;">View Gallery</a>
    </center>

    <div class="gallery-container">
        <table class="gallery-table">
            <tr>
                <?php
                $r = 0;
                $s = mysqli_query($conn, "select * from gallery");
                while ($row = mysqli_fetch_array($s)) {
                    echo "<td class='gallery-item'>
                            <img src='{$row['image']}' alt=''>
                            <center><a href='dgallery.php?id={$row['id']}'>Delete</a></center>
                          </td>";
                    $r++;
                    if ($r % 4 == 0) {
                        echo "</tr><tr>";
                    }
                }
                ?>
            </tr>
        </table>
    </div>
</div>

</body>
</html>
