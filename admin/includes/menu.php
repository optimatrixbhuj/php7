<?php $menu = $this->menu;
/*echo "<pre>";
print_r($menu);
print_r($this->active_menu);exit;*/ ?>
<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
 <?php for($i=0;$i<count($menu);$i++){ 
  if(count($menu[$i]['menu_detail']) == 0){ ?>
    <!-- only 1 menu -->
    <li class="nav-item"><a class="nav-link <?php if($this->active_menu['main_menu'] == $menu[$i]['id']){ ?>active<?php } ?>" href="index.php?view=<?php echo $menu[$i]['file_name']; ?>"><?php if($menu[$i]['icon_class']!=''){ ?><i class="nav-icon <?php echo $menu[$i]['icon_class'];?>"></i><?php } ?><p><?php echo $menu[$i]['label']; ?>
		<?php if($menu[$i]['file_name']=='booking_inquiry_list'){ ?>
			<i class="right badge badge-success" id="inquiry_count"></i>
		<?php }else if($menu[$i]['file_name']=='ride_request_list'){ ?>
           <i class="right badge badge-info" id="request_count"></i>
		<?php } ?>
	  </p>
    </a> </li>
  <?php }else{ ?>
    <!-- sub menu avalable  -->
    <li class="nav-item <?php if($this->active_menu['main_menu'] == $menu[$i]['id']){ ?>menu-open<?php } ?>"><!-- . menu-open-->
      <a class="nav-link <?php if($this->active_menu['main_menu'] == $menu[$i]['id']){ ?>active<?php } ?>" href="#">
		<?php if($menu[$i]['icon_class']!=''){ ?><i class="nav-icon <?php echo $menu[$i]['icon_class'];?>"></i><?php } ?><p><?php echo $menu[$i]['label']; ?>
	  
	        <i class="right fas fa-angle-left"></i>
 </p> </a>
      <ul class="nav nav-treeview">
        <?php for($j=0;$j<count($menu[$i]['menu_detail']);$j++){ ?>
          <li class="nav-item">
		  <a class="nav-link <?php if($this->active_menu['sub_menu'] == $menu[$i]['menu_detail'][$j]['id']){ ?>active<?php } ?>" href="index.php?view=<?php echo $menu[$i]['menu_detail'][$j]['menu_file_label_file_name']; ?><?php if($menu[$i]['menu_detail'][$j]['menu_file_label_parameters'] != ''){ echo "&".$menu[$i]['menu_detail'][$j]['menu_file_label_parameters']; } ?>" ><i class="far fa-circle nav-icon"></i><p><?php echo $menu[$i]['menu_detail'][$j]['menu_file_label_file_label']; ?></p></a> </li>
        <?php } ?>
      </ul>
    </li>
  <?php } ?>
<?php } ?>
</ul>
</nav>