<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo site_url('assets/dist/img/user2-160x160.jpg');?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p> 
          <?php echo AUTH_USER_NAME;?>
        </p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
            
    <!-- search form -->
    <?php require_once('search-form.php')?>
    
	<ul class="sidebar-menu">
		<li>
			<a href="<?php echo site_url();?>jobs">
				<i class="fa fa-book"></i> <span>Jobs</span>
			</a>
		</li>

		<li>
			<a href="<?php echo site_url();?>jobs/add">
				<i class="fa fa-book"></i> <span>Create New Job</span>
			</a>
		</li>
		
		<li>
			<a href="<?php echo site_url();?>jobs/all">
				<i class="fa fa-book"></i> <span>All Jobs</span>
			</a>
		</li>
		
		<li>
			<a href="<?php echo site_url();?>customers">
				<i class="fa fa-book"></i> <span>Customers</span>
			</a>
		</li>
		<li class="header">
			Other Modules
		</li>
		
		<li>
			<a href="<?php echo site_url();?>accounts">
				<i class="fa fa-book"></i> <span>Account</span>
			</a>
		</li>

		<li>
			<a href="<?php echo site_url();?>stock">
				<i class="fa fa-book"></i> <span>Manage Stock</span>
			</a>
		</li>


		<li>
			<a href="<?php echo site_url();?>report">
				<i class="fa fa-book"></i> <span>Stastics</span>
			</a>
		</li>
	</ul>
	</section>
</aside>
