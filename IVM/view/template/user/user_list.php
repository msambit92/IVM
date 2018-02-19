<div class="container">
	<?php if ($data['allowed']) { ?>
		<div class="text-center">
			<h1>User</h1>
		</div>
		<div class="container-fluid">
	      <div class="pull-right">
	      	<a href="<?php echo $data['user_group']; ?>" data-toggle="tooltip" title="User Group" class="btn btn-primary">User Group</a>
	      	<a href="<?php echo $data['add']; ?>" data-toggle="tooltip" title="Add User" class="btn btn-primary">Add User</a>
	      </div>
	      <h1>User List</h1>
	    </div>
	    <?php if ($data['success']) { ?>
	    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $data['success']; ?>
	      <button type="button" class="close" data-dismiss="alert">&times;</button>
	    </div>
	    <?php } ?>
		<div class="panel-body">
			<div class="table-responsive">
	            <table class="table table-bordered table-hover">
	              <thead>
	                <tr>
	                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
	                  <td class="text-left">Username</td>
	                  <td class="text-left">Email</td>
	                  <td class="text-right">Action</td>
	                </tr>
	              </thead>
	              <tbody>
	                <?php if ($data['users']) { ?>
	                <?php foreach ($data['users'] as $user) { ?>
	                <tr>
	                  <td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $user['user_id']; ?>" /></td>
	                  <td class="text-left"><?php echo $user['username']; ?></td>
	                  <td class="text-left"><?php echo $user['email']; ?></td>
	                  <td class="text-right"><a href="<?php echo $user['edit']; ?>" data-toggle="tooltip" title="Edit User" class="btn btn-primary">Edit</a></td>
	                </tr>
	                <?php } ?>
	                <?php } else { ?>
	                <tr>
	                  <td class="text-center" colspan="4">No Results</td>
	                </tr>
	                <?php } ?>
	              </tbody>
	            </table>
	        </div>
		</div>
	<?php }else{ ?>
		<div class="text-danger">You Are Not Allowed To View This Page</div>
	<?php } ?>
</div>