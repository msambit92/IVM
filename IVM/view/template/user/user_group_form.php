<div class="container">
	<?php if ($data['allowed']) { ?>
		<div class="text-center">
			<h1>User Group</h1>
		</div>
		<div class="container-fluid">
	      <div class="pull-right">
	      	<a href="<?php echo $data['back']; ?>" data-toggle="tooltip" title="User Group" class="btn btn-danger">Back</a>
	      	<button type="submit" form="form-user-group" data-toggle="tooltip" title="Save User Group" class="btn btn-primary">Save User Group</button>
	      </div>
	      <h1>User Group Form</h1>
	    </div>
		<div class="panel-body">
			<form action="<?php echo $data['action']; ?>" method="post" enctype="multipart/form-data" id="form-user-group" class="form-horizontal">
				<div class="form-group required">
		            <label class="col-sm-2 control-label" for="input-name">User Group name</label>
		            <div class="col-sm-10">
		              <input type="text" name="name" value="<?php echo $data['name']; ?>" placeholder="User Group name" id="input-name" class="form-control" required/>
		              <?php if ($data['error_name']) { ?>
		              <div class="text-danger"><?php echo $data['error_name']; ?></div>
		              <?php  } ?>
		            </div>
		        </div>
		        <div class="form-group">
		            <label class="col-sm-2 control-label">Access Premission</label>
		            <div class="col-sm-10">
		              <div class="well well-sm" style="height: 150px; overflow: auto;">
		                <?php foreach ($data['permissions'] as $key => $permission) { ?>
		                <div class="checkbox">
		                  <label>
		                    <?php if (in_array($key, $data['access'])) { ?>
		                    <input type="checkbox" name="permission[]" value="<?php echo $key; ?>" checked="checked" />
		                    <?php echo $permission; ?>
		                    <?php } else { ?>
		                    <input type="checkbox" name="permission[]" value="<?php echo $key; ?>" />
		                    <?php echo $permission; ?>
		                    <?php } ?>
		                  </label>
		                </div>
		                <?php } ?>
		            </div>
		            <a onclick="$(this).parent().find(':checkbox').prop('checked', true);">Select All</a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);">Unselect All</a></div>
		        </div>
			</form>
		</div>
	<?php }else{ ?>
		<div class="text-danger">You Are Not Allowed To View This Page</div>
	<?php } ?>
</div>