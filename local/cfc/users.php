<?php
 

// Sua lógica personalizada para gerenciamento de usuários aqui
echo '<h3>Lista de Usuários</h3>';
// Puxar e exibir informações sobre os usuários associados às empresas
 
$allusers = $DB->get_records_sql('SELECT u.* from {user} as u join {user_info_data} as uid on uid.userid = u.id AND uid.fieldid = (SELECT id from {user_info_field} as uif where uif.shortname = "empresa") where uid.data = "" ');
 

?> 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css"> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>
<table id="minhaTabela" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Cargo</th>
            <th>Senioridade</th>
            <th>Gestor</th>
            <th>Perfil comportamental</th>
            <th>PDI</th>
            <th>Data de cadastro</th>
        </tr>
    </thead>
    <tbody>
    	<?php 
    		foreach($allusers as $user){
    			echo '<tr>';
    				echo '<td>'.$user->id.'</td>';
    				echo '<td>'.$user->firstname.' '.$user->lastname.'</td>';
    				echo '<td>'.$user->email.'</td>';
    				$cargo = $DB->get_field_sql('SELECT data from {user_info_data} as uid join {user_info_field} as uif on uif.id = uid.fieldid where uif.shortname = "cargo" and uid.userid = '.$user->id.' ');
    				echo '<td>'.$cargo.'</td>';
    				$senioridade = $DB->get_field_sql('SELECT data from {user_info_data} as uid join {user_info_field} as uif on uif.id = uid.fieldid where uif.shortname = "senioridade" and uid.userid = '.$user->id.' ');
    				echo '<td>'.$senioridade.'</td>';
    				$gestor = $DB->get_field_sql('SELECT data from {user_info_data} as uid join {user_info_field} as uif on uif.id = uid.fieldid where uif.shortname = "gestor" and uid.userid = '.$user->id.' ');
    				echo '<td>'.$gestor.'</td>';
    				echo '<td></td>';
    				echo '<td></td>';
    				echo '<td>'.date("d/m/Y", $user->timecreated).'</td>';
    			echo '</tr>';
    		}


    	?>
    </tbody>

</table>




<script>
$(document).ready(function() {
    $('#minhaTabela').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/pt-BR.json"
        }
    });
});
</script>