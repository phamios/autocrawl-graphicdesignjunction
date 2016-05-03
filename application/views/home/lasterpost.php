<div class="col-lg-4 col-md-4 col-sm-4">
    <div class="latest_post">
        <h2><span>Latest post</span></h2>
        <div class="latest_post_container">
            <div id="prev-button"><i class="fa fa-chevron-up"></i></div>
            <ul class="latest_postnav">
               <?php foreach($lastest_post as $lastpost):?>
                <li>
                    <div class="media">
                        <a href="<?php echo site_url(trim(strtolower($lastpost->title)).'.html')?>" class="media-left">
                            <img alt="img" src="<?php echo $lastpost->image_thumb ?>" />
                        </a>
                        <div class="media-body">
                            <a href="<?php echo site_url(trim(strtolower($lastpost->title)).'.html')?>" class="catg_title">
                                <?php echo trim(strtolower($lastpost->title))?>
                            </a>                        
                        </div>
                    </div>
                </li>
                 <?php endforeach;?>
            </ul>
            <div id="next-button"><i class="fa  fa-chevron-down"></i></div>
        </div>
    </div>
</div>