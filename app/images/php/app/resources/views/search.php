<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel=”stylesheet” href=”https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css”> <title>DISQO Coding Challenge</title>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
  </script>
</head>

<body>
  <h1 class="text-center">Product Search</h1>

  <div class="container w-25">
    <form>
      <div class="form-row align-items-center">
        <div class="col-auto">
          <input type="text" class="form-control mb-2" id="search_term" placeholder="book">
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary mb-2" id="ajaxSubmit">Search</button>
        </div>
      </div>
    </form>
  </div>

  <br />
  <br />

  <div class="container">
    <table class="table table-striped table-dark" id="product_list">
      <thead>
        <tr>
          <th scope="col">Product Name</th>
          <th scope="col">Description</th>
          <th scope="col">Price</th>
          <th scope="col">SKU</th>
        </tr>
      </thead>
    </table>
  </div>

  <script>
    jQuery(document).ready(function() {
      jQuery('#ajaxSubmit').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });
        jQuery.ajax({
          url: "http://ec2-52-41-118-144.us-west-2.compute.amazonaws.com:7000/api/v1/search",
          method: 'post',
          data: {
            search_term: jQuery('#search_term').val()
          },
          success: function(result) {
            // If we get results back from search, populate the product list
            var table = document.getElementById('product_list')

            // Clear any rows first
            for (var i = table.rows.length - 1; i > 0; i--) {
              table.deleteRow(i);
            }
            
            if (result.products.length > 0) {

              for (var i = 0; i < result.products.length; i++) {
                var tr = document.createElement('tr')
                tr.appendChild(document.createElement('td'))
                tr.appendChild(document.createElement('td'))
                tr.appendChild(document.createElement('td'))
                tr.appendChild(document.createElement('td'))

                tr.cells[0].appendChild(document.createTextNode(result.products[i].product_name))
                tr.cells[1].appendChild(document.createTextNode(result.products[i].product_description))

                // The data returned from the API has 4 decimal places for greater accuracy
                // We need to represent the price in 2 decimal places
                var price = parseFloat(result.products[i].price).toFixed(2)

                tr.cells[2].appendChild(document.createTextNode('$' + price))
                tr.cells[3].appendChild(document.createTextNode(result.products[i].product_sku))

                table.appendChild(tr)
              }
            } else {
              var tr = document.createElement('tr')
              var td = tr.appendChild(document.createElement('td'))
              td.colSpan = 4
              td.align = "center"

              tr.cells[0].appendChild(document.createTextNode('No products found'))

              table.appendChild(tr)
            }
          }
        });
      });
    });
  </script>
</body>

</html>