$(document).ready(function () {
  // Event listener for navigation links
  $(".nav-link").on("click", function (e) {
    e.preventDefault(); // Prevent default anchor click behavior
    $(".nav-link").removeClass("link-active"); // Remove active class from all links
    $(this).addClass("link-active"); // Add active class to the clicked link

    let url = $(this).attr("href"); // Get the URL from the href attribute
    window.history.pushState({ path: url }, "", url); // Update the browser's URL without reloading
  });

  // Function to load products view
  function viewProducts() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../products/view-products.php", // URL for products view
      dataType: "html", // Expect HTML response
      success: function (response) {
        $(".content-page").html(response); // Load the response into the content area

        // Initialize DataTable for product table
        var table = $("#table-products").DataTable({
          dom: "rtp", // Set DataTable options
          pageLength: 10, // Default page length
          ordering: false, // Disable ordering
        });

        // Bind custom input to DataTable search
        $("#custom-search").on("keyup", function () {
          table.search(this.value).draw(); // Search products based on input
        });

        // Bind change event for category filter
        $("#category-filter").on("change", function () {
          if (this.value !== "choose") {
            table.column(3).search(this.value).draw(); // Filter products by selected category
          }
        });

        // Event listener for adding a product
        $("#add-product").on("click", function (e) {
          e.preventDefault(); // Prevent default behavior
          addProduct(); // Call function to add product
        });

        // Event listener for adding a product
        $(".edit-product").on("click", function (e) {
          e.preventDefault(); // Prevent default behavior
          editProduct(this.dataset.id); // Call function to add product
        });

        $(".stockin-stockout").on("click", function (e) {
          e.preventDefault(); // Prevent default behavior
          editStock(this.dataset.id); // Call function to add product
        });
      },
    });
  }

  function editStock(productId) {
    $.ajax({
      type: "GET", // Use GET request
      url: "../products/stock.html", // URL to get product data
      dataType: "html", // Expect JSON response
      success: function (view) {
        // Assuming 'view' contains the new content you want to display
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#staticBackdropedit").attr("data-id", productId);

        // Event listener for the add product form submission
        $("#form-stock-product ").on("submit", function (e) {
          e.preventDefault(); // Prevent default form submission
          updateStock(productId); // Call function to save product
        });
      },
    });
  }

  // Function to update the stock of product
  function updateStock(productId) {
    $.ajax({
      type: "POST", // Use POST request
      url: `../products/stock.php?id=${productId}`, // URL for saving product
      data: $("form").serialize(), // Serialize the form data for submission
      dataType: "json", // Expect JSON response
      success: function (response) {
        if (response.status === "error") {
          // Handle validation errors
          if (response.quantityErr) {
            $("#quantity").addClass("is-invalid"); // Mark field as invalid
            $("#quantity").next(".invalid-feedback").text(response.quantityErr).show(); // Show error message
          } else {
            $("#quantity").removeClass("is-invalid"); // Remove invalid class if no error
          }

          if (response.statusErr) {
            $('input[name="status"]').addClass("is-invalid");
            $(".status-feedback").text(response.statusErr).show();
          } else {
            $('input[name="status"]').removeClass("is-invalid");
            $(".status-feedback").hide();
          }          

          if (response.reasonErr) {
            $("#reason").addClass("is-invalid"); // Mark field as invalid
            $("#reason").next(".invalid-feedback").text(response.reasonErr).show(); // Show error message
          } else {
            $("#reason").removeClass("is-invalid"); // Remove invalid class if no error
          }
              
        } else if (response.status === "success") {
          // On success, hide modal and reset form
          $("#staticBackdropedit").modal("hide");
          $("form")[0].reset(); // Reset the form
          // Optionally, reload products to show new entry
          viewProducts();
        }
      },
    });
  }
});
