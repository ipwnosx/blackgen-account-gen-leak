<?php require 'inc/_global/config.php'; ?>
<?php require 'inc/backend/config.php'; ?>
<?php require 'inc/_global/views/head_start.php'; ?>
<?php require 'inc/_global/views/head_end.php'; ?>
<?php require 'inc/_global/views/page_start.php'; ?>
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Lottery</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Personal space</li>
                    <li class="breadcrumb-item active" aria-current="page">Lottery</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->
<!-- Page Content -->

<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Lottery</h3>

        </div>
        <div class="content content-narrow">
            <div class="row push">
                <div class="col-lg-12" id="div"></div>
                <div class="col-lg-12">
                    <form class="form-horizontal push-10-t push-10" method="post" onsubmit="return false;">
                        <div class="form-group row items-push mb-0">
                            <div class="col-md-12" style="text-align:center">
                                <button type="button" class="btn btn-hero-success js-click-ripple-enabled" onclick="generate()" type="submit" data-toggle="click-ripple" style="margin-right:auto;margin-left:auto;overflow: hidden; position: relative; z-index: 1;">Try your luck</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="block block-rounded block-bordered">
        <h3 style='display: none;'> <i style="display: none;" id="manage" class="fa fa-cog fa-spin"></i> </h3>
        <h3 style='display: none;'>
            <i style="display: none;" id="image" class="fa fa-cog fa-spin"></i>
        </h3>
        <div class="block-content">
            <div class="animated zoomIn" id="recentdiv" style="display:inline-block;width:100%"></div>
        </div>
    </div>
</div>



<?php require 'inc/_global/views/page_end.php'; ?>

<script>
    logs();

    function logs() {
        document.getElementById("recentdiv").style.display = "none";
        document.getElementById("manage").style.display = "inline";
        var xmlhttp;
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("recentdiv").innerHTML = xmlhttp.responseText;
                document.getElementById("manage").style.display = "none";
                document.getElementById("recentdiv").style.display = "inline-block";
                document.getElementById("recentdiv").style.width = "100%";
                eval(document.getElementById("ajax").innerHTML);
            }
        }
        xmlhttp.open("GET", "inc/ajax/user/loterie/recent.php", true);
        xmlhttp.send();
    }

    function generate() {
        var type = 1;
        document.getElementById("image").style.display = "inline";
        document.getElementById("div").style.display = "none";
        var xmlhttp;
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("image").style.display = "none";
                    logs();
                    document.getElementById("div").innerHTML = xmlhttp.responseText;
                    document.getElementById("div").style.display = "inline";
            }
        }
        xmlhttp.open("GET", "inc/ajax/user/loterie/hub.php?type=" + type, true);
        xmlhttp.send();
    }
</script>

<?php require 'inc/_global/views/footer_start.php'; ?>
<?php require 'inc/_global/views/footer_end.php'; ?>
