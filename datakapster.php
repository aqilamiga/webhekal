<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Data Kapster</title>
    <link rel="stylesheet" href="./assets/css/kapster.css" />
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main class="content kapster-page">
        <div class="kapster-card-wrapper">
            <div class="kapster-card">
                <h2>Data Kapster</h2>
                <div class="kapster-search">
                    <input type="text" id="search" placeholder="Nama Kapster">
                    <button id="btnSearch">🔍</button>
                </div>
                <div id="kapster-result"></div>
                <div id="kapster-detail"></div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("btnSearch").addEventListener("click", function () {
                const keyword = document.getElementById("search").value;
                fetch("not-to-show/kapster_ajax.php?keyword=" + keyword)
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById("kapster-result").innerHTML = data;
                        document.getElementById("kapster-detail").innerHTML = "";
                    });
            });
        });
        function getDetail(id) {
            fetch("detail_kapster.php?id=" + id)
                .then(res => res.text())
                .then(data => {
                    document.getElementById("kapster-detail").innerHTML = data;
                });
        }
    </script>
</body>
</html>
