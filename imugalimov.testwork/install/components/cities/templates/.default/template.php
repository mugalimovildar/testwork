<div class="cities_info">
	
	<table class="cities_table">

		<tr>
			<th>Название</th>
			<th>Доходы общие</th>
			<th>Расходы общие</th>
			<th>Количество жителей</th>
			<th>Место в рейтинге по количеству жителей</th>
			<th>Место в рейтинге по средним доходам</th>
			<th>Место в рейтинге по средним расходам</th>
		</tr>

		<?php foreach ($arResult['cities_data'] as $curCity) : ?> 
		<tr>
			<td><?= $curCity['name']; ?></td>
			<td><?= $curCity['income']; ?></td>
			<td><?= $curCity['expenses']; ?></td>
			<td><?= $curCity['population']; ?></td>
			<td><?= $curCity['poprat']; ?></td>
			<td><?= $curCity['inrat']; ?></td>
			<td><?= $curCity['exrat']; ?></td>
		</tr>
		<?php endforeach; ?>

	</table>

</div>