<?php require 'inc/_global/config.php'; ?>
<?php require 'inc/backend/config.php'; ?>
<?php require 'inc/_global/views/head_start.php';
if ($gen_free == 0){
    header('Location: home.php');
    die();
}?>
<?php require 'inc/_global/views/head_end.php'; ?>
<?php require 'inc/_global/views/page_start.php';
$SQLCheck = $odb -> prepare("SELECT COUNT(*) FROM `logs_free` WHERE `username` = ? AND `date` > ?");
$SQLCheck -> execute(array($_SESSION['username'], strtotime(date('d-m-Y 00:00:00'))));
$limit = $SQLCheck->fetch();
$recupNbGenFree = $odb->query('SELECT * FROM plans_free WHERE id = 1');
$recupNbGenFree = $recupNbGenFree->fetch();
$nbGen = $recupNbGenFree['limit']-$limit[0];
?>
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">The different generators free</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Free generator</li>
                    <li class="breadcrumb-item active" aria-current="page">My free generators</li>
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
            <h3 class="block-title">Generators free</h3>
            <div class="block-options">
                <div class="block-options-item">
                        <?php
                        if ($nbGen > 1){
                            echo '<div class="alert alert-info py-2 mb-0"><i class="fa fa-info-circle mr-1"></i> '.$nbGen.' remaining generations</div>';
                        } elseif ($nbGen == 1){
                            echo '<div class="alert alert-warning py-2 mb-0"><i class="fas fa-exclamation-triangle"></i> 1 remaining generation</div>';
                        } elseif ($nbGen == 0){
                            echo '<div class="alert alert-danger py-2 mb-0"><i class="fas fa-exclamation-circle"></i> No generation left</div>';
                        }
                        ?>
                </div>
            </div>
        </div>
        <div class="content content-narrow">
            <div class="row push">
                <div class="col-lg-12" id="div"></div>
                <div class="col-lg-12">
                    <form class="form-horizontal push-10-t push-10" method="post" onsubmit="return false;">
                        <div class="form-group row items-push mb-0">
                            <?php
                                $recupType = $odb->query('SELECT * FROM type_free');
                                foreach ($recupType as $account) {
                                    echo '
                                      <div class="col-md-2">
                                          <div class="custom-control custom-block custom-control-primary mb-1">
                                              <input type="radio" value="'.$account['name'].'" class="custom-control-input" id="example-rd-custom-block'.$account['name'].'" name="example-rd-custom-block">
                                              <label class="custom-control-label" for="example-rd-custom-block'.$account['name'].'">
                                                  <span class="d-block font-w400 text-center my-3">
                                                  <img class="img-avatar img-avatar32" src="'.$account['img'].'" alt=""></br>
                                                      <span class="font-size-h4 font-w600">'.$account['name'].'</span>
                                                  </span>
                                              </label>
                                          </div>
                                      </div>
                                      ';
                                }

                            ?>
                            <div class="col-md-12" style="text-align:center">
                                <button type="button" class="btn btn-hero-success js-click-ripple-enabled" onclick="generate()" type="submit" data-toggle="click-ripple" style="margin-right:auto;margin-left:auto;overflow: hidden; position: relative; z-index: 1;">Generate</button>
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
        xmlhttp.open("GET", "inc/ajax/user/hub2/recent.php", true);
        xmlhttp.send();
    }

    function generate() {
        var type = document.querySelector('input[name="example-rd-custom-block"]:checked').value;
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
                if (xmlhttp.responseText.search("success") != -1) {
                    logs();
                } else {
                    document.getElementById("div").innerHTML = xmlhttp.responseText;
                    document.getElementById("div").style.display = "inline";
                }
            }
        }
        xmlhttp.open("GET", "inc/ajax/user/hub2/hub.php?type=" + type, true);
        xmlhttp.send();
    }
</script>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-1385406617572117",
          enable_page_level_ads: true
     });
</script>

<?php require 'inc/_global/views/footer_start.php'; ?>
<?php require 'inc/_global/views/footer_end.php'; ?>
