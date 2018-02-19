<div class="container">
	<?php if ($data['allowed']) { ?>
		<div class="text-center">
			<h1>Inventory</h1>
		</div>
		<div class="container-fluid">
	      <div class="pull-right">
	      	<?php if (in_array('inventory_delete', $data['user_role'])) { ?>
	      		<a data-toggle="tooltip" title="Delete" class="btn btn-danger" onclick="confirm('Are you confirm to delete') ? deleteInventory() : false;">Delete</a>
	      	<?php } ?>
	      	<?php if (in_array('inventory_add', $data['user_role'])) { ?>
	      		<a href="<?php echo $data['add']; ?>" data-toggle="tooltip" title="Add Inventory" class="btn btn-primary">Add Inventory</a>
	      	<?php } ?>
	      </div>
	      <h1>Inventory List</h1>
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
	                  <td class="text-left">Product Id</td>
	                  <td class="text-left">Product Name</td>
	                  <td class="text-left">Vendor</td>
	                  <td class="text-left">MRP</td>
	                  <td class="text-left">Batch No</td>
	                  <td class="text-left">Batch Date</td>
	                  <td class="text-right">Quantity</td>
	                  <td class="text-left">status</td>
	                    <?php if (in_array('inventory_edit', $data['user_role']) || in_array('inventory_approve', $data['user_role'])) { ?>
				      		<td class="text-right">Action</td>
				      	<?php } ?>
	                </tr>
	              </thead>
	              <tbody>
	                <?php if ($data['items']) { ?>
	                <?php foreach ($data['items'] as $item) { ?>
	                <tr>
	                  <td class="text-center"><input type="checkbox" name="selected" value="<?php echo $item['product_id']; ?>" /></td>
	                  <td class="text-left"><?php echo $item['product_id']; ?></td>
	                  <td class="text-left"><?php echo $item['name']; ?></td>
	                  <td class="text-left"><?php echo $item['vendor']; ?></td>
	                  <td class="text-left"><?php echo $item['mrp']; ?></td>
	                  <td class="text-left"><?php echo $item['batch_no']; ?></td>
	                  <td class="text-left"><?php echo $item['batch_date']; ?></td>
	                  <td class="text-right"><?php echo $item['quantity']; ?></td>
	                  <td class="text-left"><?php echo $item['status']; ?></td>
	                  <?php if (in_array('inventory_edit', $data['user_role']) || in_array('inventory_approve', $data['user_role'])) { ?>
	                  <td class="text-right">
	                  	<?php if (in_array('inventory_approve', $data['user_role'])) { ?>
	                  		<?php if ($item['status_id']) { ?>
	                  			<a data-toggle="tooltip" title="Disapprove Inventory" class="btn btn-warning" data-status="0" onclick="approve($(this), <?php echo $item['product_id']; ?>);">Disapprove</a>
	                  		<?php }else{ ?>
				      			<a data-toggle="tooltip" title="Approve Inventory" class="btn btn-success" data-status="1" onclick="approve($(this), <?php echo $item['product_id']; ?>);">Approve</a>
				      		<?php } ?>	
				      	<?php } ?>
	                  	<?php if (in_array('inventory_edit', $data['user_role'])) { ?>
				      		<a href="<?php echo $item['edit']; ?>" data-toggle="tooltip" title="Edit Inventory" class="btn btn-primary">Edit</a>
				      	<?php } ?>
	                  </td>
	                  <?php } ?>
	                </tr>
	                <?php } ?>
	                <?php } else { ?>
	                <tr>
                		<?php if (in_array('inventory_edit', $data['user_role']) || in_array('inventory_approve', $data['user_role'])) { ?>
                			<td class="text-center" colspan="10">No Results</td>
                		<?php }else{ ?>
                			<td class="text-center" colspan="9">No Results</td>
                		<?php } ?>	
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
<script>
	function approve(node, product_id) {
		$(".text-danger").remove();
		$.ajax({
			url: 'index.php?route=inventory/inventory/approve&token=<?php echo $data['token'] ?>',
			method : 'post',
			data: {product_id : product_id, approve : $(node).data('status')},
			dataType: 'json',
			success: function(json) {
				if (json['error']) {
					let html = '';
					html += '<div class="text-danger">' + json['error'] + '</div>';
					$('.panel-body').before(html);
				}

				if (json['success']) {
					if ($(node).data('status') == 1) {
						$(node).text('Disapprove').removeClass('btn-success').addClass('btn-warning').data('status', 0).parent().prev().text('Approved');
					}else{
						$(node).text('Approve').removeClass('btn-warning').addClass('btn-success').data('status', 1).parent().prev().text('Pending');
					}
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				let html = '';
				html += '<div class="text-danger">There are some issue. Please try again</div>';
				$('.panel-body').before(html);
			}
		});
	}

	function deleteInventory() {
		$(".text-danger").remove();
		if ($("input[name=selected]:checked").length > 0) {
			$.each($("input[name=selected]:checked"), function (index, value) {
				$(".text-danger").remove();
				$.ajax({
					url: 'index.php?route=inventory/inventory/delete&token=<?php echo $data['token'] ?>',
					method : 'post',
					data: {product_id : $(value).val()},
					dataType: 'json',
					success: function(json) {
						if (json['error']) {
							let html = '';
							html += '<div class="text-danger">' + json['error'] + '</div>';
							$('.panel-body').before(html);
						}

						if (json['success']) {
							let html = '';
							html += '<div class="text-success">' + json['success'] + '</div>';
							$('.panel-body').before(html);
							$(value).parent().parent().remove();

						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						let html = '';
						html += '<div class="text-danger">There are some issue. Please try again</div>';
						$('.panel-body').before(html);
					}
				});
			});
		}else{
			let html = '';
			html += '<div class="text-danger">Please select atleast one product!</div>';
			$('.panel-body').before(html);
		}
	}
</script>