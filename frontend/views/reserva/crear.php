<div class="container mt-3">
	<div class="row justify-content-md-center">
		<div class=" col col-lg-8">
			<h1 class="text-center display-2">Hola <?= $model->name ?></h3>
				<form class="row g-2 mt-2 needs-validation" method="post" novalidate>
					<div class="col-md-12 mb-2 ms-4 form-switch ">
						<input type="hidden" name="confirmation_hidden" id="confirmation_hidden" value="1" >
						<input class="form-check-input " type="checkbox" id="confirmation" name="confirmation" checked onchange="click_asistire()" value="">
						<label class="form-check-label" for="confirmation">Asistire al evento</label>
					</div>

					<div class="row" id="invitados_div">
						<?php if ($Invitados) :
							$AIds = [];
						?>
							<?php foreach ($Invitados as $Invitado) :
								$Id = $Invitado->id;
								$AIds[] = $Id;
								$TypeMenu = $Invitado->type_menu;
								$Adulto = $TypeMenu == 'adulto' ? 'selected' : '';
								$Niño = $TypeMenu == 'niño' ? 'selected' : '';
							?>
								<hr>
								<div class="row">
									<div class="col-md-2 d-flex align-items-center">
										<b class="me-3 h3 col-md-2"><?= $Invitado->name ?></b>
									</div>
									<div class="col-md-2 d-flex align-items-center">
										<input class=" form-check-input" type="checkbox" id="confirmation_<?= $Id ?>" name="confirmation_<?= $Id ?>" checked onchange="check_asistencia_invitado('<?= $Id ?>')">
										<label class="form-check-label" for="confirmation_<?= $Id ?>">&nbsp; Asistire</label>
									</div>
									<div id="eleccion_<?= $Id ?>" class="col-md-8 row">
										<div class="col-md-4 form-floating">
											<select id="type_menu_<?= $Id ?>" name="type_menu_<?= $Id ?>" class="form-select" aria-label="Menu" onchange="click_menu(this.value,'div_fish_or_meat_<?= $Id ?>')" data-onload="click_menu('<?=$TypeMenu?>','div_fish_or_meat_<?= $Id ?>')" required>
												<option <?= $Adulto ?> value="adulto">Adulto</option>
												<option <?= $Niño ?> value="niño">Niño</option>
											</select>
											<label for="type_menu_<?= $Id ?>">&nbsp;Tipo de menu</label>
										</div>
										<div class="col-md-4 form-floating" id="div_fish_or_meat_<?= $Id ?>">
											<select class="form-select" id="fish_or_meat_<?= $Id ?>" name="fish_or_meat_<?= $Id ?>" aria-label="Carne o pescado" required>
												<option selected>Elige</option>
												<option value="carne">Carne</option>
												<option value="pescado">Pescado</option>
											</select>
											<label for="fish_or_meat_<?= $Id ?>">&nbsp;Carne o pescado</label>
										</div>
										<div class=" col-md-2  d-flex align-items-center">
											<input class="form-check-input" type="checkbox" value="" id="allergens_<?= $Id ?>" name="allergens_<?= $Id ?>">
											<label class="form-check-label" for="allergens_<?= $Id ?>">&nbsp;Alérgico</label>
										</div>
										<div class=" col-md-2  d-flex align-items-center">
											<input class="form-check-input" type="checkbox" value="" id="bus_<?= $Id ?>" name="bus_<?= $Id ?>">
											<label class="form-check-label" for="bus_<?= $Id ?>">&nbsp;Bus</label>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<hr>
					<div class="form-floating mt-2">
						<textarea rows="2" style="height:100%;" class="form-control" placeholder="Escribe aqui si tienes algo que informarnos" id="floatingTextarea" name="description"></textarea>
						<label for="floatingTextarea">&nbsp;Observaciones</label>
					</div>

					<div class="col-12 mt-3">
						<button class="btn btn-primary" type="button" onclick=submit_form()>Enviar reserva</button>
					</div>
				</form>
		</div>
	</div>
</div>
<script>
	function click_menu(value, id) {
		if (value == 'niño') {
			$('#' + id).hide();
		} else {
			$('#' + id).show();
		}
	}

	function check_asistencia_invitado(id) {
		if (!$('#confirmation_' + id).is(':checked')) {
			$('#eleccion_' + id).hide();
		} else {
			$('#eleccion_' + id).show();
		}
	}

	function click_asistire() {
		if (!$('#confirmation').is(':checked')) {
			$('#invitados_div').hide();
			$('#confirmation_hidden').val('0');
		} else {
			$('#confirmation_hidden').val('1');
			$('#invitados_div').show();
		}
	}

		function submit_form()
		{
			var error=false;
			var AIds = <?= json_encode($AIds); ?>;
			var arrayLength = AIds.length;
			
		if ($('#confirmation').is(':checked')) {
			for (var i = 0; i < arrayLength; i++) {
				var id = AIds[i];
				
				if ($('#confirmation_' + id).is(':checked')) {
					var value=$('#fish_or_meat_' + id).val();
					var menu=$('#type_menu_' + id).val();
					if(value=='Elige' && menu=='adulto')
					{						
						$('#fish_or_meat_' + id).addClass('is-invalid');
						error=true;
					}
				}
			}
		}
			if(error===false)
			{
				$( "form" ).submit();
			}
		}
		$('[data-onload]').each(function(){
    eval($(this).data('onload'));
});
	
</script>