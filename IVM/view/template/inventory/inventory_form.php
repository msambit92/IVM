<div class="container">
	<?php if ($data['allowed']) { ?>
		<div class="text-center">
			<h1>Inventory</h1>
		</div>
		<div class="container-fluid">
	      <div class="pull-right">
	      	<a href="<?php echo $data['back']; ?>" data-toggle="tooltip" title="Back" class="btn btn-danger">Back</a>
	      	<button data-toggle="tooltip" title="Save Inventory" class="btn btn-primary" onclick="save()">Save Inventory</button>
	      </div>
	      <h1>Inventory Form</h1>
	    </div>
		<div class="panel-body">
			<form class="form-horizontal">
				<div class="form-group">
		            <label class="col-sm-2 control-label" for="input-name">Product Name</label>
		            <div class="col-sm-10">
		              <input type="text" name="product_name" value="<?php echo $data['name']; ?>" placeholder="Product Name" id="input-name" class="form-control"/>
		            </div>
		        </div>
		        <div class="form-group">
		            <label class="col-sm-2 control-label" for="input-vendor">Vendor</label>
		            <div class="col-sm-10">
		              <input type="text" name="vendor" value="<?php echo $data['vendor']; ?>" placeholder="Vendor" id="input-vendor" class="form-control"/>
		            </div>
		        </div>
		        <div class="form-group">
		            <label class="col-sm-2 control-label" for="input-mrp">MRP</label>
		            <div class="col-sm-10">
		              <input type="text" name="mrp" value="<?php echo $data['mrp']; ?>" placeholder="MRP" id="input-mrp" class="form-control"/>
		            </div>
		        </div>
		        <div class="form-group">
		            <label class="col-sm-2 control-label" for="input-batch-no">Batch no</label>
		            <div class="col-sm-10">
		              <input type="text" name="batch_no" value="<?php echo $data['batch_no']; ?>" placeholder="Batch no" id="input-batch-no" class="form-control"/>
		            </div>
		        </div>
		        <div class="form-group">
		            <label class="col-sm-2 control-label" for="input-quantity">Quantity</label>
		            <div class="col-sm-10">
		              <input type="number" name="quantity" value="<?php echo $data['quantity']; ?>" placeholder="Quantity" id="input-quantity" class="form-control"/>
		            </div>
		        </div>
		        <div class="form-group">
		            <label class="col-sm-2 control-label" for="input-batch-date">Batch Date</label>
		            <div class="col-sm-10">
		              <div class="input-group date">
	                    <input type="text" name="batch_date" value="<?php echo $data['batch_date']; ?>" placeholder="Batch Date" data-date-format="YYYY-MM-DD" id="input-batch-date" class="form-control" />
	                    <span class="input-group-btn">
	                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
	                    </span></div>
		            </div>
		        </div>
		    </form>
		</div>
	<?php }else{ ?>
		<div class="text-danger">You Are Not Allowed To View This Page</div>
	<?php } ?>
</div>
<script>
	$('.date').datetimepicker({
		pickTime: false
	});

	function save() {
		$('.text-danger').remove();

		var error = false;

		if ($('input[name=product_name]').length == 0) {
			error = true;
			let html = '';
			html += '<div class="text-danger">Please enter Product name between 3 and 255 characters</div>';
			$('.panel-body').before(html);
		}

		if (!error) {
			let product_id = '<?php echo $data['product_id']; ?>';
			var action = '';
			if (product_id) {
				action = 'inventory_edit';
			}else{
				action = 'inventory_add';
			}
			$.ajax({
				url: 'index.php?route=inventory/inventory/save&token=<?php echo $data['token']; ?>',
				method : 'post',
				data: {name : $('input[name=product_name]').val(), vendor : $('input[name=vendor]').val(), mrp : $('input[name=mrp]').val(), batch_no : $('input[name=batch_no]').val(), batch_no : $('input[name=batch_no]').val(), batch_date : $('input[name=batch_date]').val(), quantity : $('input[name=quantity]').val(), action : action, product_id : product_id},
				dataType: 'json',
				success: function(json) {
					if (json['error']) {
						if (json['error']['product_name']) {
							let html = '';
							html += '<div class="text-danger">' + json['error']['product_name'] + '</div>';
							$('input[name=product_name]').after(html);
						}
					}

					if (json['success']) {
						window.location.href = "index.php?route=inventory/inventory&token=<?php echo $data['token']; ?>";
					}
				}
			});
		}
	}
</script>