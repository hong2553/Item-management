<?php
$conn = mysqli_connect("localhost:3305","root","","item_management");

if(!$conn){
    die("DB connection failed");
}

$name="";
$price="";
$quantity="";
$id=0;
$edit=false;

/* ADD */
if(isset($_POST['add'])){
$name=$_POST['name'];
$price=$_POST['price'];
$quantity=$_POST['quantity'];

mysqli_query($conn,"INSERT INTO items(name,price,quantity)
VALUES('$name','$price','$quantity')");
}

/* DELETE */
if(isset($_GET['delete'])){
$id=$_GET['delete'];
mysqli_query($conn,"DELETE FROM items WHERE id=$id");
}

/* EDIT */
if(isset($_GET['edit'])){
$id=$_GET['edit'];
$edit=true;

$result=mysqli_query($conn,"SELECT * FROM items WHERE id=$id");
$row=mysqli_fetch_assoc($result);

$name=$row['name'];
$price=$row['price'];
$quantity=$row['quantity'];
}

/* UPDATE */
if(isset($_POST['update'])){
$id=$_POST['id'];
$name=$_POST['name'];
$price=$_POST['price'];
$quantity=$_POST['quantity'];

mysqli_query($conn,"UPDATE items
SET name='$name',price='$price',quantity='$quantity'
WHERE id=$id");

$edit=false;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Item Manager</title>

<style>

body{
font-family:Arial;
background:#f4f6f8;
max-width:750px;
margin:40px auto;
}

.form-box{
background:white;
padding:25px;
border-radius:8px;
box-shadow:0 2px 5px rgba(0,0,0,0.1);
margin-bottom:20px;
text-align:center;
}

form{
display:flex;
flex-direction:column;
align-items:center;
}

input{
width:70%;
padding:8px;
margin-bottom:10px;
border:1px solid #ccc;
border-radius:4px;
}

button{
padding:10px;
border:none;
background:#4CAF50;
color:white;
border-radius:5px;
cursor:pointer;
width:70%;
}

button:hover{
background:#45a049;
}

.table-box{
background:white;
padding:20px;
border-radius:8px;
box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

.table-scroll{
max-height:300px;
overflow-y:auto;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:10px;
border-bottom:1px solid #eee;
text-align:left;
}

th{
background:#fafafa;
position:sticky;
top:0;
z-index:1;
}

.btn-edit{
background:#3498db;
color:white;
padding:5px 10px;
border-radius:4px;
font-size:13px;
text-decoration:none;
}

.btn-edit:hover{
background:#2d83bd;
}

.btn-delete{
background:#e74c3c;
color:white;
padding:5px 10px;
border-radius:4px;
font-size:13px;
text-decoration:none;
}

.btn-delete:hover{
background:#c0392b;
}

</style>

</head>
<body>

<h2>Item Manager</h2>

<!-- FORM -->

<div class="form-box">

<form method="POST">

<input type="hidden" name="id" value="<?php echo $id ?>">

<input type="text" name="name" placeholder="Item name" value="<?php echo $name ?>" required>

<input type="number" step="0.01" name="price" placeholder="Price" value="<?php echo $price ?>" required>

<input type="number" name="quantity" placeholder="Quantity" value="<?php echo $quantity ?>" required>

<?php if($edit){ ?>

<button name="update">Update Item</button>

<?php } else { ?>

<button name="add">Add Item</button>

<?php } ?>

</form>

</div>

<!-- TABLE -->

<div class="table-box">

<div class="table-scroll">

<table>

<tr>
<th>Name</th>
<th>Price</th>
<th>Qty</th>
<th>Action</th>
</tr>

<?php
$result=mysqli_query($conn,"SELECT * FROM items");

while($row=mysqli_fetch_assoc($result)){
?>

<tr>
<td><?php echo $row['name'] ?></td>
<td><?php echo $row['price'] ?></td>
<td><?php echo $row['quantity'] ?></td>
<td>
<a class="btn-edit" href="?edit=<?php echo $row['id'] ?>">Edit</a>
<a class="btn-delete" href="?delete=<?php echo $row['id'] ?>">Delete</a>
</td>
</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>