<aside id="side-overlay">

    <div class="bg-image" style="background-image: url('<?php echo $dm->assets_folder; ?>/media/various/bg_side_overlay_header.jpg');">
        <div class="bg-primary-op">
            <div class="content-header">

                <a class="img-link mr-1" href="#">
                    <?php $dm->get_avatar(10, '', 48); ?>
                </a>

                <div class="ml-2">
                    <a class="text-white font-w600" href="#"><?=$_SESSION['username']?></a>
                    <?php
                    $recupGrade = $odb->prepare('SELECT name,id FROM plans WHERE id = ?');
                    $recupGrade->execute(array($_SESSION['grade']));
                    $recupGrade = $recupGrade->fetch();
                    ?>
                    <div class="text-white-75 font-size-sm font-italic"><?=$recupGrade['name']?></div>
                </div>

                <a class="ml-auto text-white" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                    <i class="fa fa-times-circle"></i>
                </a>

            </div>
        </div>
    </div>

    <div class="content-side">

        <div class="block block-transparent pull-x pull-t">
            <ul class="nav nav-tabs nav-tabs-block nav-justified" data-toggle="tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#so-people">
                        <i class="far fa-fw fa-user-circle"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#so-profile">
                        <i class="far fa-fw fa-edit"></i>
                    </a>
                </li>
            </ul>
            <div class="block-content tab-content overflow-hidden">


                <div class="tab-pane pull-x fade fade-up active show" id="so-people" role="tabpanel">
                    <div class="block mb-0">

                        <div class="block-content block-content-sm block-content-full" style="background: #6a82fb linear-gradient(135deg,#6a82fb 0,#fc5c7d 100%)!important;color:white">
                            <span class="text-uppercase font-size-sm font-w700">Team member</span>
                        </div>
                        <div class="block-content block-content-sm block-content-full bg-body">
                            <span class="text-uppercase font-size-sm font-w700">Online</span>
                        </div>


                        <div class="block-content">
                            <ul class="nav-items">
                              <?php
                                    $findAdmins = $odb->query("SELECT * FROM `users` WHERE `rank` = '1' or `rank` = '3'");
                                    while ($rowAdmins = $findAdmins->fetch(PDO::FETCH_BOTH)) {
                                      $diffOnline = time() - $rowAdmins['activity'];
                                      $countOnline = $odb->prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username  AND {$diffOnline} < 60");
                                      $countOnline->execute(array(':username' => $rowAdmins['username']));
                                      $onlineCount = $countOnline->fetchColumn(0);
                                      $logo = "fa fa-ban";
                              				$couleur = "rgba(255, 255, 255, 0.2)";
                                      if ($onlineCount == "1") {
                                        echo '
                                        <a class="media py-2" href="">
                                            <div class="mx-3 overlay-container">
                                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar0.jpg">
                                                <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-success"></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-w600">'.$rowAdmins['username'].'</div>';
                                        if ($rowAdmins['rank'] == 1){
                                            echo '<div style="font-size: 13px;color: red;">Administrator</div>';
                                        }
                                        if ($rowAdmins['rank'] == 3){
                                            echo '<div style="font-size: 13px;color: black;">Moderator</div>';
                                        }
                                        echo'
                                            </div>
                                        </a>';
                                      }
                                  }
                              ?>
                                <li>

                                </li>
                            </ul>
                        </div>

                        <div class="block-content block-content-sm block-content-full bg-body">
                            <span class="text-uppercase font-size-sm font-w700">Offline</span>
                        </div>
                        <div class="block-content">
                            <ul class="nav-items">
                              <?php
                                    $findAdmins = $odb->query("SELECT * FROM `users` WHERE `rank` = '1' or `rank` = '3'");
                                    while ($rowAdmins = $findAdmins->fetch(PDO::FETCH_BOTH)) {
                                      $diffOnline = time() - $rowAdmins['activity'];
                                      $countOnline = $odb->prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username  AND {$diffOnline} < 60");
                                      $countOnline->execute(array(':username' => $rowAdmins['username']));
                                      $onlineCount = $countOnline->fetchColumn(0);
                                      if ($onlineCount != "1") {
                                        echo '
                                        <a class="media py-2" href="#">
                                            <div class="mx-3 overlay-container">
                                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar0.jpg">
                                                <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-muted"></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-w600">'.$rowAdmins['username'].'</div>';
                                        if ($rowAdmins['rank'] == 1){
                                            echo '<div style="font-size: 13px;color: red;">Administrator</div>';
                                        }
                                        if ($rowAdmins['rank'] == 3){
                                            echo '<div style="font-size: 13px;color: black;">Moderator</div>';
                                        }
                                        echo'
                                            </div>
                                        </a>';
                                      }
                                      }

                              ?>
                                <li>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane pull-x fade fade-up" id="so-profile" role="tabpanel">
                  <script type="text/javascript">
                  function setCookie(cname, cvalue, exdays) {
                      var d = new Date();
                      d.setTime(d.getTime() + (exdays*24*60*60*1000));
                      var expires = "expires="+d.toUTCString();
                      document.cookie = cname + "=" + cvalue + "; " + expires;
                  }
                  </script>
                  <div class="block-content block-content-sm block-content-full bg-body">
                      <span class="text-uppercase font-size-sm font-w700">Theme color</span>
                  </div>
                    <div class="block-content block-content-full">
                      <div class="row gutters-tiny text-center">
                          <div class="col-4 mb-1">
                              <a class="d-block py-3 text-white font-size-sm font-w600 bg-default" data-toggle="theme" data-theme="default" href="#">
                                  Blue
                              </a>
                          </div>
                          <div class="col-4 mb-1">
                              <a class="d-block py-3 text-white font-size-sm font-w600 bg-xwork" data-toggle="theme" data-theme="<?php echo $dm->assets_folder; ?>/css/themes/xwork.min.css" href="#">
                                  Black
                              </a>
                          </div>
                          <div class="col-4 mb-1">
                              <a class="d-block py-3 text-white font-size-sm font-w600 bg-xmodern" data-toggle="theme" data-theme="<?php echo $dm->assets_folder; ?>/css/themes/xmodern.min.css" href="#">
                                  Dark blue
                              </a>
                          </div>
                          <div class="col-4 mb-1">
                              <a class="d-block py-3 text-white font-size-sm font-w600 bg-xeco" data-toggle="theme" data-theme="<?php echo $dm->assets_folder; ?>/css/themes/xeco.min.css" href="#">
                                  Green
                              </a>
                          </div>
                          <div class="col-4 mb-1">
                              <a class="d-block py-3 text-white font-size-sm font-w600 bg-xsmooth" data-toggle="theme" data-theme="<?php echo $dm->assets_folder; ?>/css/themes/xsmooth.min.css" href="#">
                                  Purple
                              </a>
                          </div>
                          <div class="col-4 mb-1">
                              <a class="d-block py-3 text-white font-size-sm font-w600 bg-xinspire" data-toggle="theme" data-theme="<?php echo $dm->assets_folder; ?>/css/themes/xinspire.min.css" href="#">
                                  Aquamarine
                              </a>
                          </div>
                          <div class="col-4 mb-1">
                              <a class="d-block py-3 text-white font-size-sm font-w600 bg-xdream" data-toggle="theme" data-theme="<?php echo $dm->assets_folder; ?>/css/themes/xdream.min.css" href="#">
                                  Night Blue
                              </a>
                          </div>
                          <div class="col-4 mb-1">
                              <a class="d-block py-3 text-white font-size-sm font-w600 bg-xpro" data-toggle="theme" data-theme="<?php echo $dm->assets_folder; ?>/css/themes/xpro.min.css" href="#">
                                  Slate Blue
                              </a>
                          </div>
                          <div class="col-4 mb-1">
                              <a class="d-block py-3 text-white font-size-sm font-w600 bg-xplay" data-toggle="theme" data-theme="<?php echo $dm->assets_folder; ?>/css/themes/xplay.min.css" href="#">
                                  Bright red
                              </a>
                          </div>
                      </div>
                    </div>
                    <div class="block-content block-content-sm block-content-full bg-body">
                        <span class="text-uppercase font-size-sm font-w700">Sidebar Theme</span>
                    </div>
                    <div class="block-content block-content-full">
                            <div class="row gutters-tiny text-center">
                                <div class="col-6 mb-1">
                                    <a class="d-block py-3 bg-body-dark font-w600 text-dark" onclick="setCookie('sidebar', '1', 600000)" data-toggle="layout" data-action="sidebar_style_dark" href="javascript:void(0)">Dark</a>

                                </div>
                                <div class="col-6 mb-1">
                                    <a class="d-block py-3 bg-body-dark font-w600 text-dark" onclick="setCookie('sidebar', '0', 600000)" data-toggle="layout" data-action="sidebar_style_light" href="javascript:void(0)">Light</a>
                                </div>
                            </div>
                        </div>
                <div class="block-content block-content-sm block-content-full bg-body">
                    <span class="text-uppercase font-size-sm font-w700">Link your discord [OFF]</span>
                </div>
                  <?php
                  $getEmail = $odb->prepare('SELECT email FROM users WHERE username = ?');
                  $getEmail->execute(array($_SESSION['username']));
                  $getEmail = $getEmail->fetch();
                  ?>
                    <form action="inc/form/form.php" method="post">
                        <div class="block mb-0">

                            <div class="block-content block-content-sm block-content-full bg-body">
                                <span class="text-uppercase font-size-sm font-w700">Personal</span>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?=$_SESSION['username']?>">
                                </div>
                                <div class="form-group">
                                    <label for="so-profile-email">Email</label>
                                    <input type="email" readonly class="form-control" id="so-profile-email" value="<?=$getEmail['email']?>">
                                </div>
                            </div>

                            <div class="block-content block-content-sm block-content-full bg-body">
                                <span class="text-uppercase font-size-sm font-w700">Change password</span>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="form-group">
                                    <label for="so-profile-password">Current Password</label>
                                    <input minlength=6 type="password" class="form-control" id="so-profile-password" name="ancien" required>
                                </div>
                                <div class="form-group">
                                    <label for="so-profile-new-password">New Password</label>
                                    <input minlength=6 type="password" class="form-control" id="so-profile-new-password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="so-profile-new-password-confirm">confirm password</label>
                                    <input minlength=6 type="password" class="form-control" id="so-profile-new-password-confirm" name="password1" required>
                                </div>
                            </div>

                            <div class="block-content row justify-content-center border-top">
                                <div class="col-9">
                                    <button type="submit" name="modifmdp" class="btn btn-block btn-hero-primary">
                                        <i class="fa fa-fw fa-save mr-1"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>
