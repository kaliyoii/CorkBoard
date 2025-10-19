<?php
include '../login/auth_check.php'; // this file does session_start + redirect if not logged in

echo "Hello, " . htmlspecialchars($_SESSION['username']);
?>


<!DOCTYPE html>
<html>
<head>
	<title>CRUD PHP dan MySQLi - WWW.MALASNGODING.COM</title>
</head>
<body>
 
	<h2>CRUD DATA MAHASISWA - WWW.MALASNGODING.COM</h2>
	<br/>
	<a href="tambah.php">+ TAMBAH MAHASISWA</a>
	<br/>
	<br/>
	<table border="1">
		<tr>
			<th>no.</th>
			<th>nama</th>
			<th>title</th>
			<th>content</th>
			<th>color</th>
			<th>Pin color</th>
            <th>timestamp</th>
            <th>type</th>
            <th>img</th>
            <th>x</th>
            <th>y</th>
            <th>w</th>
            <th>h</th>
		</tr>
		<?php 
		include '../koneksi.php';
		$no = 1;
		$data = mysqli_query($koneksi,"select * from notes");
		while($d = mysqli_fetch_array($data)){
			?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><?php echo $d['user_id']; ?></td>
				<td><?php echo $d['title']; ?></td>
				<td><?php echo $d['content']; ?></td>
                <td><?php echo $d['color']; ?></td>
                <td><?php echo $d['pin_color']; ?></td>
                <td><?php echo $d['timestamp']; ?></td>
                <td><?php echo $d['type']; ?></td>
                <td><?php echo $d['img']; ?></td>
                <td><?php echo $d['x']; ?></td>
                <td><?php echo $d['y']; ?></td>
                <td><?php echo $d['w']; ?></td>
                <td><?php echo $d['h']; ?></td>
				<td>
					<a href="edit.php?id=<?php echo $d['id']; ?>">EDIT</a>
					<a href="hapus.php?id=<?php echo $d['id']; ?>">HAPUS</a>
				</td>
			</tr>
			<?php 
		}
		?>
	</table>
</body>
</html>