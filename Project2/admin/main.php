<?php include '../connection/redirect.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main Page</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="contain-fluid">
<nav class="sticky-top top-0" style="background-color:white; z-index:999;">
      <ul>
        <li>
          <a class="active" href="#">Main</a>
        </li>
        <li>
          <a href="test.php">Test</a>
        </li>
        <li>
          <a href="create-user.php">Create</a>
        </li>
      </ul>
    </nav>
      <div class="main-header px-3 sticky-top bg-light" style='top:60px;'>
        <form class="d-flex" id="searchForm">
          <input class="form-control me-1" type="search"  id="searchInput" placeholder="Search by Name" aria-label="Search" style="width:260px">
        </form>
        
        

        <div class="form-inline d-flex flex-row gap-1">
          <button type="button" class="btn btn-primary" onclick="$('#addModal').modal('show')">Create</button>
          <input type="number" id="row" style="width:80px; height: 40px;" class="form-control"/>
          <button type="button" class="btn btn-success" id="filter">Filter</button>
        </div>
        
      </div>
      
      <section>
  <div class="tables container-fluid tbl-container d-flex flex-column justify-content-center align-content-center" style="height:75 vh;">
    <div class="row tbl-fixed">
      <table class="table-striped table-condensed" style="width:1920px !important;" id="myTable">
      <thead>
            <tr>
            <?php
              include '../connection/connect.php';

              $sql = "CALL update_table_column('')";
              $result = $conn->query($sql);

              if ($result && $result->num_rows > 0) {
                  $row = $result->fetch_assoc(); // Fetching only the first row
                  echo "<th class='text-center border-end border-light'>No<br><br><span ></span></th>";
                  // Iterate through each column
                  foreach ($row as $column_name => $value) {
                    
                      // Skip rendering specific columns
                      if ($column_name == 'product_pk' || $column_name == 'product_status' || $column_name == 'product_fk') {
                          continue;
                      }

                      // Define background colors for specific columns
                      $background_color = '';
                      switch ($column_name) {
                          case 'ETA':
                          case 'RMA':
                              $background_color = 'background-color: #92D050;';
                              break;
                          case 'Consignment_Stock':
                              $background_color = 'background-color: red;';
                              break;
                          case 'Pre_Order':
                              $background_color = 'background-color: #FFC000;';
                              break;
                          case 'Total':
                          case 'Current_Stock':
                              $background_color = 'background-color: #F79646;';
                              break;
                          case 'product_name';
                              $background_color = 'background-color:#4BACC6;';
                              break;
                          default:
                              $background_color = ''; // No specific background color
                      }

                      // Output the table header for each column
                      echo "<th id='$column_name' class='text-center border-end border-light' style='$background_color'>";
                      // Special treatment for specific columns
                      switch ($column_name) {
                          case 'ETA':
                              echo "ETA";
                              break;
                          case 'product_name':
                              echo "Product Name <br>";
                              break;
                          case 'RMA':
                              echo "RMA";
                              break;
                          case 'Consignment_Stock':
                              echo "Consignment Stock";
                              break;
                          case 'Pre_Order':
                              echo "Pre Order";
                              break;
                          case 'Total':
                              echo "Total";
                              break;
                          case 'Current_Stock':
                              echo "Current Stock";
                              break;
                          default:
                              // Output column name as is for other columns
                              echo $column_name;
                      }
                      echo "<br><span id='$column_name'></span><span id='{$column_name}_sum'></span></th>";
                  }
              }
              ?>

            </tr>

          </thead>
           <tbody>

          </tbody>
      </table>
    </div>
  </div>
</section>

      
    <div class="buttons d-flex align-content-end justify-content-end mt-3 px-2">
      <div class="page-of">Page <span id="current-page">1</span> of <span id="total-pages">1</span></div>
      <button id="prev-btn">Prev</button>
      <input type="number" placeholder="1" id="page-number" disabled>
      <button id="next-btn">Next</button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" style="--bs-modal-width: 1000px !important;" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h2 class="modal-title" id="addModalLabel">Create</h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="process_form.php">
                    <div class="row g-3" style="display: flex; flex-wrap: nowrap; overflow-x: auto;">
                        <?php
                            include '../connection/connect.php';

                            $sql = "SELECT
                            COLUMN_NAME AS department_name
                            FROM INFORMATION_SCHEMA.COLUMNS
                            WHERE TABLE_NAME = 'tblproduct_transaction'
                            AND ORDINAL_POSITION >= 2;";
                            $result = $conn->query($sql); // Execute the query

                            if ($result && $result->num_rows > 0) {
                                // Fetch column names from the database
                                $first = true; // Flag to track the first column
                                while ($row = $result->fetch_assoc()) {
                                    $department_name = $row["department_name"];
                                    ?>
                                    <div class="col-12 mb-3" style="flex: 0 0 auto; width: 200px;">
                                        <label class="form-label text-center fw-bolder w-100"><?= $department_name ?></label>
                                        <input type="text" class="form-control<?= $first ? ' required' : '' ?>" id="<?= $department_name ?>" name="<?= $department_name ?>"<?= $first ? ' required' : '' ?>>
                                    </div>
                                    <?php
                                    $first = false; // Unset flag after the first iteration
                                }
                            } else {
                                echo "<p>No results found</p>"; // Output if no results found
                            }
                        ?>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit_input" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/jquery.tabledit.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- Make tbody editable -->
