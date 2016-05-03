<div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav main_nav">
        <li class="active">
            <a href="<?php echo site_url();?>"><span class="fa fa-home desktop-home"></span><span class="mobile-show">Home</span></a>
        </li>
        <?php foreach($list_categories as $cate):?>
            <li>
                <a href="<?php echo site_url(trim(strtolower($cate->catename)).'/'.$cate->id);?>">
                        <?php echo $cate->catename; ?>
                </a>
            </li>   
        <?php endforeach?>
            
<!--        <li><a href="#">Technology</a></li>            
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Mobile</a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#">Android</a></li>
                <li><a href="#">Samsung</a></li>
                <li><a href="#">Nokia</a></li>
                <li><a href="#">Walton Mobile</a></li>
                <li><a href="#">Sympony</a></li>               
            </ul>
        </li>
        <li><a href="#">Laptops</a></li> 
        <li><a href="#">Tablets</a></li> 
        <li><a href="contact.html">Contact Us</a></li>
        <li><a href="404.html">404 Page</a></li>-->
    </ul>           
</div>