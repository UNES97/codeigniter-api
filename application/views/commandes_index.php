<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/toastr/toastr.min.css">
    <script src="<?php echo base_url();?>assets/jquery.min.js"></script>
	<script src="<?php echo base_url();?>assets/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/datatables/jquery.dataTables.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/datatables/dataTables.bootstrap4.min.css">
	<script src="<?php echo base_url();?>assets/datatables/jquery.validate.js"></script>
	<script src="<?php echo base_url();?>assets/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url();?>assets/datatables/dataTables.bootstrap4.min.js"></script>
</head>
<body>
<div class="container">
    <h1 class="display-4">Commandes</h1>
    <button id="add_cmd" type="button" class="btn btn-primary btn-sm">Ajouter Une Commande</button><br><br>
    <form method="" action="" style="display: none" id="form1">
		<div class="form-row">
            <div class="form-group col-md-6">
                <label >Client :</label>
                <input type="text" class="form-control" id="client" name="client">
            </div>
            <div class="form-group col-md-6">
                <label>Produit :</label>
                <select class="form-control" name="product_id" id="product_id">
                    <option selected disabled hidden value="">Choisir Un Produit</option>
                    <?php foreach ($products as $p) { ?> 
                        <option value="<?php echo $p->id; ?>"><?php echo $p->libelle; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label >Qte :</label>
                <input type="text" class="form-control" id="qte" name="qte">
            </div>
		</div>
		<button type="submit" class="btn btn-primary insertcmd">Ajouter</button>
    </form>
    <hr>
    
	<table id="cmd_list" class="table table-bordered ">
		<thead class="table-dark">
			<tr>
				<th>ID</th>
				<th>Client</th>
				<th>Produit</th>
                <th>Prix</th>
                <th>Qte</th>
                <th>Total</th>
                <th>Action</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Modifier la Commande</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div class="form-row">
				<div class="form-group col-md-6">
				 <label for="id">ID : </label>
                <input disabled type="text" name='id' class="form-control" >
				</div>
            </div>
			<div class="form-group">
				 <label for="">Client : </label>
                <input type="text" name='client' class="form-control" >
            </div>
			<div class="form-row">
				<div class="form-group col-md-6">
				  <label >Qte :</label>
				  <input type="text" class="form-control" name="qte">
				</div>
			</div>	
			<div class="form-row">
				<div class="form-group col-md-6">
				    <label >Produit :</label>
				    <select class="form-control" name="product_id" id="product_id">
                        <option selected disabled hidden value="">Choisir Un Produit</option>
                        <?php foreach ($products as $p) { ?> 
                            <option value="<?php echo $p->id; ?>"><?php echo $p->libelle; ?></option>
                        <?php } ?>
                    </select>
				</div>
			</div>	
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
		<button type="button"  class="btn btn-primary updatecmd">Sauvgarder</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        
        var table = $('#cmd_list').DataTable({
            "ajax": {
                url : "<?=site_url("Commandes/get_items")?>",
                type : 'GET'
            },
        });

        $( "#add_cmd" ).click( function() {
            $( "#form1" ).toggle( 'slow' );
        });

        $('body').on('click', '.insertcmd', function () {
			var client = $('#client').val();
			var product_id = $('#product_id').val();
			var qte = $('#qte').val();
			$.ajax({
				type: "POST",
				url: "<?=site_url("Commandes/insert_to_api")?>",
				data: {product_id:product_id , client:client , qte:qte } ,
			}).done(function() {
                table.ajax.reload();
                toastr.success('Sauvgardé avec Succés')
			});
		});

        $('body').on('click', '.edit_cmd', function () {
            var id = $(this).data('id');
            $.ajax({
                url:"<?=site_url("Commandes/fetch_commande_api")?>",
                method:"POST",
                data:{id:id},
                dataType:"json",
                success:function(data)
                {
                    $('#updateModal').modal('show');
                    $('#updateModal input[name="client"]').val(data.client);
                    $('#updateModal input[name="qte"]').val(data.qte);
                    $('#updateModal select[name="product_id"]').val(data.product_id);
                    $('#updateModal input[name="id"]').val(id);
                }
            })
        });

        $('body').on('click', '.updatecmd', function () {
			var id = $('#updateModal input[name="id"]').val();
			var client = $('#updateModal input[name="client"]').val();
			var qte = $('#updateModal input[name="qte"]').val();
			var product_id = $('#updateModal select[name="product_id"]').val();
			$.ajax({
				type: "POST",
				url: "<?=site_url("Commandes/update_to_api")?>",
				data:  {id:id , product_id:product_id , client:client , qte:qte }  ,
			}).done(function() {

                table.ajax.reload();
				$('#updateModal').modal('hide');
                toastr.success('Sauvgardé avec Succés')
				
			});
		});

        $('body').on('click', '.delete_cmd', function () {
            var id = $(this).data("id");
            var result = confirm("Are You sure want to delete !");
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "<?=site_url("Commandes/delete_to_api")?>",
                    data: {id:id} ,
                    success: function (data) {
                        table.ajax.reload();
                        toastr.success('Supprimé avec Succés')
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
		});



    });
</script>
<script src="<?php echo base_url();?>assets/toastr/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>