<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
          <a class="nav-link" href="{{ url('/products') }}">Master Product</a>
          <a class="nav-link active" aria-current="page" href="{{ url('/orders') }}">Orders</a>
        </div>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <h1>Orders</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new-order">
      Orders
    </button>

    <!-- New Product -->
    <div class="modal fade" id="new-order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">New Order</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="buyerName" class="form-label">Buyer Name</label>
                <input type="text" class="form-control" id="buyerName">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email">
              </div>
              <div class="mb-3">
                <label class="form-label" for="phone">Phone</label>
                <input type="text" class="form-control" id="phone">
              </div>
              <div class="mb-3">
                <label class="form-label" for="phone">Car</label>
                <select class="form-select" aria-label="Car" id="carId">
                  <option selected disabled>Choose the car</option>
                  @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->car_name }}</option>
                  @endforeach
                </select>
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
    <hr>
    <div class="container-fluid">
      <h3>Today</h3>
      <table class="table table-striped">
        <tbody>
          <tr>
            <td>Most Valuable Product</td>
            <td>{{ $mvpToday->car_name }}</td>
          </tr>
          <tr>
            <td>Sales</td>
            <td>{{ $mvpToday->total }}</td>
          </tr>
          <tr>
            <td>Total Sales</td>
            <td>{{ $mvpToday->total * $mvpToday->price }}</td>
          </tr>
        </tbody>
      </table>
      <hr>
      <h3>Per 7 Days</h3>
      <table class="table table-striped">
        <tbody>
          <tr>
            <td>Most Valuable Product</td>
            <td>{{ $mvpOneWeek->car_name }}</td>
          </tr>
          <tr>
            <td>Sales</td>
            <td>{{ $mvpOneWeek->total }}</td>
          </tr>
          <tr>
            <td>Total Sales</td>
            <td>{{ $mvpOneWeek->total * $mvpOneWeek->price }}</td>
          </tr>
        </tbody>
      </table>
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
      $('#btn-save').on('click', function(e) {
        e.preventDefault()
        const buyerName = $('#buyerName').val()
        const email = $('#email').val()
        const phone = $('#phone').val()
        const carId = $('#carId').val()

        if (!buyerName || typeof buyerName !== 'string') alert('Buyer name should be non-empty string')
        if (!email || typeof email !== 'string') alert('Email should be non-empty string')
        if (!phone || typeof phone !== 'string') alert('Phone should be non-empty string')
        if (!carId || typeof carId !== 'string') alert('Car Id should be non-empty string')

        try {
          csrfProtection()
          $.ajax({
            url: '/orders/buy',
            type: 'POST',
            dataType: 'json',
            async: true,
            data: {buyerName, email, phone, carId},
            error: function (err) {
              console.error(err)
              alert(err)
              return
            },
            success: function (response) {
              console.log(response)
              if (response.status === 200) {
                alert(response.message)
                const addModal = $('#new-order')
                addModal.modal('hide')
                location.reload()
              } else alert(response.message)
              return
            }
          })
        } catch (error) {
          console.error(error)
          alert(error)
          return
        }
      })
    })
  </script>
</body>
</html>