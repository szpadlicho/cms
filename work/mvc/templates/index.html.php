<?php //header('Content-Type: text/html; charset=utf-8'); ?>
<table border="1">
<?php foreach ($res as $row) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['content']; ?></td>
        <td><?php echo $row['date_add']; ?></td>
        <td><?php echo $row['autor']; ?></td>
    </tr>
<?php } ?>
<table>