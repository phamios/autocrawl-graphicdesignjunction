<div class="slick_slider">
    <?php foreach($get_new_post_slide as $slide):?>
    <div class="single_iteam">
        <a href="<?php echo site_url(create_slug($slide->title));?>"> 
            <img src="<?php echo $slide->image_link;?>" alt="img">
        </a>
        <div class="slider_article">
            <h2><a class="slider_tittle" href="<?php echo site_url(create_slug($slide->title));?>">
                   <?php echo trim($slide->title);?></a>
            </h2>
            <p>
                <?php echo trim($slide->des);?>
            </p>
        </div>
    </div>
    <?php endforeach;?>
</div>