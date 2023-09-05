<?php

include_once 'header.php';

$sql = "SELECT * FROM profit WHERE 1";
$result = mysqli_query($conn, $sql) or die($mysqli_error($conn));

if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
        $percentage = $row['percentage'];
    }
  }

?>


    <div class="main-content">
      <h2>Services</h2>
      <div class="search-form">
        <input
          type="text"
          id="search"
          placeholder="Search for countries or services..."
        />
      </div>
      <div class="services">
        <h2>Select Service:</h2>
        <div class="service-items">
          <!-- Service items will be dynamically generated using JavaScript -->
          <?php

$ch = curl_init();
$country = 'russia';
$operator= 'any';

curl_setopt($ch, CURLOPT_URL, 'https://5sim.net/v1/guest/products/any/any');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Accept: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

//print_r($result);

$serviceData = json_decode($result, true);

// Check if the JSON data is valid
if (!empty($serviceData)) {
  ?>
  <select name='service' id='service' class='input' required >
    <option value=''>Select Service</option>
    <?php
  foreach ($serviceData as $key => $service) {
    echo '
     <option value="' . $key . '">'.$key.'</option>
        ';
  }
}
?>
</select>
        </div>
      </div>

      <div class="countries">
        <h2>Select Country:</h2>
        <div class="country-items">
          <select class='input' name='country' id='country' required>
            <option value=''>Select country</option>
          <!-- Country items will be dynamically generated using JavaScript -->
</select> 
        </div>
      </div>
      <div class="countries">
        <h2>Select Operator:</h2>
        <div class="country-items">
          <select class='input' name='operator' id='operator' required>
            <option value=''>Select Operator</option>
</select>
</div>
</div>
<div class="countries">
        <h2>Cost:</h2>
        <div class="country-items">
          <input typr='text' class='input' name='cost' id='cost' required disabled />
       
</div>
</div>
      <button onclick="submitSelection()">Submit</button>
    </div>

    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
   <!-- ... (Your HTML content) ... -->

<script>
  // Define a variable to store the PHP percentage
  const phpPercentage = <?php echo $percentage; ?>;

  $('#service').change(() => {
    const service = $('#service').val();
    try {
      fetch(`https://5sim.net/v1/guest/products/any/any/${service}?single=0`)
        .then((response) => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json(); // Returns a promise
        })
        .then((resData) => {
          console.log(resData);
          // Process the response data here
          // Loop through the JSON data and create options for countries
          for (const key in resData) {
            if (resData.hasOwnProperty(key)) {
              const country = resData[key];
              $('#country').append(`<option value='${key}'>${key}</option>`);
            }
          }
        })
        .catch((error) => {
          console.error(error);
        });
    } catch (error) {
      console.error(error);
    }
  });

  $('#country').change(() => {
    const service = $('#service').val();
    const country = $('#country').val();
    try {
      fetch(`https://5sim.net/v1/guest/prices?product=${service}&country=${country}`)
        .then((response) => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json(); // Returns a promise
        })
        .then((resData) => {
          console.log(resData);

       
          // Access the innermost level of data and loop through operators
          const operatorData = resData[country][service];
          if (operatorData) {
            for (const operatorKey in operatorData) {
              if (operatorData.hasOwnProperty(operatorKey)) {
                // Calculate the modified cost with the PHP percentage
                const operatorCost = operatorData[operatorKey].cost + (operatorData[operatorKey].cost * phpPercentage / 100);
                $('#operator').append(`<option value="${operatorKey}" data-cost="${operatorCost}">${operatorKey}</option>`);
              }
            }
          }
        })
        .catch((error) => {
          console.error(error);
        });
    } catch (error) {
      console.error(error);
    }
  });

  $('#operator').change(() => {
    // Calculate the total cost based on the selected operator's data-cost attribute
    const selectedOperator = $('#operator option:selected');
    const totalCost = parseFloat(selectedOperator.data('cost'));
    
    // You can now use the 'totalCost' variable for further processing
    console.log('Total Cost:', totalCost);

    $('#cost').val(totalCost)
  });
</script>
</body>
</html>

  </body>
</html>
