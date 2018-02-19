<div class="container">
	<?php if ($data['allowed']) { ?>
		<div class="text-center">
			<h1>User</h1>
		</div>
		<div class="container-fluid">
	      <div class="pull-right">
	      	<a href="<?php echo $data['back']; ?>" data-toggle="tooltip" title="Back" class="btn btn-danger">Back</a>
	      	<button type="submit" form="form-user" data-toggle="tooltip" title="Save User" class="btn btn-primary">Save User</button>
	      </div>
	      <h1>User Form</h1>
	    </div>
		<div class="panel-body">
			<form action="<?php echo $data['action']; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
				<div class="form-group required">
		            <label class="col-sm-2 control-label" for="input-username">Username</label>
		            <div class="col-sm-10">
		              <input type="text" name="username" value="<?php echo $data['username']; ?>" placeholder="Username" id="input-username" class="form-control" autocomplete="off" required/>
		              <?php if ($data['error_username']) { ?>
		              <div class="text-danger"><?php echo $data['error_username']; ?></div>
		              <?php  } ?>
		            </div>
		        </div>
		        <div class="form-group required">
		            <label class="col-sm-2 control-label" for="input-email">Email</label>
		            <div class="col-sm-10">
		              <input type="text" name="email" value="<?php echo $data['email']; ?>" placeholder="email" id="input-email" class="form-control" autocomplete="off" required/>
		              <?php if ($data['error_email']) { ?>
		              <div class="text-danger"><?php echo $data['error_email']; ?></div>
		              <?php  } ?>
		            </div>
		        </div>
		        <div class="form-group required">
		            <label class="col-sm-2 control-label" for="input-password">Password</label>
		            <div class="col-sm-10">
		              <input type="text" name="password" value="<?php echo $data['password']; ?>" placeholder="password" id="input-password" class="form-control" autocomplete="off" required/>
		              <?php if ($data['error_password']) { ?>
		              <div class="text-danger"><?php echo $data['error_password']; ?></div>
		              <?php  } ?>
		            </div>
		        </div>
		        <div class="form-group required">
		            <label class="col-sm-2 control-label" for="input-confirm">confirm</label>
		            <div class="col-sm-10">
		              <input type="password" name="confirm" value="<?php echo $data['confirm']; ?>" placeholder="confirm" id="input-confirm" class="form-control" autocomplete="off" required/>
		              <?php if ($data['error_confirm']) { ?>
		              <div class="text-danger"><?php echo $data['error_confirm']; ?></div>
		              <?php  } ?>
		            </div>
		        </div>
		        <div class="form-group">
		            <label class="col-sm-2 control-label" for="input-user-group">User Group</label>
		            <div class="col-sm-10">
		              <select name="user_group_id" id="input-user-group" class="form-control">
		                <?php foreach ($data['user_groups'] as $user_group) { ?>
		                <?php if ($user_group['user_group_id'] == $data['user_group_id']) { ?>
		                <option value="<?php echo $user_group['user_group_id']; ?>" selected="selected"><?php echo $user_group['name']; ?></option>
		                <?php } else { ?>
		                <option value="<?php echo $user_group['user_group_id']; ?>"><?php echo $user_group['name']; ?></option>
		                <?php } ?>
		                <?php } ?>
		              </select>
		            </div>
		        </div>
			</form>
		</div>
	<?php }else{ ?>
		<div class="text-danger">You Are Not Allowed To View This Page</div>
	<?php } ?>
</div>