<?php

include_once 'header.php';

?>


    <div class="main-content">
      <h2>Create Top Up</h2>
      <div class="top-up-form">
        <form action='topup-step2.php' method='get'>
        <div class="payment-method">
          <h3>Select Payment Method:</h3>
          <input type="radio" id="binance-pay" name="payment_method"  value="Binance" />
          <label for="binance-pay">
            <i class="fab fa-binance"></i> Binance Pay
          </label>
          <input type="radio" id="coinbase" name="payment_method" />
          <label for="coinbase">
            <i class="fab fa-cc-coinbase"></i> CoinBase
          </label>
          <input type="radio" id="paystack" name="payment_method" />
          <label for="paystack"> <i class="fas fa-wallet"></i> Paystack </label>
          <input type="radio" id="manual" name="payment_method" value="Manual" />
          <label for="manual">
            <i class="fas fa-hand-holding-usd"></i> Manual
          </label>
        </div>
        <div class="top-up-amount">
          <h3>Select Amount:</h3>
          <input type="radio" id="amount-5" name="topup_amount" value="5" />
          <label for="amount-5">$5</label>
          <input type="radio" id="amount-10" name="topup_amount" value="10" />
          <label for="amount-10">$10</label>
          <input type="radio" id="amount-25" name="topup_amount" value="25" />
          <label for="amount-25">$25</label>
          <input
            type="radio"
            id="amount-100"
            name="topup_amount"
            value="100"
          />
          <label for="amount-100">$100</label>
          <input
            type="radio"
            id="amount-250"
            name="topup_amount"
            value="250"
          />
          <label for="amount-250">$250</label>
          <input
            type="radio"
            id="amount-500"
            name="topup_amount"
            value="500"
          />
          <label for="amount-500">$500</label>
        </div>
        <button  class="top-up-button">Top Up</button>
</form>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>
