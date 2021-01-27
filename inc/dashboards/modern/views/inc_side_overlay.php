<aside id="side-overlay">

    <a class="content-header bg-body-dark justify-content-center text-danger" data-toggle="layout" data-action="side_overlay_close" href="javascript:void(0)">
        <i class="fa fa-2x fa-times-circle"></i>
    </a>

    <form action="../inc/form/form.php" method="post">
        <div class="content-side">
            <div class="block pull-x">

                <div class="block-content block-content-sm block-content-full bg-body-dark">
                    <span class="text-uppercase font-size-sm font-w700">Personal Space</span>
                </div>
                <div class="block-content block-content-full">
                    <div class="form-group">
                        <label for="so-profile-name">Username</label>
                        <input disabled type="text" class="form-control form-control-alt" id="so-profile-name" name="so-profile-name" value="<?=$_SESSION['username']?>">
                    </div>
                </div>

                <div class="block-content block-content-sm block-content-full bg-body">
                    <span class="text-uppercase font-size-sm font-w700">Change password</span>
                </div>
                <div class="block-content block-content-full">
                    <div class="form-group">
                        <label for="so-profile-password">Current Password</label>
                        <input minlength=5 type="password" class="form-control" id="so-profile-password" name="ancien" required>
                    </div>
                    <div class="form-group">
                        <label for="so-profile-new-password">New Password</label>
                        <input minlength=5 type="password" class="form-control" id="so-profile-new-password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="so-profile-new-password-confirm">Confirm password</label>
                        <input minlength=5 type="password" class="form-control" id="so-profile-new-password-confirm" name="password1" required>
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
        </div>
    </form>

</aside>
