<section id="contentSection">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="left_content">

                <?php if ($this->router->fetch_method() == 'index'): ?>
                    <?php $this->load->view('home/main'); ?>  
                <?php endif; ?> 

                <?php if ($this->router->fetch_method() == 'category'): ?>
                    <?php $this->load->view('home/category'); ?>  
                <?php endif; ?> 


            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <aside class="right_content">

                <!-- start tab section -->
                <?php $this->load->view('home/left_content_home'); ?>
                <!-- End tab section -->
                <!-- sponsor add -->
                <?php //$this->load->view('home/sponsor');?>
                <!-- End sponsor add -->
            </aside>
        </div>
    </div>  
</section>