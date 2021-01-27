<?php
/**
 * backend/views/inc_footer.php
 *
 * Author: pixelcave
 *
 * The footer of each page (Backend pages)
 *
 */
?>
<script>
window.setInterval(function(){					var xmlhttp;					if (window.XMLHttpRequest){						xmlhttp = new XMLHttpRequest();					}					else{						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");					}					xmlhttp.open("GET","../inc/ajax/user/general/status.php?username=<?php echo $_SESSION['username']; ?>",true);					xmlhttp.send();				}, 5000);				</script>

<!-- Footer -->
<footer id="page-footer" class="bg-body-light">
    <div class="content py-0">
        <div class="row font-size-sm">
            <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-right">
                Template <i class="fa fa-heart text-danger"></i> by <a class="font-w600" >Kirikoo#2379</a>
            </div>
            <div class="col-sm-6 order-sm-1 text-center text-sm-left">
                <a class="font-w600" href="#"><?php echo $dm->name ; ?></a> &copy; <span data-toggle="year-copy">2019</span>
            </div>
        </div>
    </div>
</footer>
<!-- END Footer -->
