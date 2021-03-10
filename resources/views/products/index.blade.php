<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Cars</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Cars</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active" aria-current="page" href="{{ url('/products') }}">Master Product</a>
          <a class="nav-link" href="{{ url('/orders') }}">Orders</a>
        </div>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <h1>Products</h1>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
      Add Product
    </button>

    <!-- New Product -->
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="carName" class="form-label">Car Name</label>
                <input type="text" class="form-control" id="carName">
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price">
              </div>
              <div class="mb-3">
                <label class="form-check-label" for="stock">Stock</label>
                <input type="text" class="form-control" id="stock">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Car Name</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $row)
          <tr>
            <td>{{ $row->car_name }}</td>
            <td>{{ $row->price }}</td>
            <td>{{ $row->stock }}</td>
            <td>
              <a class="btn btn-secondary editProduct" data-id="{{ $row->id }}"
                data-price="{{ $row->price }}" data-car_name="{{ $row->car_name }}" data-stock="{{ $row->stock }}">Edit</a> |
              <a class="btn btn-danger deleteProduct" data-id="{{ $row->id }}" role="button">Delete</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="modal fade" id="update-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="text" class="form-control" id="editId" hidden>
              <div class="mb-3">
                <label for="editCarName" class="form-label">Car Name</label>
                <input type="text" class="form-control" id="editCarName">
              </div>
              <div class="mb-3">
                <label for="editPrice" class="form-label">Price</label>
                <input type="text" class="form-control" id="editPrice">
              </div>
              <div class="mb-3">
                <label class="form-label" for="editStock">Stock</label>
                <input type="text" class="form-control" id="editStock">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="btn-update">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="delete-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Are you sure ?
              <input type="text" class="form-control" id="deleteId" hidden>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger" id="btn-delete">Delete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function csrfProtection() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    }
    $(document).ready(function() {
      $("#btn-save").on('click', function(e) {
        e.preventDefault()
        const carName = $('#carName').val()
        const price = Number($('#price').val())
        const stock = parseInt($('#stock').val())

        if (!carName || typeof carName !== 'string') alert('Car name should be non-empty string')
        if (!price || typeof price !== 'number') alert('Price should be non-empty number')
        if (!stock || typeof stock !== 'number') alert('Stock should be non-empty integer')

        try {
          csrfProtection()
          $.ajax({
            url: '/products',
            type: 'POST',
            dataType: 'json',
            async: true,
            data: {carName, price, stock},
            error: function (err) {
              console.error(err)
              alert(err)
              return
            },
            success: function (response) {
              console.log(response)
              if (response.status === 200) {
                alert(response.message)
                const addModal = $('#add-product')
                addModal.modal('hide')
                location.reload()
              } else alert(`New Product tottaly failed to be saved`)
              return
            }
          })
        } catch (error) {
          console.error(error)
          alert(error)
          return
        }
      })

      // Edit Modal
      $('.editProduct').on('click', function() {
        // Dari Data Table
        const productId = $(this).data('id')
        const carName = $(this).data('car_name')
        const price = $(this).data('price')
        const stock = $(this).data('stock')

        // Ke Modal
        $('#editId').val(productId)
        $('#editCarName').val(carName)
        $('#editPrice').val(price)
        $('#editStock').val(stock)
        const editModal = $('#update-product')
        editModal.modal('show')
      })

      // Edit Process
      $('#btn-update').on('click', function(e) {
        e.preventDefault()

        const id = $('#editId').val()
        const carName = $('#editCarName').val()
        const price = Number($('#editPrice').val())
        const stock = parseInt($('#editStock').val())

        try {
          if (!id || typeof id !== 'string') alert('Id should be non-empty string')
          if (!carName || typeof carName !== 'string') alert('Car name should be non-empty string')
          if (!price || typeof price !== 'number') alert('Price should be non-empty number')
          if (!stock || typeof stock !== 'number') alert('Stock should be non-empty integer')

          csrfProtection()
          $.ajax({
            url: `/products/${id}`,
            type: 'PUT',
            dataType: 'json',
            async: true,
            data: {
              id, carName, price, stock
            },
            error: function (err) {
              console.error(err)
              alert(err)
              return
            },
            success: function (response) {
              console.log(response)
              if (response.status === 200) {
                alert(response.message)
                const editModal = $('#editProduct')
                editModal.modal('hide')
                location.reload()
              } else alert(response.message)
              return
            }
          })
        } catch (err) {
          console.error(err)
          alert(err)
          return
        }
      })

      // Delete Modal
      $('.deleteProduct').on('click', function() {
        const id = $(this).data('id')
        $('#deleteId').val(id)
        const deleteModal = $('#delete-product')
        deleteModal.modal('show')
      })

      // Delete Process
      $('#btn-delete').on('click', function(e) {
        e.preventDefault()

        const id = $('#deleteId').val()

        try {
          if (!id || typeof id !== 'string') alert('Id should be non-empty string')

          csrfProtection()
          $.ajax({
            url: `/products/${id}`,
            type: 'DELETE',
            dataType: 'json',
            async: true,
            data: {},
            error: function (err) {
              console.error(err)
              alert(err)
              return
            },
            success: function (response) {
              console.log(response)
              if (response.status === 200) {
                alert(response.message)
                const deleteModal = $('#delete-product')
                deleteModal.modal('hide')
                location.reload()
              } else alert(response.message)
              return
            }
          })
        } catch (err) {
          console.error(err)
          alert(err)
          return
        }
      })
    })
  </script>
</body>
</html>