<script>
  $(document).ready(function() {
    var currentPage = 1; // Current page
    var rowsPerPage = 20; // Number of rows per page
    var totalRecords; // Total number of records
    var data; // Variable to hold the fetched data

    // Click event handler for editing cells
    $(document).on("click", "td.editable", function() {
      var cell = $(this);
      var oldValue = cell.text().trim();
      var column = cell.attr("data-column");

      // Set the contenteditable attribute to true to make the cell editable
      cell.attr("contenteditable", "true").focus();

      // On blur event, send AJAX request to update the value
      cell.one("blur", function() {
        var newValue = cell.text().trim();
        updateValue(cell, newValue, oldValue, column);
      });

      // On pressing Enter key, confirm the edited value
      cell.on("keydown", function(event) {
        if (event.key === "Enter") {
          event.preventDefault(); // Prevent default behavior of Enter key
          var newValue = cell.text().trim();
          updateValue(cell, newValue, oldValue, column);
        }
      });

      // Input validation for numeric columns
      if (column !== "product_name") {
        cell.on("input", function(event) {
          var value = $(this).text().trim();
          if (isNaN(value)) {
            $(this).text(oldValue); // Revert the cell text to the original value
          }
        });
      }
    });


     // Event listener for form submission
     $("#searchForm").submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Retrieve the search input value
        var searchText = $("#searchInput").val().trim();

        // Call the function to fetch data with the search text
        fetchData(searchText);
    });

    // Function to fetch updated data from the server
    function fetchData(searchText = '') {
        // Modify your SQL query to include the search text as a parameter
        $.ajax({
            url: "fetch_data.php?search=" + searchText,
            type: "GET",
            dataType: "json",
            success: function(response) {
                data = response;
                totalRecords = data.length;
                updateTable(data);
                updatePagination();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    }

    // Call fetchData when the page loads to fetch initial data
    fetchData();

    // Update the table content with the fetched data
    function updateTable(data) {
        $('tbody').empty(); // Clear existing table rows

        if (data.length === 0) {
        // If no results found, display message in a single cell row
        var tr = $("<tr>").appendTo("tbody");
        $("<td colspan='100'>").text("No results found").appendTo(tr);
        return;
    }

        var startIndex = (currentPage - 1) * rowsPerPage;
        var endIndex = startIndex + rowsPerPage;
        var paginatedData = data.slice(startIndex, endIndex);

        // Calculate the starting loop ID for the current page
        var startingLoopId = (currentPage - 1) * rowsPerPage + 1;

        $.each(paginatedData, function(index, row) {
            var tr = $("<tr>").attr("id", "row_" + row.product_pk);

            // Add a loop ID column
            var loopIdTd = $("<td>").text(startingLoopId + index);
            tr.append(loopIdTd);

            $.each(row, function(column_name, value) {
                if (column_name !== 'product_pk' && column_name !== 'product_status' && column_name !== 'product_fk') {
                    var td = $("<td>").attr({
                        "id": column_name,
                        "class": "editable",
                        "data-column": column_name,
                        "contenteditable": "true",
                        "type": "number"
                    }).text(value);
                    tr.append(td);
                }
            });
            $('tbody').append(tr);
        });
    }

    function updateValue(cell, newValue, oldValue) {
      var column = cell.attr("data-column");

      // If column is not product_name, validate if newValue is numeric
      if (column !== "product_name" && isNaN(newValue)) {
        alert("Please enter a valid numeric value.");
        cell.text(oldValue); // Revert the cell text to the original value
        return;
      }

      var productId = cell.closest("tr").attr("id").split("_")[1]; // Extract product ID

      // Send AJAX request to update the value
      $.ajax({
        url: "update.php",
        type: "POST",
        data: {
          id: productId,
          column: column,
          newValue: newValue
        },
        dataType: "json",

        success: function(response) {
          console.log("AJAX Success:", response);
          if (response.success) {
            cell.text(newValue); // Update the cell text with the new value
            // Retrieve the search input value
            var searchText = $("#searchInput").val().trim();
            fetchData(searchText); // Fetch new data after successful update
          } else {
            console.error("Update failed:", response.message);
            cell.text(oldValue); // Revert the cell text to the original value
          }
        },

        error: function(xhr, status, error) {
          console.error("AJAX Error:", error);
          cell.text(oldValue); // Revert the cell text to the original value
        },
        complete: function() {
          // Remove the contenteditable attribute and reattach click event handler
          cell.removeAttr("contenteditable");
        }
      });
    }

    // Combine filtering and pagination logic
    $('#filter').on('click', function() {
      const rowLimit = $('#row').val();
      filterAndPaginate(rowLimit);
    });

    function filterAndPaginate(rowLimit) {
      const $table = $("#myTable");
      const $tbodyRows = $table.find("tbody tr");
      $tbodyRows.hide();

      if (!rowLimit || parseInt(rowLimit) <= 0) {
        // Show error message or handle this case as per your requirement
        location.reload();
        return;
      } else {
        $tbodyRows.slice(0, parseInt(rowLimit)).show();
      }

      currentPage = 1;
      rowsPerPage = parseInt(rowLimit); // Update rowsPerPage based on the filtered value
      fetchData();
    }

  });
</script>
<!-- Sum Column -->
<script>
    $(document).ready(function() {
    // Function to calculate and update sums
    function updateSums() {
        // AJAX request to fetch sum data from server
        $.ajax({
            url: 'fetch_sums.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // Update sums in the table
                $.each(data, function(columnName, total) {
                    $('#' + columnName + '_sum').text('(' + total + ')');
                });
                
                // Call updateSums again after current update completes
                updateSums();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching sums:', error);
                
                // Call updateSums again in case of error
                updateSums();
            }
        });
    }

    // Initial calculation and update on page load
    updateSums();
});
</script>
</html>