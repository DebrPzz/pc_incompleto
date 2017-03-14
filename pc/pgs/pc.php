<?php 
	$msg='';
	$id = (!empty($_REQUEST['id'])) ? intval($_REQUEST['id']) : false;
	$dispositivo=(empty($_REQUEST['id'])) ?  R::dispense('marche') : R::load('marche', intval($_REQUEST['id']));
	if (!empty($_REQUEST['hostname'])) : 
		$dispositivo->hostname=$_POST['hostname'];
		$dispositivo->marche_id=$_POST['marche_id'];
		$dispositivo->modello=$_POST['modello'];
		$dispositivo->sn=$_POST['ore'];
	
		try {
			R::store($dispositivo);
			$msg='Dati salvati correttamente ('.json_encode($dispositivo).') ';
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;	
	
	if (!empty($_REQUEST['del'])) : 
		$dispositivo=R::load('pc', intval($_REQUEST['del']));
		try{
			R::trash($dispositivo);
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;
	
	$dispositivo=R::findAll('pc', 'ORDER by id ASC LIMIT 999');
	$marche=R::findAll('marche');
	$new=!empty($_REQUEST['create']);
	
	
	
    if (!empty($_REQUEST['tabint_id'])) : 
	    $sql = 'select * from listainterventi where pc_id = 9';
		$tabint=R::getAll($sql);
	endif;
?>



<h1>
	<a href="index.php">
		<?=($id) ? ($new) ? 'Nuovo Dispositivo' : 'Dispositivo n. '.$id : 'Dispositivo';?>
	</a>
</h1>
<?php if ($id || $new) : ?>
		<form method="post" action="?p=pc">
			<?php if ($id) : ?>
				<input type="hidden" name="id" value="<?=$dispositivo->id?>" />
			<?php endif; ?>
			<label for="hostname">
				Hostname
			</label>
			<input name="hostname"  value="<?=$dispositivo->hostname?>" autofocus required  />

			<label for="modello">
				Modello
			</label>
			<input name="modello"  value="<?=date('Y-m-d',strtotime($dispositivo->modello))?>" type="date" />
			
			<label for="marche_id">
				Marca
			</label>
			<select name="marche_id">
				<option />
				<?php foreach ($marche as $a) : ?>
					<option value="<?=$a->id?>" <?=($a->id==$id) ? 'selected' :'' ?> >
						<?=$a->marca?>
					</option>
				<?php endforeach; ?>
			</select>
			<label for="sn">
				Serial Number
			</label>			
			<input name="sn"  value="<?=$dispositivo->sn?>" type="number" />

					
			
			<button type="submit" tabindex="-1">
				Salva
			</button>
			
			<a href="?p=interventi" >
				Elenco
			</a>			
			
			<a href="?p=interventi&del=<?=$ma['id']?>" tabindex="-1">
				Elimina
			</a>					
		</form>
<?php else : ?>

	<div class="tablecontainer">
		<table style="table-layout:fixed">
			<colgroup>
				<col style="width:150px" />
			</colgroup>
			<thead>
				<tr>
					<th>Marca</th>
					<th>Nome Dispositivo</th>
					<th>Modello</th>
					<th>Serial Number</th>
			
					<th style="width:60px;text-align:center">Modifica</th>
					<th style="width:60px;text-align:center">Cancella</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($dispositivo as $r) : ?>
				<tr>
					<td>
							<?=($r->marche_id) ? $r->marche->marca : ''?>
					</td>			
				
					<td>
						<?=$r->hostname?>
					</td>
					<td style="text-align:right" >
						<?=$r->modello?>
					</td>	
					<td style="text-align:right" >
						<?=$r->sn?>
					</td>	
<!--modifica-->					
					<td style="text-align:center" >
						<a href="?p=pc&id=<?=$r['id']?>">
							Mod.
						</a>
					</td>
					<td style="text-align:center" >
						<a href="?p=pc&del=<?=$r['id']?>" tabindex="-1">
							x
						</a>
					</td>	
						<td>   
						<a href="?p=pc&tabint_id=<?=$r['id']?>" tabindex="-1">
							Dettagli Int.
						</a>
						</td>					
				</tr>		
			<?php endforeach; ?>
			</tbody>
		</table>
<!--dove mette messaggio di errore e altri messaggi vedi in cima-->
		<h4 class="msg">
			<?=$msg?>
		</h4>	

	</div>
<?php endif; ?>

<a href="?p=dispositivo&create=1">Inserisci nuovo</a>
<script>
	var chg=function(e){
		console.log(e.name,e.value)
		document.forms.frm.elements[e.name].value=(e.value) ? e.value : null
	}	
</script>


<!--?php  //per chimamare tutta tabella listainterventi

	$tabint= R::getAll('select * from listainterventi');
?-->
<div class="tablecontainer">
		<table style="table-layout:fixed">
			<colgroup>
				<col style="width:150px" />
			</colgroup>
			<thead>
				<tr>
					<th>Descriz. Intervento</th>
					<th>Data Intervento</th>
					<th>Spesa</th>
					<th>Ore</th>
				</tr>
			</thead>
			<tbody>
			<?php if (!empty ($tabint)) : ?>
			<?php foreach ($tabint as $f) : ?>
				<tr>
					<td>
					    <?=$f->descrizione?>
					</td>			
				
					<td>
						<?=$f->dataintervento?>
					</td>
					<td style="text-align:left" >
						<?=$f->spesa?>
					</td>	
					<td style="text-align:center" >
						<?=$f->ore?>
					</td>							
				</tr>		
			<?php endforeach; ?>
			<?php endif; ?>
			</tbody>
		</table>
	</div>