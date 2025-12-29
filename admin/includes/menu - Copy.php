<ul class="sidebar-menu">
	<li class="treeview <?php if(in_array($this->getCurrentView(),array("home"))){ ?>active<?php } ?>"><a href="index.php?view=home"><i class="fa fa-home"></i><span>Home</span></a> </li>
	<li <?php if(in_array($this->getCurrentView(),array("booking_inquiry_list"))){ ?>class="active"<?php } ?>><a href="index.php?view=booking_inquiry_list"><i class="fa fa-info-circle"></i><span>Customer Inquiry</span> <span class="pull-right-container"><span class="label bg-green pull-right right-label" id="inquiry_count"></span></span></a></li>
	<li <?php if(in_array($this->getCurrentView(),array("booking_list"))){ ?>class="active"<?php } ?>><a href="index.php?view=booking_list"><i class="fa fa-calendar"></i><span>Customer Booking</span></a> </li>
	<li <?php if(in_array($this->getCurrentView(),array("sp_ride_master_list","sp_ride_master_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=sp_ride_master_list"><i class="fa fa-car"></i><span>One Way Car List</span></a> </li>
	<li <?php if(in_array($this->getCurrentView(),array("ride_request_list"))){ ?>class="active"<?php } ?>><a href="index.php?view=ride_request_list"><i class="fa fa-sign-in"></i><span>Customer Request</span> <span class="pull-right-container"><span class="label label-primary pull-right right-label" id="request_count"></span></a> </li>

	<!-- <li <?php if(in_array($this->getCurrentView(),array("role_request_list"))){ ?>class="active"<?php } ?>><a href="index.php?view=role_request_list"><i class="fa fa-handshake-o"></i><span> Pending Role Request</span></a> </li> -->
	<li <?php if(in_array($this->getCurrentView(),array("users_list","users_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=users_list"><i class="fa fa-user-plus"></i><span>Users List</span></a> </li>
	<li class="treeview <?php if(in_array($this->getCurrentView(),array("service_provider_list","service_provider_addedit","service_provider_vehicle","sp_driver_list","sp_driver_addedit")) && $this->getGetVar("id")!=='6'){ ?>active<?php } ?>"><a href="#"><i class="fa fa-user-o"></i><span>Service Provider</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
		<ul class="treeview-menu">
			<li <?php if(in_array($this->getCurrentView(),array("service_provider_list","service_provider_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=service_provider_list">SP List</a> </li>
			<li <?php if(in_array($this->getCurrentView(),array("service_provider_vehicle")) && $this->getGetVar("id")!=='6'){ ?>class="active"<?php } ?>><a href="index.php?view=service_provider_vehicle&destroy=1">SP Vehicles List [F9]</a></li>			
			<li <?php if(in_array($this->getCurrentView(),array("sp_driver_list","sp_driver_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=sp_driver_list">SP Drivers List</a> </li>
		</ul>
	</li>
	
	<li class="treeview <?php if(in_array($this->getCurrentView(),array("account_list","account_addedit","account_group_list","account_group_addedit","account_group_ledger","transaction_list","transaction_addedit","account_ledger","account_balance_report"))){ ?>active<?php } ?>"><a href="#"><i class="fa fa-money"></i><span>Accounting</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
		<ul class="treeview-menu">
			<?php if($_SESSION['admin_user_group_id']!='1'){ ?>
				<li <?php if(in_array($this->getCurrentView(),array("transaction_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=transaction_addedit"><span>Add Transaction [F1]</span></a></li>
			<?php }?>
			<li <?php if(in_array($this->getCurrentView(),array("account_ledger"))){ ?>class="active"<?php } ?>><a href="index.php?view=account_ledger"><span>Account Ledger [F2]</span></a></li>
			<li <?php if(in_array($this->getCurrentView(),array("account_balance_report"))){ ?>class="active"<?php } ?>><a href="index.php?view=account_balance_report"><span>Account Balance [F4]</span></a></li>
			<li <?php if(in_array($this->getCurrentView(),array("account_list","account_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=account_list">Account List</a> </li>		
			<li <?php if(in_array($this->getCurrentView(),array("account_group_list","account_group_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=account_group_list">Account Group</a> </li>
			<li <?php if(in_array($this->getCurrentView(),array("transaction_list"))){ ?>class="active"<?php } ?>><a href="index.php?view=transaction_list">Transaction List</a> </li>
		</ul>
	</li>
	<?php if($_SESSION['admin_user_group_id']=='1'){ ?>
		<li class="treeview <?php if((in_array($this->getCurrentView(),array("service_provider_addedit","service_provider_vehicle")) && $this->getGetVar("id")=='6') || (in_array($this->getCurrentView(),array("sp_bike_list","sp_auto_list","sp_bus_list")) && $this->getGetVar("sp_id")=='6') || in_array($this->getCurrentView(),array('service_provider_calendar'))){ ?>active<?php } ?>"><a href="#"><i class="fa fa-header"></i><span>Own [Hariom]</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
			<ul class="treeview-menu">
				<li <?php if(in_array($this->getCurrentView(),array("service_provider_addedit")) && $this->getGetVar("id")=='6' && $this->getGetVar("update")=='profile'){ ?>class="active"<?php } ?>><a href="index.php?view=service_provider_addedit&id=6&update=profile">My Profile</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("service_provider_vehicle","service_provider_addedit")) && $this->getGetVar("id")=='6' && $this->getGetVar("update")!=='profile'){ ?>class="active"<?php } ?>><a href="index.php?view=service_provider_vehicle&id=6">My Vehicles</a></li>
				<li <?php if(in_array($this->getCurrentView(),array("sp_bike_list")) && $this->getGetVar("sp_id")=='6'){ ?>class="active"<?php } ?>><a href="index.php?view=sp_bike_list&sp_id=6">My Bikes</a></li>
				<li <?php if(in_array($this->getCurrentView(),array("sp_bus_list")) && $this->getGetVar("sp_id")=='6'){ ?>class="active"<?php } ?>><a href="index.php?view=sp_bus_list&sp_id=6">My Bus</a></li>
				<li <?php if(in_array($this->getCurrentView(),array("sp_auto_list")) && $this->getGetVar("sp_id")=='6'){ ?>class="active"<?php } ?>><a href="index.php?view=sp_auto_list&sp_id=6">My Auto Rikshaw</a></li>
				<li <?php if(in_array($this->getCurrentView(),array("service_provider_calendar"))){ ?>class="active"<?php } ?>><a href="index.php?view=service_provider_calendar">My Calendar</a></li>
			</ul>
		</li>
		<!--<li class="treeview <?php if(in_array($this->getCurrentView(),array("booking_list","booking_addedit"))){ ?>active<?php } ?>"><a href="index.php?view=booking_list"><i class="fa fa-car"></i><span>Booking</span></a> </li>-->
		<li class="treeview <?php if(in_array($this->getCurrentView(),array("region_list","region_addedit","group_master_list","group_master_addedit","city_list","city_addedit","rental_package_list","rental_package_addedit","sp_location_list","vehicle_category_list","vehicle_category_addedit","vehicle_company_list","vehicle_company_addedit","vehicle_color_list","vehicle_color_addedit","bike_brand_list","bike_brand_addedit","bike_type_list","bike_type_addedit","bus_manufacture_addedit","bus_manufacture_list"))){ ?>active<?php } ?>"><a href="#"><i class="fa fa-folder-open"></i><span>Masters</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
			<ul class="treeview-menu">
				<li <?php if(in_array($this->getCurrentView(),array("sp_location_list"))){ ?>class="active"<?php } ?>><a href="index.php?view=sp_location_list">Service Provider Location</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("city_list","city_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=city_list">City Master</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("region_list","region_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=region_list">Area Master</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("group_master_list","group_master_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=group_master_list">Group Master</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("rental_package_list","rental_package_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=rental_package_list">Rental Package</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("vehicle_category_list","vehicle_category_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=vehicle_category_list">Car Category</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("vehicle_company_list","vehicle_company_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=vehicle_company_list">Car Company</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("bus_manufacture_addedit","bus_manufacture_list"))){ ?>class="active"<?php } ?>><a href="index.php?view=bus_manufacture_list">Bus Manufacture</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("bike_brand_list","bike_brand_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=bike_brand_list">Bike Brand</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("bike_type_list","bike_type_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=bike_type_list">Bike Type</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("vehicle_color_list","vehicle_color_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=vehicle_color_list">Vehicle Color</a> </li>
			</ul>
		</li>
	<?php } ?>
	<?php if($_SESSION['admin_user_group_id']=='1' || $_SESSION['admin_user_group_id']=='2'){ ?>
		<li class="treeview <?php if(in_array($this->getCurrentView(),array("car_rate_list","car_rate_addedit","terms_policy_list","bike_rate_list","bike_rate_addedit","service_provider_car_rate","service_provider_bike_rate","service_provider_bus_rate","ride_type_addedit","setting_list","setting_addedit","pickup_drop_rate_setting","bus_rate_list","bus_rate_addedit","agent_commission_list"))){ ?>active<?php } ?>"><a href="#"><i class="fa fa-transgender"></i><span>Settings</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
			<ul class="treeview-menu">
				<li <?php if(in_array($this->getCurrentView(),array("car_rate_list","car_rate_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=car_rate_list">Car Master [Sales Rate]</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("bus_rate_list","bus_rate_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=bus_rate_list">Bus Master [Sales Rate]</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("bike_rate_list","bike_rate_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=bike_rate_list">Bike Master [Sales Rate]</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("terms_policy_list"))){ ?>class="active"<?php } ?>><a href="index.php?view=terms_policy_list">Terms-Cond./Can. Policy</a> </li>
				<li <?php if(in_array($this->getCurrentView(),array("service_provider_car_rate"))){ ?>class="active"<?php } ?>><a href="index.php?view=service_provider_car_rate">SP Car Rate</a></li>
				<li <?php if(in_array($this->getCurrentView(),array("service_provider_bike_rate"))){ ?>class="active"<?php } ?>><a href="index.php?view=service_provider_bike_rate">SP Bike Rate</a></li>
				<li <?php if(in_array($this->getCurrentView(),array("service_provider_bus_rate"))){ ?>class="active"<?php } ?>><a href="index.php?view=service_provider_bus_rate">SP Bus Rate</a></li>
				<?php if($_SESSION['admin_user_group_id']=='1'){ ?>
					<li <?php if(in_array($this->getCurrentView(),array("agent_commission_list"))){ ?>class="active"<?php } ?>><a href="index.php?view=agent_commission_list">Agent Commission</a></li>
					<?php foreach ($this->ride_type_setting as $ride_type_setting) { ?>
						<li <?php if(in_array($this->getCurrentView(),array("ride_type_addedit")) && $this->getGetVar("id")==$ride_type_setting['id']){ ?>class="active"<?php } ?>><a href="index.php?view=ride_type_addedit&id=<?php echo $ride_type_setting['id']; ?>"><?php echo $ride_type_setting['name']; ?> Setting </a></li>
					<?php }
					} ?>
					<li <?php if(in_array($this->getCurrentView(),array("pickup_drop_rate_setting"))){ ?>class="active"<?php } ?>><a href="index.php?view=pickup_drop_rate_setting">Pickup-Drop Rate</a></li>
					<?php if($_SESSION['admin_user_group_id']=='1'){ ?>
					<li <?php if(in_array($this->getCurrentView(),array("setting_list","setting_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=setting_list">Other Setting </a></li>
					<?php } ?>
				</ul>
			</li>	
			<li class="treeview <?php if(in_array($this->getCurrentView(),array("admin_user_group_list","admin_user_group_addedit","admin_user_list","admin_user_addedit","access_control_addedit","user_logs_list","backup_restore_list")) && !$this->getGetVar("type")=='application_user'){ ?>active<?php } ?>"> <a href="#"><i class="fa fa-users"></i><span>Administrator</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
				<ul class="treeview-menu">
					<?php if($_SESSION['admin_user_group_id']=='1'){ ?>
						<li <?php if(in_array($this->getCurrentView(),array("admin_user_group_list","admin_user_group_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=admin_user_group_list">User Group [List]</a></li>
						<li <?php if(in_array($this->getCurrentView(),array("access_control_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=access_control_addedit">User Group Access</a></li>			
					<?php } ?>
					<li <?php if(in_array($this->getCurrentView(),array("admin_user_list","admin_user_addedit")) && !$this->getGetVar("type")=='application_user'){ ?>class="active"<?php } ?>><a href="index.php?view=admin_user_list">Admin Panel User [List]</a></li>				
					<li <?php if(in_array($this->getCurrentView(),array("user_logs_list"))){ ?>class="active"<?php } ?>><a href="index.php?view=user_logs_list">Activity Logs</a> </li>
				</ul>
			</li>		
		<?php } ?>
		<li class="treeview <?php if(in_array($this->getCurrentView(),array("sms_addedit","sms_template_list","sms_template_addedit","message_log_list"))){ ?>active<?php } ?>"><a href="#"><i class="fa fa-mobile"></i><span>SMS</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
			<ul class="treeview-menu">
				<li <?php if(in_array($this->getCurrentView(),array("sms_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=sms_addedit">Send SMS</a> </li>
				<?php if($_SESSION['admin_user_group_id']=='1'){ ?>
					<li <?php if(in_array($this->getCurrentView(),array("sms_template_list","sms_template_addedit"))){ ?>class="active"<?php } ?>><a href="index.php?view=sms_template_list">SMS Template</a> </li>
				<?php } ?>
				<li <?php if(in_array($this->getCurrentView(),array("message_log_list"))){ ?>class="active"<?php } ?>><a href="index.php?view=message_log_list">SMS History</a> </li>
			</ul>
		</li>
		<!--<li <?php if(in_array($this->getCurrentView(),array("help"))){ ?>class="active"<?php } ?>><a href="index.php?view=help"><i class="fa fa-server"></i><span>Documentation</span></a> </li>-->		
	</ul>

