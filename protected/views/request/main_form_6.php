<tr>
	<td><span class="qjia_span"><?php echo $item->field_name;?></span></td>
	<td class="qjia_bgcolor">
		<div class="qjia_td">
	<?php
		if ($item->field_attr == 2) {
            $body = explode("\n", current(json_decode($item->field_body)));
            foreach ($body as $line) {
                echo '<p>' . $line . '</p>';
            }
		} elseif ($item->field_attr == 1) {
            $body = json_decode($item->field_body);
            echo '<p><a href="' . $body[1] . '" target="_blank">' . $body[0] . '</a></p>';
        }
	?>
		</div>
	</td>
</tr>