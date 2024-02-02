<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kentucky Fried Weed</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="css/styles1.css">
</head>
<body>

  <main>
    <section id="home">
    <?php include('header.php'); ?>
      <div class="content">
        <h2 style="color:green">Lorem Ipsum</h2>
        <button class="purchase-button">Purchase Now</button>
      </div>
    </section>

    <h2 style="padding-top:15px;">Featured products</h2>

    <section class="products">
      <?php
      // Include the database connection script
      require_once 'database.php';

      // Query to retrieve product information from the database
      $query = "SELECT * FROM products";
      $result = mysqli_query($db, $query);

      // Check if there are any products in the database
      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              // Output product card HTML for each product
              echo '<div class="product-card">';
              echo '<img src="' . $row['image_path'] . '" alt="Product">';
              echo '<h2>' . $row['product_name'] . '</h2>';
              echo '<p>' . $row['description'] . '</p>';
              echo '<p>$' . number_format($row['price'], 2) . '</p>';
              echo '<a href="product_detail.php?product_id=' . $row['product_id'] . '" class="product-link">Go to Product Page</a>';
              echo '</div>';
          }
      } else {
          echo '<p>No products available.</p>';
      }

      // Close the database connection
      mysqli_close($db);
      ?>
    </section>

    <section class="why-choose-us">
      <h2>Why Choose Us?</h2>
      <div class="reasons">
        <div class="reason-card">
          <h3>Quality Ingredients</h3>
          <p>We source only the freshest and finest ingredients for our dishes.</p>
        </div>
        <div class="reason-card">
          <h3>Unique Flavors</h3>
          <p>Experience a fusion of flavors that sets us apart from the rest.</p>
        </div>
        <div class="reason-card">
          <h3>Exceptional Service</h3>
          <p>Our team is dedicated to providing top-notch service to all our customers.</p>
        </div>
      </div>
    </section>
    
    <section class="faq-section">
      <h2 style="padding-bottom: 30px;">Frequently Asked Questions</h2>
      <div class="accordion-container">
        <div class="accordion">
          <input type="checkbox" id="faq-1" class="accordion-toggle">
          <label for="faq-1" class="accordion-btn">Question 1: How do I place an order?</label>
          <div class="accordion-content">
            <p>To place an order, simply visit our website and select the desired items from the menu. You can also call our customer service to assist you with your order.</p>
          </div>
          
          <input type="checkbox" id="faq-2" class="accordion-toggle">
          <label for="faq-2" class="accordion-btn">Question 2: What is your return policy?</label>
          <div class="accordion-content">
            <p>We have a 30-day return policy for unused and unopened items. Please refer to our Returns & Refunds page for more details.</p>
          </div>
          
          <!-- Add more questions and answers -->
          
          <input type="checkbox" id="faq-3" class="accordion-toggle">
          <label for="faq-3" class="accordion-btn">Question 3: Do you offer catering services?</label>
          <div class="accordion-content">
            <p>Yes, we provide catering services for events and gatherings. Contact us for more information and bookings.</p>
          </div>
          
          <input type="checkbox" id="faq-4" class="accordion-toggle">
          <label for="faq-4" class="accordion-btn">Question 4: Are gift cards available?</label>
          <div class="accordion-content">
            <p>Yes, we offer gift cards that can be purchased online or at our physical locations.</p>
          </div>
          
          <input type="checkbox" id="faq-5" class="accordion-toggle">
          <label for="faq-5" class="accordion-btn">Question 5: How can I contact customer support?</label>
          <div class="accordion-content">
            <p>You can reach our customer support team via phone, email, or through the contact form on our website.</p>
          </div>
        </div>
      </div>
    </section>


    <?php include('footer.php'); ?>

  <script src="script.js"></script>
</body>
</html>