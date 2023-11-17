<?php 
session_start();
if ($_SESSION['role'] != 'admin') {
    echo "
    <script>
    alert('Halaman ini hanya bisa di akses oleh admin');
    window.location = 'profile.php';
    </script>
    ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./plugin/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Products</title>
    <style>
.modal-content {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Alya Khairunnisa</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="./index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">History</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="#">Products</a>
              </li>
            </ul>
              <a href="backend/logout.php" class="btn btn-danger">Logout</a>
          </div>
        </div>
</nav>
    <div style="border: none !important" class="card m-1">
      <div class="card-body">
        <div class="card-title d-flex justify-content-between">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Data</button>
        </div>
    <table class="table">
        <thead class="table-primary">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama produk</th>
                <th scope="col">Harga</th>
                <th scope="col">Gambar Produk</th>
                <th scope="col">Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                require './config/db.php';
                $base_url = "http://localhost";
                $products = mysqli_query($db_connect,"SELECT * FROM products");
                $no = 1;
                while($row = mysqli_fetch_assoc($products)) {
            ?>
                <tr>
                    <td><?=$no++;?></td>
                    <td><?=$row['name'];?></td>
                    <td>Rp <?= number_format($row['price'], 0, ',', '.'); ?></td>
                    <!-- <td><img src="<?=$row['image'];?>" width="100"></td> -->
                    <td>
                    <button id="myImg" class="btn btn-info" data-image-url="<?php echo $base_url . $row['image']; ?>" data-bs-toggle="modal" data-bs-target="#imageModal">
                        <i class="fa fa-eye" aria-hidden="true"></i> Lihat
                    </button>
                    </td>

                    <td>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-edit-id="<?php echo $row['id']; ?>" onclick="prepareEditModal(<?php echo $row['id']; ?>)">
        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
    </button>
                        <button onclick="hapus(<?php echo $row['id']; ?>)" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Hapus</button>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="editForm" method="post" action="backend/edit.php?id=<?php echo $row['id']; ?>" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="Name" class="form-label">Name</label>
    <input type="text" name="name" class="form-control" id="Name" aria-describedby="emailHelp" required value="<?php echo $row['name']; ?>">
  </div>
  <div class="mb-3">
    <label for="Price" class="form-label">Price</label>
    <input type="number" name="price" class="form-control" id="Price" aria-describedby="emailHelp" required value="<?php echo $row['price']; ?>">
  </div>
  <div class="mb-3">
    <label for="Image" class="form-label">Image</label>
    <input type="file" name="image" class="form-control" id="Image" aria-describedby="emailHelp" required>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <input type="submit" name="update" class="btn btn-primary" value="Edit">
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="post" action="backend/create.php" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="Name" class="form-label">Name</label>
    <input type="text" name="name" class="form-control" id="Name" aria-describedby="emailHelp" required>
  </div>
  <div class="mb-3">
    <label for="Price" class="form-label">Price</label>
    <input type="number" name="price" class="form-control" id="Price" aria-describedby="emailHelp" required>
  </div>
  <div class="mb-3">
    <label for="Image" class="form-label">Image</label>
    <input type="file" name="image" class="form-control" id="Image" aria-describedby="emailHelp" required>
  </div>
  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <input type="submit" name="submit" class="btn btn-primary" value="Tambah">
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div style=" max-width: 80% !important;" class="modal-dialog">
      <div class="modal-body">
      <button type="button" style="float: right !important; background-color:aliceblue !important;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <img class="modal-content" id="img01">
      </div>
    </div>
</div>
      </div>
    </div>
    <script>
    var buttons = document.getElementsByClassName("btn-info");
    var modal = document.getElementById("imageModal");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener("click", function () {
            modal.style.display = "block";
            modalImg.src = this.getAttribute("data-image-url");
            captionText.innerHTML = this.innerText;
        });
    }
    var closeModalButton = document.getElementById("closeModalButton");
    closeModalButton.onclick = function () {
        modal.style.display = "none";
    }
</script>
<script src="plugin/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function hapus(id_user){
    Swal.fire({
        title: 'Anda yakin ingin menghapus produk ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1583ff',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batalkan',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "backend/delete.php?id=" + id_user;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            return false;
        }
    });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
        document.body.addEventListener('click', function (event) {
            if (event.target.getAttribute('data-edit-id')) {
                var editForm = document.getElementById("editForm");
                var editId = event.target.getAttribute("data-edit-id");
                var editFormAction = "backend/edit.php?id=" + editId;
                editForm.action = editFormAction;
                myModal.show();
            }
        });
    });
</script>


</body>
</html>